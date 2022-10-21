<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderInfo
 *
 * @property int $id
 * @property string $order_number
 * @property string|null $receiver_email
 * @property string|null $porder_no
 * @property string|null $pm
 * @property string $email
 * @property string $name
 * @property string $total_amount
 * @property string $discount_amount
 * @property int $status 订单状态
 * @property string|null $express 快递公司
 * @property int|null $express_status
 * @property string|null $express_no 快递单号
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderToProduct[] $rProducts
 * @property-read int|null $r_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereExpress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereExpressNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereExpressStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo wherePm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo wherePorderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereReceiverEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rProducts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderToProduct::class,'order_id');
    }
}
