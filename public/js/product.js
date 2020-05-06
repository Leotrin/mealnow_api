function addProduct(number){
    //var count = $('#' + number + '_categoryProduct .categoryProduct').length;
    var count = menuJson.items[number].products.length;
    // var myproducts = menuJson.items[number].products, myproductNr;
    // for (myproductNr in myproducts){ };
    // count = parseInt(myproductNr) +1;

    var nr = count + 1;
    var product = $('#' + number + '_product_name').val();
    var price_type = $('#' + number + '_product_custom_price').val();
    var price = $('#' + number + '_product_price').val();
    var productDescription = $('#' + number + '_product_description').val();
    if(products.indexOf(product)>-1) {
        alert('Already exist !');
    }else {
        if(product!='' && price!='' && price!=null){
            var product_to_push = product;
            products.push(product_to_push);
            $('#' + number + '_product_name').val(null);
            menuJson.items[number].products[nr] = {
                "name":product,
                "description":productDescription,
                "status":returnCheckboxTrueFalse('#' + number + '_status'),
                "isPizza":returnCheckboxTrueFalse('#' + number + '_isPizza'),
                "isSpecial":returnCheckboxTrueFalse('#' + number + '_isSpecial'),
                "availability":{
                        'monday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'tuesday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'wednesday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'thursday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'friday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'saturday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                        'sunday': {
                            'status': true,
                            'from_hour': '00:00',
                            'to_hour': '00:00'
                        },
                },
                "order":$('#' + number + '_order_nr').val(),
                "type":{0:{
                        "name":price_type,
                        "price":price
                    }},
                "topings":{
                    "name":"topings",
                    "min":0,
                    "max":10,
                    "order":1,
                    "options":{}
                },
                "properties":{}
            };
            save_menu();
            var order = $('#' + number + '_order_nr').val();
            $('#' + number + '_order_nr').val(parseInt(order)+1);
            $('#' + number + '_product_price').val('');
            $('#' + number + '_product_description').val('');
            regenerate_product(number, nr);
        }else{
            alert('Please fill the product name & price !');
        }
    }
}

function regenerate_product(number, nr){
    var category = '#' + number + '_categoryProduct';
    var product = menuJson.items[number].products[nr];
    if(product!=null) {
        var newProduct = `
            <div class="col-md-12 p0 categoryProduct" style="margin-top:5px;" id="` + number + `_` + nr + `_productBox">
                <div class="panel-group" id="` + number + `_` + nr + `_product_accordion" role="tablist" aria-multiselectable="true" style="margin:0;">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading` + number + `_` + nr + `_product_accordion">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" href="#collapse` + number + `_` + nr + `_product_accordion" aria-expanded="true" id="`+number+`_`+nr+`_product_show">                      
                            

                            `;
        if(product.isSpecial === true){
            newProduct = newProduct + '<strong>Special Product</strong> ';
        }
        newProduct = newProduct + product.name + `
                        </a>
                      </h4>
                    </div>
                    <div id="collapse` + number + `_` + nr + `_product_accordion" class="collapse hidden grid-body" role="tabpanel">
                      <div class="col-md-12 p5 text-right">
                        ` + generate_availability(number, nr)
                        + generate_property(number, nr)
                        + edit_product(number, nr) + `
                        <button type="button" class="btn btn-warning btn-small" onclick="clone_product(` + number + `,` + nr + `)">
                            <i class="fa fa-copy"></i> Clone
                        </button>
                        <button type="button" onclick="deleteProduct(` + number + `,` + nr + `)" class="btn btn-danger btn-small">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                    <div class="clearfix"></div>
                    `+ generate_type(number, nr) + `
                    <div class="clearfix"></div>
                    <div class="col-md-12 p5" id="` + number + `_` + nr + `_topings">` +
                    generate_topings(number, nr, product.isPizza)
                    + `</div>
                    <div class="col-md-12 p5" id="` + number + `_` + nr + `_property"></div>
                    </div>
                  </div>
                </div>                    
            </div>
            `;
        $(category).append(newProduct);
        toping_html(number,nr);
        generate_properties(number,nr,product.properties);

        $(".select_categories_product_move").empty();
        $.each(menuJson.items, function(i, item){
            if(item!=null) {
                $(".select_categories_product_move").append(new Option(item.category_name, i));
            }
        });
    }
}
function deleteProduct(number,nr){
    var product = menuJson.items[number].products[nr];
    const index = products.indexOf(product.name);
    products.splice(index, 1);
    $('#'+number+'_'+nr+'_productBox').remove();
    delete menuJson.items[number].products[nr];
    save_menu();
}