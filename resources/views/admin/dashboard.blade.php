@extends('layouts.master')
@section('title', __('dashboard'))
@section('body')
    <x-navbar/>
    <div class="container-lg">
        <div class="row justify-content-evenly text-center mt-2 px-1">
            <div class="col-md col-lg-3 my-1 p-3 p-lg-4 mx-2 rounded-5 gradient-box-1">
                تعداد کل محصولات :
                {{ $total_count }}
            </div>
            <div class="col-sm col-lg-3 my-1 p-3 p-lg-4 mx-2 rounded-5 gradient-box-1">
                تعداد محصولات موجود :
                {{ $instock_count }}
            </div>
            <div class="col-sm col-lg-3 my-1 p-3 p-lg-4 mx-2 rounded-5 gradient-box-1">
                تعداد محصولات ناموجود :
                {{ $outofstock_count }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-12 offset-lg-0 g-5 ">
                    <div class="text-center mt-4 w-75 section-title">تعداد محصولات هر ناشر</div>
                    <table class="table table-striped small">
                        <thead>
                        <tr>
{{--                            <td>آیدی</td>--}}
                            <td>ناشر</td>
                            <td>تعداد محصول</td>
                        </tr>
                        </thead>
                    @foreach($publishers as $pub)
                        <tr>
{{--                            <td>{{ $pub->id }}</td>--}}
                            <td>{{ $pub->name }}</td>
                            <td>{{ $pub->count }}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
            <div class="col-lg-6 p-4">
                <div class="text-center mt-4 w-75 section-title">10 محصول پرفروش</div>
                <table class="table table-striped small">
                    <thead>
                    <tr>
                        <td>محصول</td>
                        <td>تعداد فروش</td>
                    </tr>
                    </thead>
                    @foreach($best_sellers as $product)
                        <tr>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->sales }}</td>
                        </tr>
                    @endforeach
                </table>

                <div class="text-center mt-4 mb-2 w-100 section-title">تعداد محصولات هر دسته بندی</div>
                @include('admin.categoryShow', ['category' => $categories])
            </div>
        </div>
    </div>
@endsection
