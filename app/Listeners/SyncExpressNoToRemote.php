<?php

namespace App\Listeners;

use App\Events\ExpressNoUploaded;
use App\Models\OrderInfo;
use App\Models\PaypalAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncExpressNoToRemote
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ExpressNoUploaded $event
     * @return void
     */
    public function handle(ExpressNoUploaded $event)
    {
        $order = $event->order;
        $account = PaypalAccount::query()
            ->where('account_email',$order->receiver_email)
            ->first();

        if ($order->express_no != "" && $order->status == 1)
        {
            $res = Http::post('https://api.telegram.org/bot5233793826:AAH4gQ7B22lLJK-YNKH7XfIPbmmH875ACxM/sendMessage',[
                "chat_id" => "-783068224",
                'text' => "
                *运单更新：*{$account->account_name}\n
                \n
                *Paypal 订单号：*   {$order->porder_no}\n
                *快递公司：*    {$order->express}\n
                *快递单号：*    {$order->express_no}\n
                "
            ]);
            if ($res->successful())
            {
                OrderInfo::query()
                    ->where('id',$order->id)
                    ->update([
                        'express_status' => 1
                    ]);
            }
        }


    }
}
