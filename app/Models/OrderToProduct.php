<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderToProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Products(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
