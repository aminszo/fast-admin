<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="#" class="navbar-brand">{{__('admin')}}</a>


        <div class="collapse navbar-collapse" id="navbarCollapse1">
            <div class="navbar-nav">
                @auth()
                    <a href="{{ route('dashboard') }}" class="nav-item nav-link">{{__('dashboard')}}</a>
                    <a href="{{ route('products') }}" class="nav-item nav-link">{{__('products')}}</a>
                    @if (Route::has('sms'))

                        <a href="{{ route('sms') }}" class="nav-item nav-link">{{__('SMS')}}</a>
                        @yield('custom_navbar_items')
                    @endif
                    @if (Route::has('logout'))
                        <a href="{{ route('logout') }}" class="nav-item nav-link">{{__('logout')}}</a>
                    @endif
                @endauth
            </div>
            <form class="d-flex me-auto" action="{{ route('products') }}" method="GET">
                <input type="text" name="search" class="form-control me-sm-2" placeholder="{{__('search products')}}">
                <button type="submit" class="btn btn-outline-light">{{__('search')}}</button>
            </form>
        </div>
    </div>
</nav>
