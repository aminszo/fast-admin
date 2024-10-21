<ul class="">
    @foreach($category as $cat)
        @continue($cat['id'] == 145)
        <li data-bs-toggle="collapse" data-bs-target="#{{$cat['id']}}" aria-expanded="false" aria-controls="{{$cat['id']}}">
            {{$cat['name']." : ".$cat['count']}}
{{--            <a href="/public/admin/products/{{$cat['id']}}">i</a>--}}
            <div class="collapse" id="{{$cat['id']}}">

            @if(!empty($cat['sub']))
                @include('admin.categoryShow', ['category' => $cat['sub']])
            @endif
        </div>
        </li>
    @endforeach
</ul>
