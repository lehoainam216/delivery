<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'customer_name_en', 'address', 'mobile','hide', 'uuid'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
