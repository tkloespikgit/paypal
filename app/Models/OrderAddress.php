<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderAddress
 *
 * @property int $id
 * @property int $order_id
 * @property string $order_no
 * @property string $pp_order_no
 * @property string $first_name
 * @property string $last_name
 * @property string $address_name
 * @property string $address_country_code
 * @property string $address_country
 * @property string $address_state
 * @property string $address_city
 * @property string $address_street
 * @property string $address_zip
 * @property string $payer_email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereAddressZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress wherePayerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress wherePpOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderAddress whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderAddress extends Model
{
    use HasFactory;
    protected $guarded = [];
}
