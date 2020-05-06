<div class="modal fade" id="category_{{$categoryKey}}_product_{{$productKey}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ $product['name'] }} </h4>
                <h6 class="modal-title" id="myModalLabel">{{ $product['description'] }} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="{{$prodName}}">
                    <div class="form-group">
                    @if(!empty($product['type']))
                        <h5>
                            Choose an option
                        </h5>
                        @foreach($product['type'] as $typeKey=>$value)
                            @if($value!=0)
                                <label for="category_{{$categoryKey}}_product_{{$productKey}}_type_{{$typeKey}}" class="radioLabel" style="text-transform: capitalize;">
                                    {!! $value['name'].' - '.number_format((float)$value['price'],2) !!}  &pound;
                                    <input type="radio" name="category_{{$categoryKey}}_product_{{$productKey}}_type"
                                            id="category_{{$categoryKey}}_product_{{$productKey}}_type_{{$typeKey}}"
                                            @if($typeKey==0) checked @endif
                                            onclick="changeOption({{$productKey}},{{$typeKey}},{{number_format((float)$value['price'],2)}})"
                                            value="{{ $typeKey }}" />
                                    <span class="radioCheckmark"></span>
                                </label>
                            @endif
                        @endforeach
                            <hr />
                    @endif
                    @if(isset($product['topings']) && !empty($product['topings']['options']))
                        @include('frontend.shop.menu.isPizzaTopings')
                    @endif
                    @if(!empty($product['properties']))
                        @foreach($product['properties'] as $propertyKey=>$property)
                            @if($property!=null)
                                <hr />
                                @if($property['multiple']===true)
                                    @include('frontend.shop.menu.multiple')
                                @else
                                    @include('frontend.shop.menu.notMultiple')
                                @endif
                            @endif
                        @endforeach
                    @endif
                    <h5>Special requests</h5>
                    <textarea name="special" id="category_{{$categoryKey}}_product_{{$productKey}}_special_requests" class="form-control"
                              style="max-width:100%;min-width:100%;max-height:300px;min-height:100px;"
                              placeholder="Hold the anchovies? Side of marinara? Tell us here. (You may be charged for any special requests after your order is complete.)"></textarea>
                    <br />
                        <div class="row ">
                            <div class="col-md-5">
                                <label>Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <img src="{{asset('front/icons/minus_black.png')}}" onclick="minus({{$categoryKey}},{{$productKey}})" style="height:16px;" />
                                    </span>
                                    <input type="number" id="category_{{$categoryKey}}_product_{{$productKey}}_qty" class="form-control" value="1" readonly min="1" step="1">
                                    <span class="input-group-addon">
                                        <img src="{{asset('front/icons/plus_black.png')}}" onclick="plus({{$categoryKey}},{{$productKey}})" style="height:16px;" />
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                <label>&nbsp;</label>
                                <h4 id="total_{{$productKey}}">
                                    0.00 &pound;
                                </h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <br />
                        <input type="hidden" name="product{{$productKey}}" value="" id="productJson{{$productKey}}" />
                        <button type="button" class="btn btn-primary" style="width:100%;" onclick="add_to_cart({{$productKey}},{{$categoryKey}});">Add to cart</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
