<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OrderAddress;
use App\Models\OrderInfo;
use App\Models\PaypalAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    /**
     * 展示付款页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function renderHtml()
    {
        $accounts = $this->getActiveAccounts();
        $trigger  = 'paypal';
        return view('paypal', compact('accounts', 'trigger'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function pay(Request $request)
    {
        $account = $this->getAccount();

        $order = $this->createOrderByAmount(
            $request->input('camount'),
            $account->account_email,
            $request->input('cemail'),
            $request->input('cname'),
            'paypal');

        $orderArr           = $this->getOrderProds($order->id);
        $account->last_resp = time();
        $account->save();
        return view('payForm', compact('order', 'orderArr', 'account'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function receiveNotify(Request $request)
    {
        if ($request->input('payment_status') == 'Completed') {
            Log::info(json_encode($request->all()));
            $orderInfo = OrderInfo::query()
                ->where('order_number', $request->input('invoice'))
                ->first();
            $orderInfo->update([
                'status'    => 1,
                'porder_no' => $request->input('txn_id')
            ]);
            $this->insertAddress($request, $orderInfo);
        }
        return response('OK');
    }

    /**
     * 获取所有可用账户
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getActiveAccounts()
    {
        return PaypalAccount::query()
            ->where('status', 1)
            ->orderBy('last_resp')
            ->get();
    }

    /**
     * 获取待使用的账户
     * @return PaypalAccount|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    private function getAccount()
    {
        return PaypalAccount::query()
            ->where('status', 1)
            ->orderBy('last_resp')
            ->first();
    }


    private function insertAddress(Request $request, $orderInfo)
    {
        OrderAddress::query()->create([
            'order_id'             => $orderInfo->id,
            'order_no'             => $orderInfo->order_number,
            'pp_order_no'          => $request->input('txn_id'),
            'first_name'           => $request->input('first_name'),
            'last_name'            => $request->input('last_name'),
            'address_name'         => $request->input('address_name'),
            'address_country_code' => $request->input('address_country_code'),
            'address_country'      => $request->input('address_country'),
            'address_state'        => $request->input('address_state'),
            'address_city'         => $request->input('address_city'),
            'address_street'       => $request->input('address_street'),
            'address_zip'          => $request->input('address_zip'),
            'payer_email'          => $request->input('payer_email'),
        ]);
    }

}
