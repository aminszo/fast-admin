@extends('layouts.master')
@section('title', __('bulk edit'))
@section('body')
    <x-navbar/>
    <div class="container">
        <div class="row">
            <form action=" {{ route("bulk-product-update") }}" method="POST" class="row">
                @csrf
                <div class="col-sm-6 col-md-3 my-3 mx-4">
                    @foreach($categories as $cat)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{$cat['id']}}" name="category[]" value="{{$cat['id']}}">
                            <label for="html"  class="form-check-label">{{$cat['name']}}</label><br>
                        </div>
                    @endforeach
                </div>
                <div class="col-sm-4 my-4">

                    <div class="form-group mb-4">
                        <label class="form-label" for="stock-status">وضعیت موجودی</label>
                        <select name="stock_status" id="stock-status" class="form-select w-100" title="{{__('stock status')}}">
                            <option value="no-change" selected >بدون تغییر</option>
                            <option value="instock" >همه موجود شوند</option>
                            <option value="outofstock">همه ناموجود شوند</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="discount">درصد تخفیف</label>
                        <input name="discount_percent" type="text" id="discount" class="form-control" placeholder="بدون تغییر" />
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="regular-price">قیمت معمول</label>
                        <input name="regular_price" type="text" id="regular-price" class="form-control" placeholder="بدون تغییر" />
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="sale-price">قیمت فروش ویژه</label>
                        <input name="sale_price" type="text" id="sale-price" class="form-control" placeholder="بدون تغییر" />
                    </div>

                    <div class="text-center py-1 mb-4">
                        <button class="btn btn-primary border-0 btn-block fa-lg gradient-1 py-2 w-100" type="submit">ثبت تغییرات</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
