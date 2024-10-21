@extends('layouts.master')
@section('title', __('Products'))
@section('body')
    <x-navbar/>
    <div class="container-xxl " style="background-color: #eee">
        <div class="row text-center">
            <div class="col-md-3 my-3">
                تعداد نتایج :
                {{count($products)}}
            </div>
        </div>
        @foreach($products as $product)
            <div class="row single-product bg-light-subtle mb-4 mb-md-3 py-2 text-center align-items-center justify-content-center">
                <form action=" {{ route("update-product") }}" method="GET" class="row">

                    @php
                        $class = $product->stock_status == "instock" ? "instock" : "outofstock";
                    @endphp

                    <input type="text" name="id" hidden value="{{ $product->ID }}" >
                    <div class="col-12 col-lg-4 col-md-12 mb-2 m-md-0 align-self-center py-1 rounded" title="{{__('post title')}}">{{ $product->post_title }}</div>

                    <div class="col-lg-2 col-md-6 mb-2 m-lg-0 p-0 px-md-2 align-self-center" title="{{__('regular price')}}">
                        <input type="text" name="regular_price" class="form-control" value="{{ $product->regular_price }}" >
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2 m-lg-0 p-0 px-md-2 align-self-center" title="{{__('sale price')}}">
                        <input type="text" name="sale_price" class="form-control" value="{{ $product->sale_price }}" >
                    </div>

                    <div class="p-1 col-5 col-lg-2 col-md-5 m-md-0 align-self-center rounded {{$class}}">
                        @php
                            $attribute = $product->stock_status == "outofstock" ? "selected" : "";
                        @endphp
                        <select name="stock_status" class="form-select w-100" title="{{__('stock status')}}">
                            <option value="instock" >{{__("in stock")}}</option>
                            <option value="outofstock" {{ $attribute }}>{{__("out of stock")}}</option>
                        </select>
                    </div>

                    <div class="col-7 col-lg col-md-7 p-0 px-sm-2 align-self-center text-end">
                        <button type="submit" class="btn py-2 px-4 m-0 btn-success"><i class="fas fa-check fa-lg"></i></button>
                        <a href="https://vitaminbook.ir/{{$product->ID}}" target="_blank" class="btn py-2 btn-success"><i class="fas fa-eye fa-lg"></i></a>
{{--                        <a href="https://vitaminbook.ir/wp-admin/post.php?post={{$product->ID}}&action=edit" target="_blank" class="btn btn-info"><i class="fab fa-wordpress fa-lg"></i></a>--}}
                    </div>
                </form>
            </div>
        @endforeach
    </div>
@endsection


