<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Now</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-sm-12" style="margin-top: 60px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Payment Result:</h4>
            </div>
            <table class="table table-hover">
                <tr>
                    <td>Order Number:</td>
                    <td>{{$order->order_number}}({{$order->porder_no}})</td>
                </tr>
                <tr>
                    <td>Pay Amount:</td>
                    <td>{{number_format($order->total_amount,2)}}</td>
                </tr>
                <tr>
                    <td>Result:</td>
                    <td>{{$order->status == 1 ? "SUCCESS" : "FAILED"}}</td>
                </tr>
            </table>
            <a class="btn btn-success" href="{{url('creditCard')}}">Pay Again</a>
        </div>

    </div>
</div>

</body>
</html>
