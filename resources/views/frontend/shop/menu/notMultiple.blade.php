@if($property['options']!=null)
<h5 style="text-transform: capitalize;">{!! str_replace('_',' ',$property['name']) !!}</h5>
<div class="form-group col-md-12 p0">
    @foreach($property['options'] as $extraKey=>$extra)
        @if($extra!=null)
        <div class="col-md-12">
            <label class="radioLabel">
                <span> {!! $extra['name'] !!} <strong id="category_{{$categoryKey}}_product_{{$productKey}}_extra_{{$propertyKey}}_{!! $extraKey !!}_notMultiple" class="biteMeNotMultiple_price"></strong></span>
                <input type="radio" name="category_{{$categoryKey}}_product_{{$productKey}}_extra_{{$propertyKey}}" class="biteMeMultiple"
                       value="{{ $extra['name'] }}"
                       onclick="addExtraNotMultiple({{$productKey}},'{{$extra['name']}}',{!! $propertyKey !!},{{$categoryKey}},{{$extraKey}})" />
                <span class="radioCheckmark"></span>
            </label>
        </div>
        <div class="clearfix"></div>
        @endif
    @endforeach
</div>
<div class="clearfix"></div>
@endif