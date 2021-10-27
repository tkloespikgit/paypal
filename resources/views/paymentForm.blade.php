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
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="{{$accounts->account_email}}">
    <input type="hidden" name="item_name" value="{{$request->item_name}}">
    <input type="hidden" name="quantity" value="{{$request->quantity}}">
    <input type="hidden" name="amount" value="{{$request->amount}}">
    <input type="hidden" name="shipping" value="{{$request->shipping}}">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="invoice" value="{{$request->invoice}}">
</form>
<script>
    document.getElementById("payForm").submit();
</script>
</body>
</html>
