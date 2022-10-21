<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderToProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $unit 购买数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product|null $Products
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderToProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderToProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Products(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
