<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderToProduct::class,'order_id');
    }
}
