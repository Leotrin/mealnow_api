function edit_product(number,nr){
    var product = menuJson.items[number].products[nr];
    return `
        <button type="button" data-toggle="modal" data-target="#product_`+number+'_' + nr + `" class="btn btn-success btn-small">
            <i class="fas fa-edit"></i> Edit
        </button>
        <div class="modal fade" id="product_`+number+'_' + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Product Edit</h4>
              </div>
              <div class="modal-body text-left">
                    <div class="col-md-7 p5">
                        <label id="">Product Name:</label>
                        <input type="text" id="`+number+'_'+nr+`_product_name" value="`+product.name+`"  class="form-control"/>
                        <br />
                        <label id="">Product Description:</label>
                        <textarea id="`+number+`_`+nr+`_product_description" class="form-control" style="min-width:100%;max-width:100%;max-height:120px;min-height:120px;">`+product.description+`</textarea>
                    </div>
                    <div class="col-md-5 p0">
                        <div class="col-md-6 p5 text-center">
                            <label>Is Pizza : </label>
                            <input type="checkbox" id="`+number+`_`+nr+`_isPizza" class="bigCheckbox" value="1" `+statusChecked(product.isPizza)+`/>
                        </div>
                        <div class="col-md-6 p5 text-center">
                            <label>Active : </label>
                            <input type="checkbox" id="`+number+`_`+nr+`_status" class="bigCheckbox" value="1"  `+statusChecked(product.status)+`/>
                        </div>
                        <div class="col-md-12 p5 text-center" style="padding-top:18px;">
                            <label>Order Nr. : </label>
                            <input type="number" id="`+number+`_`+nr+`_order_nr" min="1" step="1" value="`+product.order+`" class="form-control" />
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 p5 text-center" style="padding-top:18px;">
                            <label>Price : </label>
                            <input type="number" id="`+number+`_`+nr+`_price" min="0" step="0.5" value="`+product.price+`" class="form-control" />
                        </div>
                    </div>
                    <div class="clearfix"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="save_product(`+number+`,`+ nr +`)" class="btn btn-info" data-dismiss="modal">
                    <i class="fa fa-save"></i> Save
                </button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" data-toggle="modal" data-target="#product_move_`+number+`_` + nr + `" class="btn btn-success btn-small">
           <i class="fas fa-retweet"></i> Move
        </button>
        <div class="modal fade" id="product_move_`+number+`_` + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Move Product `+product.name+`</h4>
              </div>
              <div class="modal-body text-left">
                    <div class="col-md-7 p5">
                        <label id="">Select Category to move</label>
                        <select id="product_move_category_`+number+`_` + nr + `" class="form-control select_categories_product_move">
                            <option value="">Select category</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="move_product(`+number+`,`+ nr +`)" class="btn btn-info" data-dismiss="modal">
                    <i class="fa fa-save"></i> Save
                </button>
              </div>
            </div>
          </div>
        </div>


`;
}
function save_product(number,nr){
    var product_name = $('#'+number+'_'+nr+'_product_name').val();
    var product_escription = $('#'+number+'_'+nr+'_product_description').val();
    var price = $('#'+number+'_'+nr+'_price').val();
    var product = menuJson.items[number].products[nr];

    const index = products.indexOf(number+'_'+product.name);
    products.splice(index, 1);

    if(products.indexOf(number+'_'+product_name)>-1) {
        alert('Already exist !');
    }else {
        if(product_name!='') {

            $('#'+number + '_' + nr + '_product').on('hidden.bs.modal', function (e) {
                var product_to_push = number + '_' + product;
                products.push(product_to_push);

                menuJson.items[number].products[nr] = {
                    "name": product_name,
                    "description": product_escription,
                    "status": returnCheckboxTrueFalse('#' + number + '_' + nr + '_status'),
                    "isPizza": returnCheckboxTrueFalse('#' + number + '_' + nr + '_isPizza'),
                    "availability": product.availability,
                    "order": $('#' + number + '_' + nr + '_order_nr').val(),
                    "price":price,
                    "type": product.type,
                    "topings": product.topings,
                    "properties": product.properties
                };
                save_menu();
                $('#' + number + '_' + nr + '_product_show').text(menuJson.items[number].products[nr].name);
                $('#' + number + '_' + nr + '_product_nane').val(null);
                $('#' + number + '_' + nr + '_productBox').remove();
                regenerate_product(number, nr);
            });
        }else{
            alert('Please fill the product name !');
        }
    }
}
function move_product(number, nr){
    $('#product_move_'+number+'_' + nr).on('hidden.bs.modal', function () {

        var product = menuJson.items[number].products[nr];
        const index = products.indexOf(product.name);
        products.splice(index, 1);
        delete menuJson.items[number].products[nr];

        var categoryIdToMove = $('#_product_move_category_'+number+'_'+nr).val();
        var productsNr = menuJson.items[categoryIdToMove].products, propertyItemNr;
        for (propertyItemNr in productsNr){ };
        if(propertyItemNr==null){
            propertyItemNr = 1;
        }else{
            propertyItemNr = parseInt(propertyItemNr) +1;
        }
        menuJson.items[categoryIdToMove].products[propertyItemNr] = product;

        regenerate_product(categoryIdToMove, propertyItemNr);

        $('#'+number+'_'+nr+'_productBox').remove();
        save_menu();
    });
}