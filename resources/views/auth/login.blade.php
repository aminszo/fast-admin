@extends('layouts.master')
@section('title' , __('login'))
@section('custom_css')
    <link rel="stylesheet" href="css/login.css">
@endsection
@section('body')
    <section style="background-color: #eee;">
        <div class="container py-3 py-md-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-xl-9">
                    <div class="card text-black">
                        <div class="row g-0">
                            <div class="col-lg-7">
                                <div class="card-body p-md-5 mx-md-2">
                                    <div class="text-center">
                                        <img src="images/logo.webp" style="width: 185px;" alt="logo">
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="email">{{__('email')}}</label>
                                            <input name="email" type="email" id="email" class="form-control" required autofocus />
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label" for="passwd">{{__('password')}}</label>
                                            <input name="password" type="password" id="passwd" class="form-control" required />
                                        </div>

                                        <div class="text-center py-1 mb-4">
                                            <button class="btn btn-primary border-0 btn-block fa-lg gradient-1 py-2 w-100" type="submit">{{__('login')}}</button>
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

                                        @if (Route::has('password.request'))
                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <a href="{{ route('password.request') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex align-items-center rounded-end-2 gradient-1">
                                <div class="text-white px-3 py-4 mx-md-4">
                                    <h4 class="mb-4">{{__('welcome_title')}}</h4>
                                    <p class="small mb-0">{{__('welcome_message')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
