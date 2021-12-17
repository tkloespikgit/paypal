<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>订单 - {{$order->order_number}} - 详情</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
          integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
          integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
            integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-sm-12">
        <hr/>
        <p>All Goods: {{$goodsStr}}</p>
        <hr/>
        <table class="table table-bordered table-hover">
            <thead>
            Order Number: {{$order->order_number}}
            </thead>
            <tbody>
            <tr>
                <th >No.</th>
                <th >Goods Name</th>
                <th >Price (USD)</th>
                <th >Unit</th>
                <th >Total Price (USD)</th>
            </tr>
            @foreach($order->rProducts as $k => $product)
                <tr>
                    <td >{{$k+1}}</td>
                    <td >{{$product->products->name}}</td>
                    <td class="text-right">{{number_format($product->products->price,2)}}</td>
                    <td class="text-right">{{$product->unit}}</td>
                    <td class="text-right">{{number_format($product->unit*$product->products->price,2)}}</td>
                </tr>
            @endforeach
            <tr>
                <td  rowspan="3">Shipping:</td>
                <td>Fees:</td>
                <td colspan="3" class="text-right">Free</td>
            </tr>
            <tr>
                <td>Delivery Provider:</td>
                <td colspan="3"  class="text-right">{{$order->express}}</td>
            </tr>
            <tr>
                <td>Express No:</td>
                <td colspan="3"  class="text-right">{{$order->express_no}}</td>
            </tr>
            <tr>
                <td rowspan="3" >Total:</td>
                <td>Discount Amt:</td>
                <td colspan="3" class="text-right">{{number_format($order->discount_amount,2)}}</td>
            </tr>
            <tr>
                <td>Paid Amt:</td>
                <td colspan="3" class="text-right">{{number_format($order->total_amount,2)}}</td>
            </tr>
            </tbody>
        </table>
        <hr/>
        <p>Customer: {{$order->name}}</p>
        <p>Customer E-mail: {{$order->email}}</p>
    </div>
</div>
</body>
</html>
