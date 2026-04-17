<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable = ['status_name', 'status_name_en', 'hide', 'status_color', 'uuid'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
