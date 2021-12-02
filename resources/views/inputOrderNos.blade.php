<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>查询订单</title>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Please complete transaction info:</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">请输入订单号：</label>
                        <div class="col-sm-10">
                            <textarea id="inputEmail3" name="orderNos" placeholder="请以英文逗号分割">{{$orderStr}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">立即查询</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <hr>
        @foreach($orders as $order)
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>订单号 - <span class="text-danger">{{$order->porder_no}}</span></h5>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>物流公司：</td>
                            <td>{{$order->express ?? '未知'}}</td>
                        </tr>
                        <tr>
                            <td>快递单号：</td>
                            <td>{{$order->express_no ?? '未知'}}</td>
                        </tr>
                    </table>
                    <div class="media">
                        <div class="media-left media-top">
                            <a href="#">
                                交易活动信息：
                            </a>
                        </div>
                        <div class="media-body">
                            <p>
                                该笔订单(系统订单号:{{$order->order_number}}),顾客 {{$order->name}}
                                购买物品有：
                                @foreach($order->r_products as $product)
                                    <span>{{$product->products->name}}(销售数量:{{$product->unit}},单价:{{$product->products->price}}美金,总价:{{$product->unit*$product->products->price}}美金)</span>、
                                @endforeach
                                合计 {{$order->total_amount + $order->discount_amount}} 美金，
                                优惠折扣{{$order->discount_amount}}美金，总付款金额：{{$order->total_amount}}美金，
                                物品通过{{$order->express??'未知'}}(快递单号:{{$order->express_no??'未知'}})发货，
                                我们的销售网址是：https://www.besttrinkets.com/
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
