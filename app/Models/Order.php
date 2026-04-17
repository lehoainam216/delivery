<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['code','customer_id', 'priority_id', 'gas_id', 'car_id', 'driver_id', 'user_id', 'status_id','note', 'warehouse_id', 'gas_type_id', 'quantity', 'weight', 'delivery_date', 'create_date', 'uuid'];

    protected $casts = [
        'delivery_date' => 'date',
        'create_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function gasType()
    {
        return $this->belongsTo(GasType::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function gas()
    {
        return $this->belongsTo(Gas::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
