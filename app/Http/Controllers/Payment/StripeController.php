<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OrderInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StripeController extends Controller
{

    /**
     * 展示付款页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function renderHtml()
    {
        $trigger = 'Visa/Mastercard';
        return view('stripe', compact('trigger'));
    }

    /**
     * @throws \Exception
     */
    public function pay(Request $request)
    {
        $order = $this->createOrderByAmount(
            $request->input('camount'),
            'order@besttrinkets.com',
            $request->input('cemail'),
            $request->input('cname'),
            'creditCard');

        $orderInfo = OrderInfo::query()
            ->where('order_number', $order->order_number)
            ->with('rProducts')
            ->with('rProducts.Products')
            ->first()->toArray();

        $discount = $order->discount_amount;

        $res = Http::asForm()->post('https://www.cbecspay.com/Gateway/V1/CreateRequest', [
            "merchant_no"       => '20211217095445160',
            "app_id"            => '121579079461BC97216B9C10650895',
            "payment_method"    => 'stripe',
            "amount"            => $order->total_amount * 100,
            "currency"          => 'USD',
            "goods_name"        => 'BestTrinkets Cart Checkout',
            "product_info"      => json_encode(compact('orderInfo', 'discount')),
            "original_order_no" => $order->order_number,
            "ip"                => $request->getClientIp(),
            "website_url"       => 'https://www.besttrinkets.com',
            "return_url"        => 'https://pnotify.besttrinkets.com/creditCard/success',
            "notify_url"        => 'https://pnotify.besttrinkets.com/creditCard/receiveNotify',
            "accept_language"   => 'zh',
            "timestamp"         => time(),
            "signature"         => date('Ymd'),
        ]);
        return redirect('/')->setTargetUrl($res->json('data.pay_url'));
    }

    /**
     * @param Request $request
     * @return string
     */
    public function receiveNotify(Request $request)
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function success(Request $request)
    {
        sleep(6);
        $order = OrderInfo::query()
            ->where('order_number', $request->input('original_order_no'))
            ->first();
        return view('result', compact('order'));
    }
}
