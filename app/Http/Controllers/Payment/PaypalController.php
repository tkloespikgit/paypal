<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\OrderAddress;
use App\Models\OrderInfo;
use App\Models\OrderProduct;
use App\Models\PaypalAccount;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function renderHtml()
    {
        $account = $this->getAccount();
        $trigger = 'paypal';
        return view('paypal', compact('account', 'trigger'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function pay(Request $request)
    {
        $account       = $this->getAccount();
        $order         = $this->generateOrderByAmount($request, $account);
        $orderProducts = OrderProduct::query()
            ->where('order_id', $order->id)
            ->get();

        return view('payForm', compact('order', 'orderProducts', 'account'));
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function receiveNotify(Request $request)
    {
        if ($request->input('payment_status') == 'Completed') {

            $orderInfo = OrderInfo::query()
                ->where('order_number', $request->input('invoice'))
                ->first();
            $orderInfo->update([
                'status'    => 1,
                'porder_no' => $request->input('txn_id')
            ]);

            PaypalAccount::query()
                ->where('account_email', $orderInfo->receiver_email)
                ->update([
                    'last_resp' => time()
                ]);

            $this->insertAddress($request, $orderInfo);
        }
        return response('OK');
    }

    /**
     * 获取所有可用账户
     * @return Builder[]|Collection
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
     * @return Builder|Model|object|PaypalAccount
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
        OrderAddress::query()->firstOrCreate([
            'order_no' => $orderInfo->order_number,
        ], [
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

    /**
     * @param Request $request
     * @param PaypalAccount $account
     * @return Builder|Model|OrderInfo
     */
    protected function generateOrderByAmount(Request $request, PaypalAccount $account)
    {
        $amount   = $request->input('camount');
        $products = DB::connection($account->connection)->table('oc_product')
            ->where('price', '<=', $amount)
            ->where('status', 1)
            ->get();

        $productArr = [];
        while ($amount > 0) {
            $filteredProduct = $products->where('price', '<=', $amount);
            $selectedProduct = $filteredProduct->count() > 0 ?
                $filteredProduct->random() :
                $products->sortBy('price')->first();

            if (isset($productArr[$selectedProduct->product_id])) {
                $productArr[$selectedProduct->product_id]['unit'] += 1;
            } else {
                $productArr[$selectedProduct->product_id] = [
                    'name'       => $selectedProduct->model,
                    'price'      => $selectedProduct->price,
                    'product_id' => $selectedProduct->product_id,
                    'unit'       => 1
                ];
            }
            $amount -= $selectedProduct->price;
        }

        $order = OrderInfo::query()->create([
            'order_number'    => time() . '-' . rand(10000, 99999),
            'receiver_email'  => $account->account_email,
            'email'           => $request->input('cemail'),
            'name'            => $request->input('cname'),
            'total_amount'    => $request->input('camount'),
            'discount_amount' => $amount * -1,
            'pm'              => 'paypal'
        ]);

        foreach ($productArr as $product) {
            OrderProduct::query()->create([
                'order_id'     => $order->id,
                'product_name' => $product['name'],
                'product_id'   => $product['product_id'],
                'price'        => $product['price'],
                'unit'         => $product['unit'],
                'sku_id'       => 'SL1-' . str_pad($product['product_id'], 6, '0', STR_PAD_LEFT),
                'connection'   => $account->connection
            ]);
        }

        return $order;
    }

}
