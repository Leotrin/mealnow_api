
@if($menu['items'])
    @if(count($menu['items'])>0)
    @foreach($menu['items'] as $categoryKey => $category)
        @if($category!=null && $category['status'] == true)
            <div class="gold-members p-3 border-bottom" id="heading{!! $categoryKey !!}">
                <a class="btn btn-outline-secondary btn-sm  float-right" role="button" data-toggle="collapse" href="#collapse{!! $categoryKey !!}" aria-expanded="true">OPEN</a>
                <div class="media">
                    <div class="mr-3"></div>
                    <div class="media-body">
                        <h6 class="mb-1" role="button" data-toggle="collapse" href="#collapse{!! $categoryKey !!}" aria-expanded="true" style="cursor: pointer;">{{ $category['category_name'] }}</h6>
                        <p class="text-gray mb-0">{{$category['category_description']}}</p>
                    </div>
                </div>
            </div>
            <div id="collapse{!! $categoryKey !!}" class="panel-collapse collapse accordion-content" role="tabpanel" >
                <div class="gold-members p-3 border-bottom" style="background-color: rgba(228,235,242,0.32)" >
                    <div class="media">
                        <div class="mr-3"></div>
                        <div class="media-body">
                            @if(!empty($category['products']))
                                @php $newRow = 0; @endphp
                                <div class="row">
                                    @foreach($category['products'] as $productKey => $product)
                                        @if($product!=null)
                                            <?php $prodName = str_replace(' ','_',$product['name']); ?>
                                            <div class="col-md-6">
                                                <div class="row p0 menuProductDesign">
                                                    <div class="col-md-9 p0" style="padding-top:5px;">
                                                        <strong onclick="reloadProduct({!! $categoryKey !!},{!! $productKey !!}, {!!  key($product['type']) !!}, {!! $product['type'][0]['price'] !!})"
                                                                data-toggle="modal" data-target="#category_{{$categoryKey}}_product_{{$productKey}}">
                                                            <span style="color:#2E3589;">{{ $product['name'] }}</span>
                                                            @if(isset($product['isSpecial']) && $product['isSpecial']===true)
                                                                <small style="font-size:8pt;">Special</small>
                                                            @endif
                                                        </strong>
                                                        @if(!empty($product['type']) && isset($product['type']['price']))
                                                        $ {!! number_format($product['type']['price'],2)  !!}+
                                                        @endif
                                                        <br />
                                                        <span>{!! $product['description'] !!} &nbsp;</span>
                                                    </div>
                                                    <div class="col-md-3 text-right" style="padding:5px;">
                                                        <button type="button" class="btn btn-sm  btn-outline-secondary"
                                                                style="padding: 7px 10px 5px 10px !important;"
                                                                @if($shop->isOnlyShow == false)
                                                                    onclick="reloadProduct({!! $categoryKey !!},{!! $productKey !!}, {!!  key($product['type']) !!}, {!! $product['type'][0]['price'] !!})"
                                                                    data-toggle="modal" data-target="#category_{{$categoryKey}}_product_{{$productKey}}"
                                                                @else
                                                                    onclick="alert('This Restaurant currently is not accepting online orders')"
                                                                @endif

                                                        >ADD</button>
                                                    </div>
                                                    @include('frontend.shop.menu.popup_product')
                                                </div>
                                            </div>
                                            @php $newRow = $newRow + 1; @endphp
                                            @if($newRow%2==0)
                                                <div class="clearfix"></div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
    {{--                        <h6 class="mb-1" role="button" data-toggle="collapse" href="#collapse{!! $categoryKey !!}" aria-expanded="true" style="cursor: pointer;">{{ $category['category_name'] }}</h6>--}}
    {{--                        <p class="text-gray mb-0">{{$category['category_description']}}</p>--}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
@endif
