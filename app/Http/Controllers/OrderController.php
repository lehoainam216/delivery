<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{   
    public function list(Request $request)
    {           
        $query = Order::with(['customer','warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user'])
            ->orderBy('orders.status_id', 'asc')
            ->orderBy('orders.updated_at', 'desc');

        if ($request->filled('user_id')) {
            $query->where('orders.user_id', $request->input('user_id'));
        }

        if ($request->filled('warehouse_id')) {
            $query->where('orders.warehouse_id', $request->input('warehouse_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('orders.create_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('orders.create_date', '<=', $request->input('date_to'));
        }

        $searchField = $request->input('search_field');
        $searchValue = trim((string) $request->input('search_value', ''));

        if ($searchValue !== '') {
            if ($searchField === 'warehouse') {
                $query->whereHas('warehouse', function ($warehouseQuery) use ($searchValue) {
                    $warehouseQuery->where('warehouse_name', 'like', '%' . $searchValue . '%');
                });
            } elseif ($searchField === 'customer') {
                $query->whereHas('customer', function ($customerQuery) use ($searchValue) {
                    $customerQuery->where('customer_name', 'like', '%' . $searchValue . '%');
                });
            } else {
                $query->where('orders.code', 'like', '%' . $searchValue . '%');
            }
        }

        $data = $query->paginate(20)->appends($request->all());

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function detail($uuid)
    {
        $order = Order::with(['customer', 'warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user'])
            ->where('orders.uuid', $uuid)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function add()
    {
        return response()->json([
            'success' => true,
            'message' => 'Use POST /api/orders to create a new order',
        ]);
    }

    public function store(Request $request)
    {
        // $user = $this->resolveApiUser($request);

        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Unauthenticated',
        //     ], 401);
        // }

        $input = $request->all();
        $input['uuid'] = $this->getUuid(10);
        $input['code'] = $this->getCode();
        $input['created_at'] = now();
        $input['updated_at'] = now();
        $input['user_id'] = $input['user_id'] ?? null;
        $input['status_id'] = 1;
        $input['create_date'] = date('Y-m-d');

        $order = Order::create($input);

        return response()->json([
            'success' => true,
            'message' => 'Them moi phieu giao hang thanh cong',
            'data' => $order->load(['customer', 'warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user']),
        ], 201);
    }

    public function edit($uuid)
    {
        $order = Order::with(['customer', 'warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user'])
            ->where('orders.uuid', $uuid)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function receive(Request $request)
    {
        $uuid = $request->route('uuid') ?? $request->input('uuid');

        $updated = Order::where('uuid', $uuid)->update([
            'car_id' => $request->input('car_id'),
            'driver_id' => $request->input('driver_id'),
            'status_id' => 2,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order = Order::with(['customer', 'warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user'])
            ->where('uuid', $uuid)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Tiep nhan don hang thanh cong',
            'data' => $order,
        ]);
    }

    public function update(Request $request)
    {
        $uuid = $request->route('uuid') ?? $request->input('uuid');
        $quantity = $request->quantity;
        $gasTypeId = $request->gas_type_id;

        if (!$uuid) {
            return response()->json([
                'success' => false,
                'message' => 'Thieu thong tin don hang de cap nhat',
            ], 422);
        }

        if ((int) $request->gas_id === 3) {
            $quantity = null;
            $gasTypeId = null;
        }

        $updated = Order::where('uuid', $uuid)->update([
            'customer_id' => $request->customer_id,
            'priority_id' => $request->priority_id,
            'gas_id' => $request->gas_id,
            'gas_type_id' => $gasTypeId,
            'quantity' => $quantity,
            'weight' => $request->weight,
            'delivery_date' => $request->delivery_date,
            'warehouse_id' => $request->warehouse_id,
            'note' => $request->note,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order = Order::with(['customer', 'warehouse', 'priority', 'status', 'gas', 'gastype', 'car', 'driver', 'user'])
            ->where('uuid', $uuid)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Câp nhật thông tin thành công',
            'data' => $order,
        ]);
    }
    public function delete(string $uuid)
    {
        Order::where('uuid', $uuid)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa thông tin thành công',
            ]);
        }
    }
