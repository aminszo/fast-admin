<h1>here is test</h1><br/>

@php
    $referrer = request()->header('referer') ?? route('dashboard');
    dd($referrer);
@endphp
