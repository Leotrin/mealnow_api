@extends('layouts.new_admin')

@section('content')



    <div class="row-fluid card">
        <div class="grid simple card" style="padding:10px;">
                <div class="grid-title">
                    <a class="text-dark" data-toggle="collapse" href="#MenuManagementAccordion" aria-expanded="true"><h4>{{ $shop->name }} - Menu <span class="semi-bold">manangement</span></h4></a>
                </div>
                <div class="collapse show grid-body" id="MenuManagementAccordion">
                    <div class="col-md-12" style="padding:10px;">
                        <form action="{{url('admin/shop/'.$shop->id.'/menu/clone')}}" method="post">
                            {{csrf_field()}}
                            <div class="col-md-4">
                                <select name="clone_from_shop" class="form-control">
                                    @foreach($ourShops as $cloneShop)
                                        <option value="{{$cloneShop->id}}">{{$cloneShop->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="form-control btn btn-primary">Clone Menu</button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12" style="padding:10px;">
                        <form action="{{ url('admin/shop/'.$shop->id.'/menu/create/save') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" id="shop_id" name="shop_id" value="{{ $shop->id }}" />
                            <input type="hidden" id="menu" name="menu" value="" />
                            <input type="hidden" id="element_ids" name="element_ids" value="" />
                            <input type="hidden" id="element_count" name="element_count" value="" />
                            <input type="hidden" id="menuJson" name="menuJson" value="" />
                            <input type="hidden" id="categoriesJson" name="categoriesJson" value="" />
                            <input type="hidden" id="productsJson" name="productsJson" value="" />
                            <div class="col-md-12 p0" id="menuDesign">
                                <div class="col-md-12 p10">
                                    <div class="col-md-8 p10">
                                        <div class="col-md-9 p10">
                                            <label>Category Name : </label>
                                            <input type="text" id="category_name" class="form-control" placeholder="Category name" />
                                        </div>
                                        <div class="col-md-1 p10 text-center">
                                            <label>Active : </label>
                                            <input type="checkbox" id="status_active" class="bigCheckbox" value="1" checked/>
                                        </div>
                                        <div class="col-md-2 p10">
                                            <label>Order Nr. : </label>
                                            <input type="number" id="order_nr" value="1" step="1" min="1" class="form-control" />
                                        </div>
                                        <div class="col-md-12 p10">
                                            <label>Category Description :</label>
                                            <textarea id="category_description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2 p10">
                                        <label>&nbsp;</label>
                                        <button type="button" onClick="add_category('#menuItems')" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 p10" style="border:1px solid #ccc;background:#fafafa;margin: 5px;padding:10px;" id="menuItems">
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-12 p10 text-right">
                                <button type="submit" name="save" id="saveMenuButton" class="btn btn-primary hideElements">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
</div>
    </div>
@endsection

@section('footer')

    @if(isset($shop->menu) && $shop->menu->menu !=null)
        <script>

            var menuJson = {!! $shop->menu->menu  !!};
            // menuJson = JSON.parse(menuJson);
            var categoriesString = `{!! $shop->menu->categories !!}`;
            var productssString = `{!! $shop->menu->products !!}`;
            var categories = categoriesString.split(',');
            var products = productssString.split(',');
            var nr = parseInt({!! $shop->menu->element_count !!});

            $('#element_count').val(nr);
            $('#element_ids').val('{!! $shop->menu->element_ids !!}');
            $('#menuJson').val(JSON.stringify(menuJson));
            $('#categoriesJson').val(categories.toString());
            $('#productsJson').val(products.toString());

            $(document).ready(function(){
                //console.log(menuJson.items);
                $.each(menuJson.items, function(i,item){
                    item_html('#menuItems',i);
                });
            });

        </script>
    @else
        <script>
            var categories = [];
            var products = [];
            var nr = 0;

            var menuJson = {
                'client_id':{{ $shop->id }},
                'items':{},
                'status':true
            };
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
    <script src="{{ asset('js/availability.js') }}"></script>
    <script src="{{ asset('js/type.js') }}"></script>
    <script src="{{ asset('js/clone.js') }}"></script>
    <script src="{{ asset('js/topings.js') }}"></script>
    <script src="{{ asset('js/property.js') }}"></script>
    <script src="{{ asset('js/edit_product.js') }}"></script>
    <script src="{{ asset('js/product.js') }}"></script>
    <script src="{{ asset('js/generate_menu.js') }}"></script>
@endsection