@extends('layouts.master')
@section('customCss_Js')
    <link rel="stylesheet" href="css/login.css">
@endsection
@section('body')
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="images/logo.webp" style="width: 185px;" alt="logo">
                                    </div>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="name">{{__('name')}}</label>
                                            <input name="name" type="text" id="name" class="form-control" required autofocus />
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="email">{{__('email')}}</label>
                                            <input name="email" type="email" id="email" class="form-control" required />
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="passwd">{{__('password')}}</label>
                                            <input name="password" type="password" id="passwd" class="form-control" required />
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="passwd_confirm">{{__('password confirm')}}</label>
                                            <input name="password_confirmation" type="password" id="passwd_confirm" class="form-control" required />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-block fa-lg gradient-1 mb-3 w-100" type="submit">{{__('register')}}</button>
                                        </div>

                                        <!-- Validation Errors -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-1">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4"></h4>
                                    <p class="small mb-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
