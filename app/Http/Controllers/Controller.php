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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    private $minPrice = 20;

    public function showAccounts()
    {
        $accounts = $this->getAccounts();
        if ($accounts == null) {
            return "No accounts !";
        }
        $accounts->last_resp = time();
        $accounts->save();
        return $accounts->account_html;
    }


    public function payNow(Request $request)
    {
        if (!$request->has(['item_name', 'quantity', 'amount', 'shipping', 'invoice'])) {
            return 'error happened!';
        }
        $accounts = $this->getAccounts();
        if ($accounts == null) {
            return "No accounts !";
        }
        $accounts->last_resp = time();
        $accounts->save();
        return view('paymentForm', compact('request', 'accounts'));
    }


    private function getAccounts()
    {
        return PaypalAccount::query()
            ->where('status', 1)
            ->orderBy('last_resp')
            ->first();
    }

    public function showAccountsV2(Request $request)
    {
        if ($request->isMethod('post')) {
            $accounts = $this->getAccounts();
            $data = $this->initProduct($request->input('camount'));
            $order = OrderInfo::query()->create([
                'order_number' => time() . '-' . rand(10000, 99999),
                'receiver_email' => $accounts->account_email,
                'email' => $request->input('cemail'),
                'name' => $request->input('cname'),
                'total_amount' => $request->input('camount'),
                'discount_amount' => $data['discount']
            ]);
            foreach ($data['pArr'] as $key => $val) {
                OrderToProduct::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $key,
                    'unit' => count($val)
                ]);
            }
            $orderArr = $this->getOrderProds($order->id);
            $accounts->last_resp = time();
            $accounts->save();
            return view('payForm', compact('order', 'orderArr', 'accounts'));
        }
        return view('input_amount');
    }

    public function initProduct($amount): array
    {
        /*获取最小单价*/
        $this->minPrice = Product::query()->orderBy('price')->min('price');
        /*获取小于总金额的所有产品*/
        $products = Product::query()->where('price', '<=', $amount)->get();

        $pArr = [];
        $i = 0;
        while ($i < 300) {
            $i++;

            $product = $products->where('price', '<=', $amount)->random();
            $pArr[$product->id][] = $product->id;
            $amount = $amount - $product->price;

            if ($amount <= $this->minPrice) {
                break;
            }
        }

        $minProd = $products->where('price', '=', $this->minPrice)->random();
        $pArr[$minProd->id][] = $minProd->id;
        return [
            'discount' => $this->minPrice - $amount,
            'pArr' => $pArr
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
                    'status' => 1,
                    'porder_no' => $request->input('txn_id')
                ]);
        }
        return response('OK');
    }

    public function ShowLic(Request $request)
    {
        $orderStr = '';
        $orders = null;
        if ($request->isMethod('post')) {
            $orderStr = explode(',', $request->input('orderNos'));
            $orders = OrderInfo::query()
                ->whereIn('porder_no', $orderStr)
                ->with('rProducts')
                ->with('rProducts.Products')
                ->get();
        }
        return view('inputOrderNos',compact('orders','orderStr'));
    }

}
