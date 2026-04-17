<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Driver::with(['warehouse'])->where('hide', 0)->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function list()
    {
        $data= Driver::with(['warehouse'])->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'warehouse_id' => 'required|string|max:255',
        ]);

        $input = $validated;
        $input['uuid'] = $this->getUuid(10);
        $input['hide'] = 0;
        $input['created_at'] = now();
        $input['updated_at'] = now();

        $data = Driver::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới tài xế thành công',
            'data' => $data,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $uuid = $request->route('uuid') ?? $id;

        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin tài xế để cập nhật',
            ], 422);
        }

        $validated = $request->validate([
            'driver_name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'warehouse_id' => 'required|string|max:255',
        ]);

        $updated = Driver::where('uuid', $uuid)->update([
            'driver_name' => $validated['driver_name'],
            'mobile' => $validated['mobile'] ?? '',
            'warehouse_id' => $validated['warehouse_id'],
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Tài xế không tồn tại',
            ], 404);
        }

        $data = Driver::where('uuid', $uuid)->first();

        return response()->json([
            'success' => true,
            'message' => 'Câp nhật thông tin thành công',
            'data' => $data,
        ]);
    }   

    public function delete(string $uuid)
    {
        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin để xóa',
            ], 422);
        }

        $check = Order::where('driver_id', function ($query) use ($uuid) {
            $query->select('id')
                ->from('drivers')
                ->where('uuid', $uuid);
        })->exists();

        if ($check) {   
            return response()->json([
                    'success' => false,
                    'message' => 'Tài xế này đã tồn tại trong phiếu giao hàng rồi. Vui lòng ẩn thông tin tài xế này đi thay vì xóa nhé.',
            ], 422);
        }else{
            Driver::where('uuid', $uuid)->delete();
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
                'message' => 'Không tìm thấy tài xế để ẩn/hiện',
            ], 422);
        }

        $data = Driver::where('uuid', $uuid)->first();

        $hide= $data->hide==0 ? 1 : 0; 

        $data->hide = $hide;
        $data->updated_at = now();
        $data->save();

        return response()->json([
            'success' => true,
            'message' => $hide== 1 ? 'Ẩn thông tin thành công' : 'Hiện thông tin thành công',
            'data' => $data,
        ]);
    }
}
