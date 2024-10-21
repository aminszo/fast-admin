@extends('layouts.master')
@section('title', __('bulk update'))
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

            <div class="alert {{$class}} my-3 ">
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($messages as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach

                </ul>
            </div>
            @if(isset($cache))
                <form action="{{ route("bulk-product-delete-cache") }}" method="post">
                    @csrf
                    <input hidden name="id_bag" type="text" id="id_bag" value="{{serialize($changed_ids)}}"/>
                    <div class="text-center py-1 mb-4">
                        <button class="btn btn-primary border-0 btn-block fa-lg gradient-1 py-2 w-100" type="submit">حدف کش محصولات بروز شده</button>
                    </div>
                </form>
                <form action="{{ route("bulk-product-delete-cache") }}" method="post">
                    @csrf
                    <input hidden name="delete_all" type="text" id="delete-all" value="true"/>
                    <div class="text-center py-1 mb-4">
                        <button class="btn btn-primary border-0 btn-block fa-lg gradient-1 py-2 w-100" type="submit">حدف کش کل سایت</button>
                    </div>
                </form>
            @endif
        @endif
        <div class="container d-flex justify-content-center">
            <a href="{{request()->header('referer') ?? route('bulk-product-edit')}}"><button class="btn btn-lg btn-primary">بازگشت</button></a>
        </div>
    </div>
@endsection
