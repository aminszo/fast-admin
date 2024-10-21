@extends('layouts.master')
@section('title', __('SMS'))
@section('body')

    <x-navbar/>

    <div class="container">

        <div class="row mt-5 mb-3">
            <div class="col-lg-8 offset-lg-2">
                <div class="col-sm-2 col-3 text-center pt-1 mb-5 pb-1">
                    <a href="{{route("sms-pattern")}}" class="btn btn-info btn-block fa-lg gradient-1 mb-3 w-100" >ارسال با پترن</a>
                </div>

                <form method="POST" action="{{ route('send-single-sms') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="phone-number">{{__('phone number')}} (هر شماره را در یک خط بنویسید) :</label>
                        <textarea name="phone-numbers" id="phone-numbers" rows="2" class="form-control" autofocus></textarea>

{{--                        <input name="phone-number" type="text" id="phone-number" class="form-control" autofocus />--}}
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label" for="sms-text">{{__('sms text')}} :</label>
                        <textarea name="sms-text" id="sms-text" cols="30" rows="3" class="form-control" autofocus></textarea>
{{--                        <input name="sms-text" type="text" id="sms-text" class="form-control" autofocus />--}}
                    </div>

                    <input name="sms-type" type="text" id="sms_type" class="form-control" value="service" hidden />

                    <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-1 mb-3 w-100" type="submit">{{__('send')}}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="alert alert-info text-justify">
            توجه داشته باشید که پیامک های با متن متغیر ممکن است تا ده دقیقه (یا بیشتر) طول بکشد
            تا به گیرنده برسند. برای ارسال سریعتر میتوانید از ارسال پیامک با پترن استفاده کنید.
        </div>
    </div>
@endsection
