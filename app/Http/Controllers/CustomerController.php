<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $data= Customer::orderBy('updated_at', 'desc')->get();
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
            'customer_name' => 'required|string|max:255',
            'customer_name_en' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
        ]);

        $input = $validated;
        $input['uuid'] = $this->getUuid(10);
        $input['hide'] = 0;
        $input['created_at'] = now();
        $input['updated_at'] = now();

        $customer = Customer::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới khách hàng thành công',
            'data' => $customer,
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
                'message' => 'Thiếu thông tin khách hàng để cập nhật',
            ], 422);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_name_en' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'hide' => 'nullable|integer|in:0,1',
        ]);

        $updated = Customer::where('uuid', $uuid)->update([
            'customer_name' => $validated['customer_name'],
            'customer_name_en' => $validated['customer_name_en'] ?? '',
            'address' => $validated['address'] ?? '',
            'mobile' => $validated['mobile'] ?? '',
            'hide' => $validated['hide'] ?? 0,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Khách hàng không tồn tại',
            ], 404);
        }

        $customer = Customer::where('uuid', $uuid)->first();

        return response()->json([
            'success' => true,
            'message' => 'Câp nhật khách hàng thành công',
            'data' => $customer,
        ]);
    }   

    public function delete(string $uuid)
    {
        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng để xóa',
            ], 422);
        }

        $check = Order::where('customer_id', function ($query) use ($uuid) {
            $query->select('id')
                ->from('customers')
                ->where('uuid', $uuid);
        })->exists();

        if ($check) {   
            return response()->json([
                    'success' => false,
                    'message' => 'Khách hàng này đã tồn tại trong phiếu giao hàng rồi. Vui lòng ẩn khách hàng này đi thay vì xóa nhé.',
            ], 422);
        }else{
            Customer::where('uuid', $uuid)->delete();
            return response()->json([
            'success' => true,
            'message' => 'Xóa khách hàng thành công',
            ]);
        }
    }
    public function hide(string $uuid)
    {
        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy khách hàng để ẩn/hiện',
            ], 422);
        }

        $customer = Customer::where('uuid', $uuid)->first();

        $hide= $customer->hide==0 ? 1 : 0; 

        $customer->hide = $hide;
        $customer->updated_at = now();
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => $hide== 1 ? 'Ẩn khách hàng thành công' : 'Hiện khách hàng thành công',
            'data' => $customer,
        ]);
    }
}
