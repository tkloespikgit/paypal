<?php

namespace App\Http\Controllers;

use App\Models\OrderInfo;
use App\Models\OrderToProduct;
use App\Models\PaypalAccount;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function initProduct($amount): array
    {
        /*获取最小单价*/
        $minPrice = Product::query()->where('status', 1)->orderBy('price')->min('price');
        /*获取小于总金额的所有产品*/
        $products = Product::query()->where('price', '<=', $amount)->where('status', 1)->get();

        $pArr = [];
        $i    = 0;
        while ($i < 300) {
            $i++;

            $product              = $products->where('price', '<=', $amount)->random();
            $pArr[$product->id][] = $product->id;
            $amount               = $amount - $product->price;

            if ($amount <= $minPrice) {
                break;
            }
        }

        $minProd              = $products->where('price', '=', $minPrice)->random();
        $pArr[$minProd->id][] = $minProd->id;
        return [
            'discount' => $minPrice - $amount,
            'pArr'     => $pArr
        ];
    }

    public function getOrderProds($orderId)
    {
        return OrderToProduct::query()
            ->where('order_id', $orderId)
            ->with('Products')
            ->get();
    }

    public function receiveNotify(Request $request)
    {
        if ($request->input('payment_status') == 'Completed') {
            OrderInfo::query()
                ->where('order_number', $request->input('invoice'))
                ->update([
                    'status'    => 1,
                    'porder_no' => $request->input('txn_id')
                ]);
        }
        return response('OK');
    }

    public function ShowLic(Request $request)
    {
        $orderStr = '';
        $orders   = null;
        if ($request->isMethod('post')) {
            $orderStr = explode(',', $request->input('orderNos'));
            $orders   = OrderInfo::query()
                ->whereIn('porder_no', $orderStr)
                ->with('rProducts')
                ->with('rProducts.Products')
                ->get();
        }
        return view('inputOrderNos', compact('orders', 'orderStr'));
    }

    public function ShowBill($order_number)
    {
        $order    = OrderInfo::query()
            ->where('order_number', $order_number)
            ->with('rProducts')
            ->with('rProducts.Products')
            ->first();
        $goodsStr = implode(';', $order->rProducts->pluck('Products.name')->toArray());
        return view('bill', compact('order', 'goodsStr'));
    }

    public function ShowInvoice($email)
    {
        $date = date('Y-m-d H:i:s', time() - 30 * 24 * 60 * 60);
        $res  = DB::select("SELECT
	op.product_id,
	p.name_cn,
	SUM( unit ) AS nums ,
	p.price * 0.68 * 6.4 as price_cny,
	p.skuid
FROM
	order_to_products op
	LEFT JOIN order_infos o ON o.id = op.order_id
	LEFT JOIN products p ON op.product_id = p.id
WHERE
	o.created_at > '{$date}' AND
	o.receiver_email='{$email}'
GROUP BY
	op.product_id");

        $total_num = round(collect($res)->sum(function ($r) {
                return $r->price_cny * ($r->nums + 5);
            }) * 20 * 6.3 * 0.74, 0);
        $total_dec = number_format($total_num, 2);
        $total_cn  = $this->rmb_format($total_num, '元', false, true);

        return view('invoice', compact('res', 'date', 'total_dec', 'total_cn'));
    }

    /**
     * @param int $money
     * @param string $int_unit 币种单位，默认"元"，有的需求可能为"圆"
     * @param bool $is_round 是否对小数进行四舍五入
     * @param false $is_extra_zero 是否对整数部分以 0 结尾，小数存在的数字附加 0,比如 1960.30
     * @return array|string|string[]|null
     */
    public function rmb_format(int $money = 0, string $int_unit = '元', bool $is_round = true, bool $is_extra_zero = false)
    {
        // 将数字切分成两段
        $parts = explode('.', $money, 2);
        $int   = isset ($parts [0]) ? strval($parts [0]) : '0';
        $dec   = isset ($parts [1]) ? strval($parts [1]) : '';

        // 如果小数点后多于2位，不四舍五入就直接截，否则就处理
        $dec_len = strlen($dec);
        if (isset ($parts [1]) && $dec_len > 2) {
            $dec = $is_round ? substr(strrchr(strval(round(floatval("0." . $dec), 2)), '.'), 1) : substr($parts [1], 0, 2);
        }

        // 当number为0.001时，小数点后的金额为0元
        if (empty ($int) && empty ($dec)) {
            return '零';
        }

        // 定义
        $chs     = ['0', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];
        $uni     = ['', '拾', '佰', '仟'];
        $dec_uni = ['角', '分'];
        $exp     = ['', '万'];
        $res     = '';

        // 整数部分从右向左找
        for ($i = strlen($int) - 1, $k = 0; $i >= 0; $k++) {
            $str = '';
            // 按照中文读写习惯，每4个字为一段进行转化，i一直在减
            for ($j = 0; $j < 4 && $i >= 0; $j++, $i--) {
                $u   = $int{$i} > 0 ? $uni [$j] : ''; // 非0的数字后面添加单位
                $str = $chs [$int{$i}] . $u . $str;
            }
            $str = rtrim($str, '0'); // 去掉末尾的0
            $str = preg_replace("/0+/", "零", $str); // 替换多个连续的0
            if (!isset ($exp [$k])) {
                $exp [$k] = $exp [$k - 2] . '亿'; // 构建单位
            }
            $u2  = $str != '' ? $exp [$k] : '';
            $res = $str . $u2 . $res;
        }

        // 如果小数部分处理完之后是00，需要处理下
        $dec = rtrim($dec, '0');
        // 小数部分从左向右找
        if (!empty ($dec)) {
            $res .= $int_unit;

            // 是否要在整数部分以0结尾的数字后附加0，有的系统有这要求
            if ($is_extra_zero) {
                if (substr($int, -1) === '0') {
                    $res .= '零';
                }
            }

            for ($i = 0, $cnt = strlen($dec); $i < $cnt; $i++) {
                $u   = $dec{$i} > 0 ? $dec_uni [$i] : ''; // 非0的数字后面添加单位
                $res .= $chs [$dec{$i}] . $u;
                if ($cnt == 1)
                    $res .= '整';
            }

            $res = rtrim($res, '0'); // 去掉末尾的0
            $res = preg_replace("/0+/", "零", $res); // 替换多个连续的0
        } else {
            $res .= $int_unit . '整';
        }
        return $res;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function cNotify(Request $request)
    {
        if ($request->input('status') == 1) {
            OrderInfo::query()
                ->where('order_number', $request->input('original_order_no'))
                ->update([
                    'status'    => 1,
                    'porder_no' => $request->input('order_no')
                ]);
        } else {
            OrderInfo::query()
                ->where('order_number', $request->input('original_order_no'))
                ->update([
                    'status'    => 2,
                    'porder_no' => $request->input('order_no')
                ]);
        }
        return 'SUCCESS';
    }

    public function success(Request $request)
    {
        sleep(6);
        $order = OrderInfo::query()
            ->where('order_number', $request->input('original_order_no'))
            ->first();
        return view('success', compact('order'));
    }


    /**
     * @param $amount
     * @param $receiver_email
     * @param $customer_email
     * @param $customer_name
     * @param $pm
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    protected function createOrderByAmount($amount, $receiver_email, $customer_email, $customer_name, $pm)
    {
        $data  = $this->initProduct($amount);
        $order = OrderInfo::query()->create([
            'order_number'    => time() . '-' . rand(10000, 99999),
            'receiver_email'  => $receiver_email,
            'email'           => $customer_email,
            'name'            => $customer_name,
            'total_amount'    => $amount,
            'discount_amount' => $data['discount'],
            'pm'              => $pm
        ]);
        if (!empty($order->id)) {
            foreach ($data['pArr'] as $key => $val) {
                OrderToProduct::query()->create([
                    'order_id'   => $order->id,
                    'product_id' => $key,
                    'unit'       => count($val)
                ]);
            }
            return $order;
        }
        throw new \Exception('error!');
    }
}
