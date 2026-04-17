<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Processing;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    // 0. Đổi ngôn ngữ
    public function setLocale($lang)
    {
        App::setLocale($lang);
        Session::put('locale', $lang);
        return back();
    }
    // 1. Cấp mã Code
    public function getCode()
    {
        $max = Order::whereYear('created_at', '=', date('Y'))           
            ->max('code');        
        if ($max === null) {
            $code = date('y') . '0001';
        } else {
            $code = $max + 1;
        }        
        return $code;
    }    
    // 3.Tạo một chuỗi ngẫu nhiên bao gồm cả chữ cái và số
    public function getUuid($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
    
