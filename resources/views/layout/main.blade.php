<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Now</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('default/assets/img/logo/favicon.ico')}}">
    <!-- Fonts CSS -->
    <link rel="stylesheet" href="{{asset("default/assets/vendor/fonts/fonts.css")}}">
    <!-- Bootstrap-icons CSS -->
    <link rel="stylesheet" href="{{asset("default/assets/vendor/bootstrap/icons/bootstrap-icons.css")}}">
    <!--Magnific-Popup CSS -->
    <link rel="stylesheet" href="{{asset("default/assets/vendor/magnific/magnific-popup.css")}}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{asset("default/assets/vendor/slick/slick.css")}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset("default/assets/css/style.css")}}">

</head>
<body>
<div id="loading" class="preloader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<header class="header-main bg-white header-light fixed-top header-height">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                IDNON.COM
            </a>
            <!-- Logo -->
            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto" style="margin-right: 0 !important;">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Pay By Paypal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main style="margin-top: 74px">
    <div class="py-3 bg-gray-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 my-2">
                    <h1 class="m-0 h4 text-center text-lg-start">@yield('payType','paypal')</h1>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</main>
</body>
<!-- jquery -->
<script src="{{asset('default/assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- appear -->
<script src="{{asset('default/assets/vendor/appear/jquery.appear.js')}}"></script>
<!--bootstrap-->
<script src="{{asset('default/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- owl-carousel -->
<script src="{{asset('default/assets/vendor/slick/slick.min.js')}}"></script>
<!-- magnific -->
<script src="{{asset('default/assets/vendor/magnific/jquery.magnific-popup.min.js')}}"></script>
<!-- isotope -->
<script src="{{asset('default/assets/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<!-- count-down -->
<script src="{{asset('default/assets/vendor/count-down/jquery.countdown.min.js')}}"></script>
<!-- Theme Js -->
<script src="{{asset('default/assets/js/custom.js')}}"></script>

</html>
