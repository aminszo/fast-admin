@php
    $currentUrl = request()->url();
@endphp

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-xxl">
        @auth()
        @can('do-all')
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse1">
            <span class="navbar-toggler-icon"></span>
        </button>
{{--        <a href="#" class="navbar-brand">{{__('admin')}}</a>--}}
        <form class="d-flex ms-auto col-8 col-md-auto order-lg-last" action="{{ route('products') }}" method="GET">
            <input type="text" name="search" class="form-control me-sm-2" placeholder="{{__('search product')}}">
            <button type="submit" class="btn btn-outline-light"><i class="fas fa-search fa-lg"></i></button>
        </form>
        @endcan
        @endauth
        <div class="collapse navbar-collapse" id="navbarCollapse1">
            <div class="navbar-nav">
                @auth()
                <a href="{{ route('sms-book') }}" class="nav-item nav-link {{ $currentUrl == route('sms-book') ? 'active' : '' }}">{{__('پیامک خرید کتاب')}}</a>
                @can('do-all')
                <a href="{{ route('dashboard') }}" class="nav-item nav-link {{ $currentUrl == route('dashboard') ? 'active' : '' }}">{{__('dashboard')}}</a>
                <a href="{{ route('products') }}" class="nav-item nav-link {{ $currentUrl == route('products') ? 'active' : '' }}">{{__('products')}}</a>
                <a href="{{ route('bulk-product-edit') }}" class="nav-item nav-link {{ $currentUrl == route('bulk-product-edit') ? 'active' : '' }}">{{__('bulk edit')}}</a>
                <a href="{{ route('festival') }}" class="nav-item nav-link {{ $currentUrl == route('festival') ? 'active' : '' }}">جشنواره فروش</a>
                @if (Route::has('sms'))
                    <a href="{{ route('sms') }}" class="nav-item nav-link {{ $currentUrl == route('sms') ? 'active' : '' }}">{{__('SMS')}}</a>
                    @yield('custom_navbar_items')
                @endif
                @endcan
                @if (Route::has('logout'))
                    <a href="{{ route('logout') }}" class="nav-item nav-link">{{__('logout')}}</a>
                @endif
                @endauth
            </div>
        </div>

    </div>
</nav>
