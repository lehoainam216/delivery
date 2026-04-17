<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;
    protected $fillable = ['gas_name', 'hide', 'uuid'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
