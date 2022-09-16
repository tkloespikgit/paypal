<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
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
            OrderInfo::query()
                ->where('order_number', $request->input('invoice'))
                ->update([
                    'status'    => 1,
                    'porder_no' => $request->input('txn_id')
                ]);
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
}
