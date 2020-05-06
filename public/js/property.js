function generate_property(number, nr){
    return `
    <button type="button" data-toggle="modal" data-target="#product_property`+number+`_`+ nr + `" class="btn btn-primary btn-small">
        <i class="fa fa-cog"></i> Property
    </button>
    <div class="modal fade" id="product_property`+number+`_`+ nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Product Property</h4>
          </div>
          <div class="modal-body text-left">
            <div class="col-md-12">
                <label>Property Name</label>
                <input type="text" id="`+number+`_`+nr+`_property_name" placeholder="Topings, Extras, Speciality" class="form-control" />
            </div>
            <div class="col-md-4">
                <label>Minimum Selection</label>
                <input type="number" id="`+number+`_`+nr+`_property_min" value="0" min="0" step="1" class="form-control" />
            </div>
            <div class="col-md-4">
                <label>Maximum Selection</label>
                <input type="number" id="`+number+`_`+nr+`_property_max" value="5" min="0" step="1" class="form-control" />
            </div>
            <div class="col-md-2 text-center">
                <label>Multiple</label>
                <input type="checkbox" id="`+number+`_`+nr+`_property_multiple" checked/>
            </div>
            <div class="col-md-2">
                <label>Order</label>
                <input type="number" id="`+number+`_`+nr+`_property_order" value="1" min="1" step="1" class="form-control" />
            </div>
          <div class="clearfix"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveProperty(`+number+`,` + nr + `)">Save changes</button>
          </div>
        </div>
      </div>
    </div>`;
}
function saveProperty(number,nr){
    var name = $('#'+number+'_'+nr+'_property_name').val();
    var multiple = false;
    var min      = $('#'+number+'_'+nr+'_property_min').val();
    var max      = $('#'+number+'_'+nr+'_property_max').val();
    var order    = $('#'+number+'_'+nr+'_property_order').val();
    if ($('#'+number+'_'+nr+'_property_multiple:checkbox:checked').length > 0){
        multiple = true;
    }
    var properties = menuJson.items[number].products[nr].properties, propertyNr;
    for (propertyNr in properties){ };
    if(propertyNr==null){
        propertyNr = 1;
    }else{
        propertyNr = parseInt(propertyNr) +1;
    }
    menuJson.items[number].products[nr].properties[propertyNr] = {
        "name":name,
        "min":min,
        "max":max,
        "order":order,
        "multiple":multiple,
        "options":{}
    };
    $('#'+number+'_'+nr+'_property_name').val('');
    $('#'+number+'_'+nr+'_property_min').val(0);
    $('#'+number+'_'+nr+'_property_max').val(5);
    $('#'+number+'_'+nr+'_property_order').val(parseInt(order)+1);
    $('#'+number+'_'+nr+'_product_property').trigger('click.dismiss.bs.modal');
    save_menu();
    html_property(number,nr,propertyNr);
    //console.log(menuJson.items[number].products[nr].properties);
}
function generate_properties(number,nr,properties){
    if(properties!=null){
        $.each(properties, function(i, item) {
            if(item!=null) {
                html_property(number, nr, i);
            }
        });
    }else{
        return '';
    }
}
function html_property(number,nr,property){
    var props =menuJson.items[number].products[nr].properties[property];
    var property_html = `
            <div class="col-md-12 p5" style="border:1px solid #ccc;background: #fff;" id="` + number + `_`  + nr + `_product_`+property+`_box">
                <div class="panel-group" id="` + number + `_` + nr + `_product_property_`+property+`" role="tablist" aria-multiselectable="true" style="margin:0;">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading` + number + `_` + nr + `_product_property_`+property+`" style="background: #0aa699;color:#fff !important;">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse` + number + `_` + nr + `_product_property_`+property+`" aria-expanded="true"  style="color:#fff !important;">                      
                            <i class="fa fa-list-alt"></i> Property: `+props.name+`
                        </a>
                      </h4>
                    </div>
                    <div id="collapse` + number + `_` + nr + `_product_property_`+property+`" class="collapse hidden grid-body" role="tabpanel" style="padding-top:5px;">
                        
                        <div class="col-md-2 pull-right">
                        <button type="button" data-toggle="modal" data-target="#product_`+ number + `_` + nr + `_` +property+ `_delete" class="pull-right btn btn-danger btn-small">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="modal fade" id="product_` + number + `_`+ nr +`_`+property+`_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                              </div>
                              <div class="modal-body text-center">
                                <h2>Are you sure ?</h2>
                              <div class="clearfix"></div>
                              </div>
                              <div class="modal-footer text-center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                <button type="button" class="btn btn-danger" onclick="delete_property(`+number+`,` + nr + `,`+property+`)" data-dismiss="modal">YES</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <button type="button" data-toggle="modal" data-target="#product_` + number + `_` + nr + `_` +property+`_settings" class="pull-right btn btn-success btn-small" style="margin-right:2px;">
                            <i class="fa fa-cogs"></i>
                        </button>
                        </div>
                        <div class="col-md-7">
                            <label>`+props.name+` Name</label>
                            <input type="text" id="` + number + `_`  + nr + `_`+property+`_name" class="form-control" />`;
                            property_html = property_html + type_prices_property(number, nr, property);
                            property_html = property_html + `</div>
                        <div class="col-md-2">
                            <label>Order nr.:&nbsp;</label>
                            <input type="number" id="`+number+`_`+nr+`_`+property+`_order" min="1" step="1" value="1" class="form-control" />
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" onclick="save_property_item(`+number+`,`+nr+`,`+property+`)" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-group" id="` + number + `_`  + nr + `_product_`+property+`" role="tablist" aria-multiselectable="true" style="margin-top:5px;">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading` + number + `_`  + nr + `_product_`+property+`">
                      <h4 class="panel-title"><a role="button" data-toggle="collapse"  href="#collapse` + number + `_`  + nr + `_product_`+property+`" aria-expanded="true" >`+props.name+`</a></h4>
                    </div>
                    <div id="collapse` + number + `_`  + nr + `_product_`+property+`" class="collapse hidden grid-body" role="tabpanel" >
                      <div class="panel-body"style="background: #efefef;">
                        <div class="grid-body" style="padding:0px;">
                        <table class="table table-striped table-hover" id="example1">
                            <thead>
                                <tr>
                                    <td>Name</td>`;
                                    $.map( menuJson.items[number].products[nr].type, function( n, i ) {
                                        if(n!=null){
                                            property_html = property_html+`<td>`+n.name+`</td>`;
                                        }
                                    });
                                    property_html = property_html+`
                                    <td>Order nr.</td>
                                    <td></td>
                                </tr>  
                            </thead>
                            <tbody id="` + number + `_`  + nr + `_product_`+property+`_list" ></tbody>
                        </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </div>
            </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="modal fade" id="product_` + number + `_` + nr + `_` +property+`_settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Product `+props.name+` Settings</h4>
                  </div>
                  <div class="modal-body text-left">
                    <div class="col-md-4">
                        <label>Minimum Selection</label>
                        <input type="number" id="` + number + `_` +nr+`_`+property+`_min" value="`+props.min+`" min="0" step="1" class="form-control" />
                    </div>
                    <div class="col-md-4">
                        <label>Maximum Selection</label>
                        <input type="number" id="` + number + `_` +nr+`_`+property+`_max" value="`+props.max+`" min="0" step="1" class="form-control" />
                    </div>
                    <div class="col-md-2 text-center">
                        <label>Multiple</label>
                        <input type="checkbox" id="`+number+`_`+nr+`_`+property+`_multiple" `+statusChecked(props.multiple)+`/>
                    </div>
                    <div class="col-md-2">
                        <label>Order</label>
                        <input type="number" id="` + number + `_` +nr+`_`+property+`_order_" value="`+props.order+`" min="1" step="1" class="form-control" />
                    </div>
                  <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_item_setting(`+number+`,` + nr + `,`+property+`)" data-dismiss="modal">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
        `;
    $('#' + number + '_' + nr + '_property').append(property_html);
    if(props.options !=null) {
        $.each(props.options, function(i,item){
            property_items_html(number, nr, property, i);
        });
    }
}
function type_prices_property(number, nr, property){

    myReturn = ``;
    $.map( menuJson.items[number].products[nr].type, function( n, i ) {
        if(n!=null) {
            myReturn = myReturn + `
            <div class="col-md-6">
                <label>` + n.name + ` Price</label>
                <input type="number" id="` + i + `_` + number + `_` + nr + `_` + property + `_price" min="0" value="" step=".01"  class="form-control" />
            </div>
            <div class="clearfix"></div>`;
        }
    });

    return myReturn;
}
function save_item_setting(number,nr,property){
    var min     = $('#'+number+'_'+nr+'_'+property+'_min').val();
    var max     = $('#'+number+'_'+nr+'_'+property+'_max').val();
    var order   = $('#'+number+'_'+nr+'_'+property+'_order_').val();
    console.log(order);
    var multiple= false;

    if ($('#'+number+'_'+nr+'_'+property+'_multiple:checkbox:checked').length > 0){
        multiple = true;
    }
    menuJson.items[number].products[nr].properties[property] = {
        "name":menuJson.items[number].products[nr].properties[property].name,
        "min":min,
        "max":max,
        "order":order,
        "multiple":multiple,
        "options":menuJson.items[number].products[nr].properties[property].options
    };
    save_menu();
    $('#'+number+'_'+nr+'_product_'+property+'_settings').trigger('click.dismiss.bs.modal');
}
function save_property_item(number,nr,property){
    var property_item_name = $('#'+number+'_'+nr+'_'+property+'_name').val();
    var property_item_order = $('#'+number+'_'+nr+'_'+property+'_order').val();
    if(property_item_name!=null && property_item_name!="" && property_item_order!=null && property_item_order!=""){

        var propertiesItems = menuJson.items[number].products[nr].properties[property].options, propertyItemNr;
        for (propertyItemNr in propertiesItems){ };
        if(propertyItemNr==null){
            propertyItemNr = 1;
        }else{
            propertyItemNr = parseInt(propertyItemNr) +1;
        }
        menuJson.items[number].products[nr].properties[property].options[propertyItemNr] = {
            'name': property_item_name,
            'order':property_item_order,
            'prices': {}
        };

        $.map(menuJson.items[number].products[nr].type, function (n, i) {
            if(n!=null) {
                var price = $('#' + i + '_' + number + '_' + nr + '_' + property + '_price').val();
                menuJson.items[number].products[nr].properties[property].options[propertyItemNr].prices[i] = {
                    'price': price,
                };
            }
        });

        save_menu();
        property_items_html(number,nr,property,propertyItemNr);
        alert("success");
    }else{
        alert('Enter property name & order nr!');
    }
}
function delete_property(number, nr, property){
    $('#product_'+number+'_'+ nr +'_'+property+'_delete').on('hidden.bs.modal', function (e) {
        $('#' + number + '_' + nr + '_product_' + property + '_box').remove();
        delete menuJson.items[number].products[nr].properties[property];
        save_menu();
    });

}
function property_items_html(number,nr,property,item){
    var propertyItem =menuJson.items[number].products[nr].properties[property].options[item];
    if(propertyItem != null) {
        var productToping = $('#' + number + '_' + nr + '_product_' + property + '_list');
        var toping_html = `
            <tr id="` + number + `_` + nr + `_product_` + property + `_item">
                <td style="max-width:50%;word-break:break-word;"><input type="text" value="` + propertyItem.name + `" onkeyup="changeSingleProperty(` + number + `,` + nr + `,` + property + `,` + item + `, 'name',0)" id="` + number + `_` + nr + `_` + property + `_` + item + `_name" class="form-control" /></td>`;

        $.map(menuJson.items[number].products[nr].type, function (n, i) {
            if (n != null) {
                var myvariable = propertyItem.prices[i];
                if (myvariable != null) {
                    toping_html = toping_html + `<td>
                        <input type="number" onkeyup="changeSingleProperty(` + number + `,` + nr + `,` + property + `,` + item + `, 'price', ` + i + `)" id="` + number + `_` + nr + `_` + property + `_` + item + `_price_` + i + `" min="0" step="0.01" value="` + propertyItem.prices[i].price + `" class="form-control" /></td>`;
                } else {
                    toping_html = toping_html + `<td>
                        <input type="number" onkeyup="changeSingleProperty(` + number + `,` + nr + `,` + property + `,` + item + `, 'price', ` + i + `)" id="` + number + `_` + nr + `_` + property + `_` + item + `_price_` + i + `" min="0" step="0.01" value="0" class="form-control" /></td>`;
                }
            }
        });
        toping_html = toping_html + `
                <td style="max-width:10%;"><input type="number" value="` + propertyItem.order + `" min="1" step="1" onkeyup="changeSingleProperty(` + number + `,` + nr + `,` + property + `,` + item + `, 'order',0)" id="` + number + `_` + nr + `_` + property + `_` + item + `_order" class="form-control" /></td>
                <td class="text-right"><button type="button" onclick="delete_property_item(` + number + `,` + nr + `,` + property + `,` + item + `)" class="btn btn-danger btn-small"><i class="fa fa-trash"></i></button></td>
            </tr>
            <div class="clearfix"></div>
        `;
        productToping.append(toping_html);
    }
}

function changeSingleProperty(number, nr, propertyNr,propertyItemNr, action, priceType){
    propertyItem = menuJson.items[number].products[nr].properties[propertyNr].options[propertyItemNr];
    if(action=="name"){
        var name = $('#'+number+'_'+nr+'_'+propertyNr+'_'+propertyItemNr+'_name').val();
        propertyItem.name = name;
        save_menu();
    }
    if(action=="price"){
        var price = $('#'+number+'_'+nr+'_'+propertyNr+'_'+propertyItemNr+'_price_'+priceType).val();
        if(propertyItem.prices[priceType]!=undefined) {
            propertyItem.prices[priceType].price = price;
        }else{
            propertyItem.prices[priceType] = {
                'price':price
            };
        }

        save_menu();
    }
    if(action=="order"){
        var order = $('#'+number+'_'+nr+'_'+propertyNr+'_'+propertyItemNr+'_order').val();
        propertyItem.order = order;
        save_menu();
    }
}
function delete_property_item(number, nr, property,item){
    $('#'+number+'_'+nr+'_product_'+property+'_item').remove();
    delete menuJson.items[number].products[nr].properties[property].options[item];
    save_menu();
}