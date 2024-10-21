@extends('layouts.master')
@section('title', __('SMS'))
@section('body')

    <x-navbar/>

    <div class="container">

        <div class="row mt-5 mb-3">
            <div class="col-lg-8 offset-lg-2">

                <form method="POST" action="{{ route('send-single-sms') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label class="form-label" for="phone-number">{{__('phone number')}} (هر شماره را در یک خط بنویسید) :</label>
                        <textarea name="phone-numbers" id="phone-numbers" rows="2" class="form-control" autofocus></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label" for="sms-text">{{__('sms text')}} :</label>
                        <textarea name="sms-text" id="sms-text" cols="30" rows="3" class="form-control" autofocus>کتاباتو میفروشی؟ ما همه رو یکجا میخریم!
برای هماهنگی لیست کتابات رو در ایتا یا تلگرام بفرست به شماره 09363809469 
برای اطمینان ««کتاب دست دوم ویتامین بوک»» رو در گوگل سرچ کن</textarea>
                    </div>

                    <input name="sms-type" type="text" id="sms_type" class="form-control" value="advertise" hidden />
                    
                    <div class="text-center pt-1 mb-5 pb-1">
                        <button class="btn btn-primary btn-block fa-lg gradient-1 mb-3 w-100" type="submit">{{__('send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
