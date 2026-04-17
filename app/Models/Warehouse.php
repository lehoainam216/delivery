<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['warehouse_name', 'warehouse_name_en', 'hide', 'uuid'];

    public function driver()
    {
        return $this->hasMany(Driver::class);
    }
    public function car()
    {
        return $this->hasMany(Car::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
