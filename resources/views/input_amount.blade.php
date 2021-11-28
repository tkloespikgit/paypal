<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</head>
<body>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Please complete transaction info:</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" >
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Your email</label>
                        <div class="col-sm-10">
                            <input type="email" name="cemail" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Your name</label>
                        <div class="col-sm-10">
                            <input type="text" name="cname" class="form-control" id="inputPassword3" placeholder="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputAmount3" class="col-sm-2 control-label">Pay Amount</label>
                        <div class="col-sm-10">
                            <input type="text" name="camount" class="form-control" id="inputAmount3" placeholder="pay amount(USD)">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Pay By Paypal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
