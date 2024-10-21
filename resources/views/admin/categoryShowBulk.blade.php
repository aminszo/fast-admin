
@foreach($category as $cat)
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="{{$cat['id']}}" name="category" value="{{$cat['id']}}">
    <label for="html"  class="form-check-label">{{$cat['name']}}</label><br>
    </div>
@endforeach
