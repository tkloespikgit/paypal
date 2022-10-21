<?php

namespace App\Services;

interface PaymentInterface
{
    public function renderHtml();

    public function getProducts();

    public function payNow();

    public function receiveNotify();

    public function isSuccessfully();


}
