<?php

namespace App\Admin\Actions\Order;

use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;

class OrderProductDetails extends RowAction
{

    public $name = '订单信息';

    public function href()
    {
        return url('orderDetails',$this->getKey());
    }
}
