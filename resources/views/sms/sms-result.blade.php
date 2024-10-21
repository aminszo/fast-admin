@extends('layouts.master')
@section('title', __('product update'))
@section('body')
    <x-navbar/>
    <div class="container">
        <div class="col-lg-8 offset-lg-2">
        <!-- Display Messages -->
        @if(isset($messages))
        @php
        if ($status == "fail")
        $class = "alert-danger";
        elseif ($status == "success")
        $class = "alert-success";
        else
        $class = "alert-info";
        @endphp
        <div class="alert {{$class}} mt-2 text-center ">
            <p class="mt-3 text-red-600">
                @foreach ($messages as $msg)
                <p>{{ $msg }}</p>
                @endforeach

            </p>
        </div>
        @endif
        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container d-flex justify-content-center">
            <a href="{{request()->header('referer') ?? route('sms')}}"><button class="btn btn-lg btn-primary">بازگشت</button></a>
        </div>
        </div>
    </div>
@endsection
