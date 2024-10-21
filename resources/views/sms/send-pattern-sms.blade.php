@extends('layouts.master')
@section('title', __('SMS'))
@section('body')

    <x-navbar/>

    <div class="container">

        <div class="row mt-5 mb-3">
            <div class="col-lg-8 offset-lg-2">

                <form method="POST" action="{{ route('send-pattern-sms') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="phone-number">{{__('phone number')}} :</label>
                        <textarea name="phone-numbers" id="phone-numbers" rows="2" class="form-control" autofocus></textarea>

{{--                        <input name="phone-number" type="text" id="phone-number" class="form-control" autofocus />--}}
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label" for="rahgiri_code">کد رهگیری :</label>
                        <input name="rahgiri_code" type="text" id="rah_code" class="form-control" />
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label" for="sms-text">{{__('sms text')}} :</label>
                        <textarea disabled name="sms-text" id="sms-text" cols="30" rows="5" class="form-control" autofocus>
سفارش شما تکمیل و ارسال شد
کد رهگیری بسته شما : %tracking_code%
رهگیری بسته های پستی در : tracking.post.ir
ممنون از اعتماد شما - ویتامین بوک
                        </textarea>
{{--                        <input name="sms-text" type="text" id="sms-text" class="form-control" autofocus />--}}
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-1 mb-3 w-100" type="submit">{{__('send')}}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
