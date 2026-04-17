<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with(['role','warehouse'])->where('hide',0)->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function list()
    {
        $data= User::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {   
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_code' => 'required|string|max:255|unique:users,employee_code',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',            
        ]);

        $input = $validated;
        $password = $validated['password'];        
        $input['uuid'] = $this->getUuid(10);
        $input['password'] = Hash::make($password); // Mật khẩu mặc định, bạn có thể thay đổi theo nhu cầu
        $input['hide'] = 0;
        $input['created_at'] = now();
        $input['updated_at'] = now();

        $data = User::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới người dùng thành công',
            'data' => $data,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $userId = $request->route('id') ?? $id;
        $request->merge([
            'warehouse_id' => filter_var($request->warehouse_id, FILTER_VALIDATE_INT) !== false
                ? (int) $request->warehouse_id
                : null,
        ]);
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin người dùng để cập nhật',
            ], 422);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_code' => 'required|string|max:255|unique:users,employee_code,' . $userId,
            'email' => 'required|max:255|unique:users,email,' . $userId,
            'role_id' => 'required|integer|exists:roles,id',
            'warehouse_id' => 'nullable|integer|exists:warehouses,id',
        ]);


        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'employee_code' => $validated['employee_code'],
            'role_id' => $validated['role_id'],
            'warehouse_id' => $validated['warehouse_id'] ?? null,
            'updated_at' => now(),
        ];       

        $updated = User::where('id', $userId)->update($updateData);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }

        $data = User::where('id', $userId)->first();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'data' => $data,
        ]);
    }

    public function delete(string $id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin người dùng để xóa',
            ], 422);
        }

        $check = Order::where('user_id', $id)->exists();

        if ($check) {   
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa người dùng vì có đơn hàng đang sử dụng',
            ], 422);
        } else {
            User::where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa thông tin thành công',
            ]);
        }
    }

    public function hide(string $id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin người dùng để ẩn/hiện',
            ], 422);
        }

        $data = User::where('id', $id)->first();

        $active = $data->active == 1 ? 0 : 1; 

        $data->active = $active;
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => $active == 0 ? 'Ẩn thông tin thành công' : 'Hiện thông tin thành công',
            'data' => $data,
        ]);
    }
    public function resetPassword(Request $request, string $id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin người dùng để đặt lại mật khẩu',
            ], 422);
        }

        $data = User::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }
        $passsword = $request->input('password');
        $data->password = Hash::make($passsword); // Mật khẩu mặc định, bạn có thể thay đổi theo nhu cầu
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Đặt lại mật khẩu thành công',
            'data' => $data,
        ]);
    }
}
