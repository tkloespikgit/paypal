<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaypalAccount
 *
 * @property int $id
 * @property string $account_name 账户名称
 * @property string $account_email 账户邮箱
 * @property string $account_html 账户付款网页
 * @property string $status 账户状态 0-停用 1-启用 2-禁用
 * @property int $last_resp 上次使用时间
 * @property string $balance 余额
 * @property string $currency 币种
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereAccountEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereAccountHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereLastResp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $connection
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereConnection($value)
 * @property string|null $notify_url
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalAccount whereNotifyUrl($value)
 */
class PaypalAccount extends Model
{
    use HasFactory;
    protected $guarded = [];
}
