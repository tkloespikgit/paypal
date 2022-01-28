@extends('layout.main')
@section('payType','Visa/Mastercard')
@section('content')
    <div class="section">
        <div class="container">
            <div class="justify-content-center row">
                <div class="col-lg-6 col-xxl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center pt-4 pb-5" style="">
                                <span class="px-3 bg-white d-inline-block align-top lh-sm text-danger">【Attention Please】</span>
                                <div class="border-bottom mt-n3"></div>
                            </div>
                            <div class="row g-2">
                                <div class="col-sm-12">
                                    <table class="table table-bordered">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
