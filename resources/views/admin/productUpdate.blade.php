@extends('layouts.master')
@section('title', __('product update'))
@section('body')
    <x-navbar/>
    <div class="container">
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
        @if($status == "success")
            <div class="alert alert-success mt-3 text-center">
                محصول با موفقیت بروز شد
            </div>
        @endif
        <div class="alert {{$class}} my-3 ">
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($messages as $msg)
                    <li>{{ $msg }}</li>
                @endforeach

            </ul>
        </div>
    @endif
    <div class="container d-flex justify-content-center">
        <a href="{{request()->header('referer') ?? route('dashboard')}}"><button class="btn btn-lg btn-primary">بازگشت</button></a>
    </div>
    </div>
@endsection
