<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
</head>
<body>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="payForm">
    <input type="hidden" name="charset" value="utf-8">
    <input name="upload" value="1" type="hidden">
    <input type="hidden" name="cmd" value="_cart">
    {{--账号--}}
    <input type="hidden" name="business" value="{{$account->account_email}}">
    {{--币种--}}
    <input type="hidden" name="currency_code" value="USD">
    {{--物品--}}
    @foreach($orderProducts as $key => $product)
        <input type="hidden" name="item_name_{{$key+1}}" value="{{$product->product_name}}">
        <input type="hidden" name="item_number_{{$key+1}}" value="{{$product->sku_id}}">
        <input type="hidden" name="amount_{{$key+1}}" value="{{$product->price}}">
        <input type="hidden" name="quantity_{{$key+1}}" value="{{$product->unit}}">
    @endforeach
    {{--运费以及折扣--}}
    <input type="hidden" name="shipping" value="0">
    <input type="hidden" name="discount_amount_cart" value="{{$order->discount_amount}}"/>
    <input type="hidden" name="notify_url" value="{{$account->notify_url}}/receiveNotify">
    {{--订单号--}}
    <input type="hidden" name="invoice" value="{{$order->order_number}}">
    <input type="hidden" name="no_note" value="1">
</form>
<script>
    /*document.getElementById("payForm").submit();*/
</script>
</body>
</html>
