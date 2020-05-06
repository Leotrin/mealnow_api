<h5 style="text-transform: capitalize;">{!! str_replace('_',' ',$property['name']) !!}</h5>
<div class="form-group col-md-12 p0">
    @foreach($property['options'] as $extraKey=>$extra)
        @if($extra!=null)
        <div class="col-md-12">
            <label class="checkboxLabel">
                <span> {!! $extra['name'] !!} <strong id="category_{{$categoryKey}}_product_{{$productKey}}_extra_{{$propertyKey}}_{!! $extraKey !!}" class="biteMeMultiple_price"></strong></span>
                <input type="checkbox" name="category_{{$categoryKey}}_product_{{$productKey}}_extra_{{$propertyKey}}_{!! $extraKey !!}" class="biteMeMultiple"
                       value="{!! $extra['name'] !!}"
                       onclick="addExtraMultiple({{$productKey}},'{{$extra['name']}}',{!! $propertyKey !!},{{$categoryKey}},{{$extraKey}})" />
                <span class="checkboxCheckmark"></span>
            </label>
        </div>
        <div class="clearfix"></div>
        @endif
    @endforeach
</div>
<div class="clearfix"></div>