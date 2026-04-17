<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::where('hide',0)->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function list()
    {
        $data = Role::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $input = $validated;
        $input['uuid'] = $this->getUuid(10);
        $input['hide'] = 0;
        $input['created_at'] = now();
        $input['updated_at'] = now();

        $data = Role::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới vai trò thành công',
            'data' => $data,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $uuid = $request->route('uuid') ?? $id;

        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin vai trò để cập nhật',
            ], 422);
        }

        $validated = $request->validate([
            'role_name' => 'required|string|max:255',
            'hide' => 'nullable|integer|in:0,1',
        ]);

        $updated = Role::where('uuid', $uuid)->update([
            'role_name' => $validated['role_name'],
            'hide' => $validated['hide'] ?? 0,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Vai trò không tồn tại',
            ], 404);
        }

        $data = Role::where('uuid', $uuid)->first();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'data' => $data,
        ]);
    }   

    public function delete(string $uuid)
    {
        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin vai trò để xóa',
            ], 422);
        }

        $check = User::where('role_id', function ($query) use ($uuid) {
            $query->select('id')
                ->from('roles')
                ->where('uuid', $uuid);
        })->exists();

        if ($check) {   
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa vai trò vì có người dùng đang sử dụng',
            ], 422);
        } else {
            Role::where('uuid', $uuid)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa thông tin thành công',
            ]);
        }
    }

    public function hide(string $uuid)
    {
        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin vai trò để ẩn/hiện',
            ], 422);
        }

        $data = Role::where('uuid', $uuid)->first();

        $hide = $data->hide == 0 ? 1 : 0; 

        $data->hide = $hide;
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => $hide == 1 ? 'Ẩn thông tin thành công' : 'Hiện thông tin thành công',
            'data' => $data,
        ]);
    }
}
