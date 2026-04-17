<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['driver_name', 'mobile', 'warehouse_id','hide', 'uuid'];
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}
