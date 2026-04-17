<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function list()
    {
        $data = Priority::orderBy('updated_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'priority_name' => 'required|string|max:255',
            'priority_name_en' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
        ]);

        $input = $validated;
        $input['uuid'] = $this->getUuid(10);
        $input['hide'] = 0;
        $input['created_at'] = now();
        $input['updated_at'] = now();

        $data = Priority::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới độ ưu tiên thành công',
            'data' => $data,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $uuid = $request->route('uuid') ?? $id;

        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu thông tin độ ưu tiên để cập nhật',
            ], 422);
        }

        $validated = $request->validate([
            'priority_name' => 'required|string|max:255',
            'priority_name_en' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'hide' => 'nullable|integer|in:0,1',
        ]);

        $updated = Priority::where('uuid', $uuid)->update([
            'priority_name' => $validated['priority_name'],
            'priority_name_en' => $validated['priority_name_en'] ?? '',
            'color' => $validated['color'] ?? '',
            // 'hide' => $validated['hide'] ?? 0,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Độ ưu tiên không tồn tại',
            ], 404);
        }

        $data = Priority::where('uuid', $uuid)->first();

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
                'message' => 'Thiếu thông tin độ ưu tiên để xóa',
            ], 422);
        }

        $check = Order::where('priority_id', function ($query) use ($uuid) {
            $query->select('id')
                ->from('priorities')
                ->where('uuid', $uuid);
        })->exists();

        if ($check) {   
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa độ ưu tiên vì có đơn hàng đang sử dụng',
            ], 422);
        } else {
            Priority::where('uuid', $uuid)->delete();
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
                'message' => 'Thiếu thông tin độ ưu tiên để ẩn/hiện',
            ], 422);
        }

        $data = Priority::where('uuid', $uuid)->first();

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
