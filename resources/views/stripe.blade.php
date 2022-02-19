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
                            <div class="pt-4 text-left">
                                <b style="color: #000;text-decoration: underline">Make sure when you make payment to our
                                    merchant called CHPS LIMITED!
                                    If not, please <span
                                        class="text-danger">don`t</span> send the money!</b>
                                <br>
                                <b>Some customers respond that their transaction has been charged duplicate.So we only allow one customer make payment once daily.If you have any question with your charge or payment,please contact us at <a href="mailto:idpaypal@163.com">idpaypal@163.com</a></b>
                            </div>
                            <hr/>
                            <form class="" action="https://pnotify.besttrinkets.com/creditCard" method="post" target="_blank">
                                {{csrf_field()}}
                                <div class="form-group mb-3">
                                    <label for="email_1" class="form-label">Your email<span
                                            class="text-danger">*</span></label>
                                    <input type="email" id="email_1" class="form-control" name="cemail"
                                           placeholder="E-mail" value="{{old('cemail')}}">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row align-items-center">
                                        <label class="form-label col" for="exampleInputName">Your name<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input type="text" class="form-control" id="exampleInputName"
                                           placeholder="your name" value="{{old('cname')}}" name="cname">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="row align-items-center">
                                        <label class="form-label col" for="exampleInputAmount">Pay amount($)<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <input type="number" class="form-control" id="exampleInputAmount"
                                           placeholder="pay amount(USD)" value="{{old('camount')}}" name="camount">
                                </div>

                                <div class="form-group text-center">
                                    <input type="submit" value="Pay by Visa/Mastercard" class="btn btn-primary w-100">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
