<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Gas;
use App\Models\GasType;
use App\Models\Order;
use App\Models\Priority;
use App\Models\Status;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::with('role')
            ->where('email', $request->username)
            ->where('hide', 0)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->email,
                'name' => $user->name,                
                'role_id' => $user->role_id,
                'warehouse_id' => $user->warehouse_id,
            ],
        ], 200);
    }

    public function customer()
    {
        $data = Customer::where('hide',0)->orderBy('customer_name', 'asc')->get();  
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function priority()
    {
        $data = Priority::where('hide', 0)->orderBy('priority_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function gas()
    {
        $data = Gas::where('hide', 0)->orderBy('gas_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function gas_type()
    {
        $data = GasType::where('hide', 0)->orderBy('gas_type_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function warehouse()
    {
        $data = Warehouse::where('hide', 0)->orderBy('warehouse_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function status()
    {
        $data = Status::where('hide', 0)->orderBy('status_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function driver($warehouse_id)
    {
        $data = Driver::where('hide', 0)->where('warehouse_id', $warehouse_id)->orderBy('driver_name', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function car($warehouse_id)
    {
        $data = Car::where('hide', 0)->where('warehouse_id', $warehouse_id)->orderBy('car_number', 'asc')->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function generateRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }   
    public function getCode()
    {
        $lastRequest = Order::whereYear('created_at', now()->year)->orderByDesc('code')->first();
        if ($lastRequest) {
            return $lastRequest->code + 1;
        } else {
            return substr(now()->year, -2) . '0001';
        }
    }
}
