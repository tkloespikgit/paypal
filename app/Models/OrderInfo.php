<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rProducts()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderToProduct::class,
            'order_id',
            'product_id',
            'id',
            'id'
        );
    }
}
