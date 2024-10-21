@extends('layouts.master')
@section('title', __('Products'))
@section('body')
    <x-navbar/>

    <div class="container-xxl " style="background-color: #eee">
        <div class="row single-product bg-light-subtle mb-4 mb-md-3 py-2 text-center align-items-center justify-content-center">
            <form action=" {{ route("create-price-backup") }}" method="POST" class="row">
                @csrf
                <div class="col-lg-9 col-md-6 mb-2 m-lg-0 p-0 px-md-2 align-self-center">
                    <input type="text" name="description" class="form-control" placeholder="توضیحات" value="" >
                </div>
                <div class="col-7 col-lg col-md-7 p-0 px-sm-2 align-self-center text-end">
                    <button type="submit" class="btn py-2 px-4 m-0 btn-success">گرفتن پشتیبان</button>
                </div>
            </form>
        </div>

    @foreach($backups as $item)
        <div class="row single-product bg-light-subtle mb-4 mb-md-3 py-2 text-center align-items-center justify-content-center">
            <form action=" {{ route("apply-backup") }}" method="post" class="row">
                @csrf

                <input type="text" name="id" hidden value="{{ $item->id }}" >
                <div class="col-lg-2 col-md-6 mb-2 m-lg-0 p-0 px-md-2 align-self-center" title="{{__('regular price')}}">
                    {{$item->id}}
                </div>
                <div class="col-12 col-lg-4 col-md-12 mb-2 m-md-0 align-self-center py-1 rounded" title="{{__('post title')}}">{{ $item->description }}</div>

                <div class="col-lg-2 col-md-6 mb-2 m-lg-0 p-0 px-md-2 align-self-center" title="{{__('regular price')}}">
                    {{$item->date}}
                </div>

                <div class="p-1 col-5 col-lg-2 col-md-5 m-md-0 align-self-center rounded ">
                    <select name="stock_status" class="form-select w-100" title="{{__('stock status')}}">
                        <option value="1" >بازگردانی درصد ها</option>

                    </select>
                </div>

                <div class="col-7 col-lg col-md-7 p-0 px-sm-2 align-self-center text-end">
                    <button type="submit" class="btn py-2 px-4 m-0 btn-success">بازگردانی</button>
                    <button type="submit" name="delete" value="1" class="btn py-2 px-4 m-0 btn-danger">حذف</button>
                </div>
            </form>
        </div>
    @endforeach
    </div>
@endsection
