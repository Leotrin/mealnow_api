function generate_topings(number,nr,isPizza){
    var toping = menuJson.items[number].products[nr].topings;
    if(isPizza===true){

        var myReturn = `
            <div class="col-md-12 p5" style="border:1px solid #ccc;background: #fff;">
            
                <div class="panel-group" id="` + number + `_` + nr + `_product_topings_" role="tablist" aria-multiselectable="true" style="margin:0;">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading` + number + `_` + nr + `_product_topings_" style="background: #f35958;">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse` + number + `_` + nr + `_product_topings_" aria-expanded="true" style="color:#fff !important;">
                            <i class="fa fa-list-alt"></i> `+toping.name+`
                        </a>
                      </h4>
                    </div>
                    <div id="collapse` + number + `_` + nr + `_product_topings_" class="collapse hidden grid-body" role="tabpanel" style="padding-top:5px;">

                        <div class="col-md-2 pull-right">
                        <button type="button" data-toggle="modal" data-target="#product_topings_settings_` + number + `_`  + nr + `" class="pull-right btn btn-success btn-small">
                            <i class="fa fa-cogs"></i>
                        </button>
                        </div>
                        <div class="col-md-7">
                            <label>Toping Name</label>
                            <input type="text" id="` + number + `_`  + nr + `_toping_name" class="form-control" />`;
                                myReturn = myReturn + type_prices_toping(number, nr);
                                myReturn = myReturn+`</div>
                        <div class="col-md-2">
                            <label>Toping Order</label>
                            <input type="text" id="` + number + `_`  + nr + `_toping_order" value="1" step="1" min="1" class="form-control" />
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" onclick="save_toping(`+number+`,`+nr+`)" class="btn btn-primary">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="panel-group" id="` + number + `_`  + nr + `_product_topings" role="tablist" aria-multiselectable="true" style="margin-top:5px;">
                          <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading` + number + `_`  + nr + `_product_topings">
                              <h4 class="panel-title"><a role="button" data-toggle="collapse"  href="#collapse` + number + `_`  + nr + `_product_topings" aria-expanded="true">`+toping.name+`</a></h4>
                            </div>
                            <div id="collapse` + number + `_`  + nr + `_product_topings" class="collapse hidden grid-body" role="tabpanel" >
                              <div class="panel-body"style="background: #efefef;">
                                <div class="grid-body" style="padding:0px;">
                                <table class="table table-striped table-hover" id="example1">
                                    <thead>
                                        <tr>
                                            <td>Name</td>`;
                                            $.map( menuJson.items[number].products[nr].type, function( n, i ) {
                                                if(n!=null){
                                                    myReturn = myReturn+`<td>`+n.name+`</td>`;
                                                }
                                            });
                                            myReturn = myReturn+`<td>Order Nr.</td><td></td>
                                        </tr>  
                                    </thead>
                                    <tbody id="` + number + `_`  + nr + `_product_topings_list" ></tbody>
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
            
                    <div class="modal fade" id="product_topings_settings_` + number + `_`  + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Product Topings Settings</h4>
                  </div>
                  <div class="modal-body text-left">
                    <div class="col-md-4">
                        <label>Title</label>
                        <input type="text" id="` + number + `_` +nr+`_topings_name" value="`+toping.name+`" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label>Minimum Selection</label>
                        <input type="number" id="` + number + `_` +nr+`_topings_min" value="`+toping.min+`" min="0" step="1" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label>Maximum Selection</label>
                        <input type="number" id="` + number + `_` +nr+`_topings_max" value="`+toping.max+`" min="0" step="1" class="form-control" />
                    </div>
                    <div class="col-md-2">
                        <label>Order</label>
                        <input type="number" id="` + number + `_` +nr+`_topings_order" value="`+toping.order+`" min="1" step="1" class="form-control" />
                    </div>
                  <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_topings_setting(`+number+`,` + nr + `)">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
        `;
        return myReturn;
    }
    return '';
}
function type_prices_toping(number, nr){
    myReturn = ``;
    $.map( menuJson.items[number].products[nr].type, function( n, i ) {
        if(n!=null) {
            myReturn = myReturn + `
            <div class="col-md-6">
                <label>` + n.name + ` Half Price</label>
                <input type="number" id="` + i + `_` + number + `_` + nr + `_half_price" value="1" step=".01" class="form-control"/>
            </div>
            <div class="col-md-6">
                <label>` + n.name + `  Whole Half Price </label>
                <input type="number" id="` + i + `_` + number + `_` + nr + `_whole_price" value="1.5" step=".01" class="form-control"/>
            </div>
            <div class="clearfix"></div>`;
        }
    });

    return myReturn;
}
function save_topings_setting(number,nr){
    var name    = $('#'+number+'_'+nr+'_topings_name').val();
    var min     = $('#'+number+'_'+nr+'_topings_min').val();
    var max     = $('#'+number+'_'+nr+'_topings_max').val();
    var order   = $('#'+number+'_'+nr+'_topings_order').val();
    var toping = menuJson.items[number].products[nr].topings;
    menuJson.items[number].products[nr].topings = {
        "name":name,
        "min":min,
        "max":max,
        "order":order,
        "options":toping.options
    };
    save_menu();
    $('#product_topings_settings_'+number+'_'+nr).trigger('click.dismiss.bs.modal');
}
function save_toping(number, nr){
    var name        = $('#'+number+'_'+nr+'_toping_name').val();
    var order_nr    = $('#'+number+'_'+nr+'_toping_order').val();
    if(name!=null && name!="" && order_nr!=null && order_nr!="") {

        var topings = menuJson.items[number].products[nr].topings.options, topingNr;
        for (topingNr in topings){ };
        if(topingNr==null){
            topingNr = 1;
        }else{
            topingNr = parseInt(topingNr) +1;
        }
        menuJson.items[number].products[nr].topings.options[topingNr] = {
            'order':order_nr,
            'name': name,
            'prices': {}
        };

        $.map(menuJson.items[number].products[nr].type, function (n, i) {
            if(n!=null) {
                var halfPrice = $('#' + i + '_' + number + '_' + nr + '_half_price').val();
                var wholePrice = $('#' + i + '_' + number + '_' + nr + '_whole_price').val();
                if (menuJson.items[number].products[nr].topings.options[topingNr] != null) {
                    menuJson.items[number].products[nr].topings.options[topingNr].prices[i] = {
                        'half_price': halfPrice,
                        'whole_price': wholePrice
                    };
                }
            }
        });

        save_menu();
        toping_html(number, nr, topingNr);
        alert('Success');
    }else{
        alert('Please Enter Toping name!');
    }
}
function toping_html(number,nr,topingNr=null){
    if(topingNr !=null) {
        toping = menuJson.items[number].products[nr].topings.options[topingNr];
        var productToping = $('#' + number + '_' + nr + '_product_topings_list');
        var toping_html = `
            <tr id="` + number + `_` + nr + `_toping_`+topingNr+`_item">
                <td style="max-width:50%;word-break:break-all;"><input type="text" id="toping_name_`+number+`_`+nr+`_`+topingNr+`" value="` + toping.name + `" class="form-control" onkeyup="changeSingleToping(`+number+`,`+nr+`,`+topingNr+`, 'name',0)" /></td>`;

        $.map( menuJson.items[number].products[nr].type, function( n, i ) {
            if(n!=null) {
                var myvariable = toping.prices[i];
                if (myvariable != null) {
                    toping_html = toping_html + `<td>
                <input type="number" id="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="` + toping.prices[i].half_price + `" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'half', ` + i + `)"/>
                <input type="number" id="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="` + toping.prices[i].whole_price + `" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'whole', ` + i + `)"/>
                </td>`;
                } else {
                    toping_html = toping_html + `<td>
                <input type="number" id="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="0" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'half', ` + i + `)"/>
                <input type="number" id="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="0" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'whole', ` + i + `)"/>
                </td>`;
                }
            }
        });
        toping_html= toping_html+`
                <td style="max-width:10%;word-break:break-all;"><input type="number" id="toping_order_`+number+`_`+nr+`_`+topingNr+`" value="` + toping.order + `" onkeyup="changeSingleToping(`+number+`,`+nr+`,`+topingNr+`, 'order',0)"/></td>
                <td class="text-right"><button type="button" onclick="delete_toping(` + number + `,` + nr + `,` + topingNr + `)" class="btn btn-danger btn-small"><i class="fa fa-trash"></i></button></td>
            </tr>
            <div class="clearfix"></div>
        `;
        productToping.append(toping_html);
    }else{
        topings = menuJson.items[number].products[nr].topings;
        if(topings.options!={}) {
            $.each(topings.options, function (topingNr, toping) {
                if (toping != null) {
                    var productToping = $('#' + number + '_' + nr + '_product_topings_list');
                    var toping_html = `
                        <tr id="` + number + `_` + nr + `_toping_` + topingNr + `_item">
                            <td style="max-width:50%;word-break:break-all;"><input type="text" id="toping_name_` + number + `_` + nr + `_` + topingNr + `" value="` + toping.name + `" class="form-control" onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'name',0)" /></td>`;

                    $.map(menuJson.items[number].products[nr].type, function (n, i) {
                        if(n!=null) {
                            var myvariable = toping.prices[i];
                            if (myvariable != null) {
                                toping_html = toping_html + `<td>
                            <input type="number" id="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="` + toping.prices[i].half_price + `" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'half', ` + i + `)"/>
                            <input type="number" id="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="` + toping.prices[i].whole_price + `" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'whole', ` + i + `)"/>
                            </td>`;
                            } else {
                                toping_html = toping_html + `<td>
                            <input type="number" id="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_half_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="0" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'half', ` + i + `)"/>
                            <input type="number" id="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" name="toping_whole_price_` + number + `_` + nr + `_` + topingNr + `_` + i + `" min="0" step="0.01" value="0" style="width:100px;"  onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'whole', ` + i + `)"/>
                            </td>`;
                            }
                        }
                    });
                    toping_html = toping_html + `
                            <td style="max-width:10%;word-break:break-all;"><input type="number" id="toping_order_` + number + `_` + nr + `_` + topingNr + `" value="` + toping.order + `" onkeyup="changeSingleToping(` + number + `,` + nr + `,` + topingNr + `, 'order',0)"/></td>
                            <td class="text-right"><button type="button" onclick="delete_toping(` + number + `,` + nr + `,` + topingNr + `)" class="btn btn-danger btn-small"><i class="fa fa-trash"></i></button></td>
                        </tr>
                        <div class="clearfix"></div>
                    `;
                    productToping.append(toping_html);
                }
            });
        }
    }
}
function changeSingleToping(number, nr, topingNr, action, priceType){
    toping = menuJson.items[number].products[nr].topings.options[topingNr];
    if(action=="name"){
        var name = $('#toping_name_'+number+'_'+nr+'_'+topingNr).val();
        toping.name = name;
        save_menu();
    }
    var prices = toping.prices[priceType];
    var halfprice, wholeprice;
    if(prices!=null){
        halfprice = toping.prices[priceType].half_price;
        wholeprice = toping.prices[priceType].whole_price;
    }else{
        halfprice = null;
        wholeprice = null;
    }
    if(halfprice!=null && wholeprice!=null){
        if(action=="half"){
            var half_price = $('#toping_half_price_'+number+'_'+nr+'_'+topingNr+'_'+priceType).val();
            toping.prices[priceType].half_price = half_price;
            save_menu();
        }
        if(action=="whole"){
            var whole_price = $('#toping_whole_price_'+number+'_'+nr+'_'+topingNr+'_'+priceType).val();
            toping.prices[priceType].whole_price = whole_price;
            save_menu();
        }
    }else{

            var half_price = $('#toping_half_price_'+number+'_'+nr+'_'+topingNr+'_'+priceType).val();
            var whole_price = $('#toping_whole_price_'+number+'_'+nr+'_'+topingNr+'_'+priceType).val();
            toping.prices[priceType] = {
                "half_price": half_price,
                "whole_price": whole_price
            };
            save_menu();

    }
    if(action=="order"){
        var order = $('#toping_order_'+number+'_'+nr+'_'+topingNr).val();
        toping.order = order;
        save_menu();
    }
}
function delete_toping(number, nr, toping){
    $('#'+number+'_'+nr+'_toping_'+toping+'_item').remove();
    delete menuJson.items[number].products[nr].topings.options[toping];
    save_menu();
}