<?php

namespace App\Services;

use App\Models\PaypalAccount;

class PaypalHandler implements PaymentInterface
{

    public function renderHtml()
    {
        $accounts = PaypalAccount::query()
            ->where('status',1)
            ->get();

        // TODO: Implement renderHtml() method.
    }

    public function getProducts()
    {
        // TODO: Implement getProducts() method.
    }

    public function payNow()
    {
        // TODO: Implement payNow() method.
    }

    public function receiveNotify()
    {
        // TODO: Implement receiveNotify() method.
    }

    public function isSuccessfully()
    {
        // TODO: Implement isSuccessfully() method.
    }
}
