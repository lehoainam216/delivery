<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $fillable = ['priority_name','priority_name_en', 'uuid', 'color', 'hide'];
    
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
