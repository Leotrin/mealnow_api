function add_category(parent) {
    var category_name = $('#category_name').val();
    var category_description = $('#category_description').val();
    var status_active = $('#status_active').val();
    var order_nr = $('#order_nr').val();
    if (category_name == null || category_name == '') {
        alert('No Category name is written !');
        return false;
    }

    if (categories != undefined && categories.indexOf(category_name) > -1) {
        alert('Already exist !');
    } else {
        nr = nr + 1;
        menuJson.items[nr] = {
            "category_name": category_name,
            "category_description": category_description,
            "status": statusForJson(status_active),
            "order": order_nr,
            "products": []
        };
        categories.push(category_name);
        save_menu();
        $('#'+nr+'_category_description_show').html(category_description);
        $('#category_name').val(null);
        var orderNr = $('#order_nr').val();
        $('#order_nr').val(parseInt(orderNr)+1);
        var elementIDs = $('#element_ids').val();
        if (elementIDs.indexOf(nr) <= -1) {
            $('#element_ids').val(elementIDs + nr + '|');
        }
        $('#element_count').val(nr);
        $('#category_description').val(null);
        item_html(parent,nr);
    }
}
function item_html(parent,nr){
        category = menuJson.items[nr];
        if(category!=null) {
            var nrOrder = parseInt(category.products.length);
            if (nrOrder == 0) {
                nrOrder = 1;
            }
            var newCategory = `

        <div class="panel-group" role="tablist" id="` + nr + `_category_to_delete"  aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="` + nr + `_categoryProductheadingOne">
              <h4 class="panel-title" id="` + nr + `_showCategoryName">
              
              <button type="button" class="btn btn-warning btn-small" data-toggle="expand" onclick="clone_category(` + nr + `)"><i class="fa fa-copy"></i></button> 
              <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#edit_` + nr + `"><i class="fa fa-edit"></i></button> 
              <button type="button" class="btn btn-danger btn-small" data-toggle="modal" data-target="#delete_category_modal_` + nr + `"><i class="fa fa-trash"></i></button> 

              <a role="button" data-toggle="collapse" href="#categoryProductcollapseOne` + nr + `" aria-expanded="true">
                  <span id="` + nr + `_showCategoryNameCurrent"><strong>` + category.category_name + `</strong> | ` + statusText(category.status) + ` - Order nr : #` + category.order + `</span>
              </a>
              </h4>
            <div class="modal fade" id="edit_` + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change</h4>
                  </div>
                  <div class="modal-body text-left">
                    <div class="col-md-8 p10">
                        <label>Category Name:</label>
                        <input type="text" id="` + nr + `_category_name" value="` + category.category_name + `" class="form-control" />
                    </div>
                    <div class="col-md-3 p10">
                        <label>Order nr:</label>
                        <input type="number" id="` + nr + `_order" value="` + category.order + `" step="1" min="1" class="form-control" />
                    </div>
                    <div class="col-md-1 p10">
                        <label>Active:</label>
                        <input type="checkbox" id="` + nr + `_category_active" ` + statusChecked(category.status) + ` class="bigCheckbox" />
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 p10">
                        <label>Category Description:</label>
                        <textarea id="` + nr + `_category_description" class="form-control">` + category.category_description + `</textarea>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveChanges(` + nr + `)">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="delete_category_modal_` + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                  </div>
                  <div class="modal-body text-center">
                    <h3>Are you sure ?</h3>
                    <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    <button type="button" class="btn btn-danger" onclick="deleteCategory(` + nr + `)" data-dismiss="modal">YES</button>
                  </div>
                </div>
              </div>
            </div>
              
            </div>
            <div  class="collapse hidden grid-body" id="categoryProductcollapseOne` + nr + `">
              <div class="panel-body" style="background: #fff;border:1px solid #ccc;">
                    <p id="` + nr + `_category_description_show">` + category.category_description + `</p>
                    <div class="col-md-12 p10" style="background: #fff;border:1px solid #ccc;" id="` + nr + `_categoryProduct">
                        <div class="col-md-6 p5">
                            <div class="col-md-12 p5">
                                <label id="">Product Name:</label>
                                <input type="text" id="` + nr + `_product_name" class="form-control"/>
                            </div>
                            <div class="col-md-12 p5">
                                <label id="">Product Description:</label>
                                <textarea rows="3" id="` + nr + `_product_description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 p5">
                            <div class="col-md-2 p5 text-center">
                                <label>Is Pizza: </label>
                                <input type="checkbox" id="` + nr + `_isPizza" class="bigCheckbox" value="1"/>
                            </div>
                            <div class="col-md-2 p5 text-center">
                                <label>Is Special: </label>
                                <input type="checkbox" id="` + nr + `_isSpecial" class="bigCheckbox" value="1"/>
                            </div>
                            <div class="col-md-2 p5 text-center">
                                <label>Active: </label>
                                <input type="checkbox" id="` + nr + `_status" class="bigCheckbox" value="1" checked/>
                            </div>
                            <div class="col-md-4 p5 pull-right text-right">
                                <button type="button" id="` + nr + `" onclick="addProduct(` + nr + `)" class="btn btn-info">
                                    <i class="fa fa-plus"></i> Add Product
                                </button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 p5 text-left">
                                <label>Custom Type: </label>
                                <input type="text" id="` + nr + `_product_custom_price" value="" class="form-control" />
                            </div>
                            <div class="col-md-4 p5 text-left">
                                <label>Price: </label>
                                <input type="number" id="` + nr + `_product_price" min="0" step="0.5" value="" class="form-control" />
                            </div>
                            <div class="col-md-3 p5 text-left">
                                <label>Order Nr.: </label>
                                <input type="number" id="` + nr + `_order_nr" min="1" step="1" value="` + nrOrder + `" class="form-control" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                  
                    </div>
                </div>
            </div>
          </div>
        `;
            $(parent).append(newCategory);
            $.each(category.products, function (i, item) {
                regenerate_product(nr, i);
            });
            $(".select_categories_product_move").empty();
            $.each(menuJson.items, function (i, item) {
                if (item != null) {
                    $(".select_categories_product_move").append(new Option(item.category_name, i));
                }
            });
        }
}
function saveChanges(number){
    var category_name   = $('#'+number+'_category_name').val();
    var category_description   = $('#'+number+'_category_description').val();
    var order_nr        = $('#'+number+'_order').val();
    if ($('#'+number+'_category_active').is(':checked')) {
        var status_active   = 1;
    }else{
        var status_active   = 0;// $('#'+number+'_category_active').val();
    }


    menuJson.items[number].category_name        = category_name;
    menuJson.items[number].category_description = category_description;
    menuJson.items[number].status               = statusForJson(status_active);
    menuJson.items[number].order                = order_nr;
    var html = `<strong>` + category_name + `</strong> | ` + statusText(status_active) +` - Order nr :#` + order_nr;

    const index = categories.indexOf(menuJson.items[number].category_name);
    categories.splice(index, 1);
    categories.push(category_name);
    $('#'+number+'_showCategoryNameCurrent').html(html);
    $('#'+number+'_edit').trigger('click.dismiss.bs.modal');
    $('#'+number+'_category_description_show').html(category_description);
    save_menu();
}
function deleteCategory(number){
    $('#delete_category_modal_'+number).on('hidden.bs.modal', function (e) {
        const index = categories.indexOf($('#'+number+'_category_name').val());
        categories.splice(index, 1);

        const categoriesString = $('#categoriesJson').val();
        categoriesString.replace(menuJson.items[number].category_name,'');
        $('#categoriesJson').val(categoriesString);

        $('#'+number+'_category_to_delete').remove();
        var elementIDs = $('#element_ids').val();
        elementIDs = elementIDs.replace( number + '|', "");
        $('#element_ids').val(elementIDs);
        delete menuJson.items[number];
        console.log(menuJson);
        save_menu();
    });
}
function statusChecked(status){
    if(status==true){
        return ' checked ';
    }else{
        return '';
    }
}
function statusText(status){
    if(status==true){
        return 'Active';
    }else{
        return 'Inactive';
    }
}
function statusForJson(status){
    if(status==1){
        return true;
    }else{
        return false;
    }
}
function returnCheckboxTrueFalse(id){
    if ($(id+':checkbox:checked').length > 0){
        return true;
    }
    return false;
}
function replaceVar(myVar){
    return  myVar.replace(/ /g,"_");
}
function save_menu(){
    $('#menuJson').val(JSON.stringify(menuJson));
    var categories = [];
    var myProds = [];
    $.each(menuJson.items, function(i, item) {
        if(item!=null) {
            categories.push(item.category_name);
            $.map(item.products, function (i2, item2) {
                if (i2 != null) {
                    myProds.push(i2.name);
                }
            });
        }
    });

    $('#categoriesJson').val(categories.toString());
    $('#productsJson').val(myProds.toString());
    $('#saveMenuButton').removeClass('hideElements');
    console.log(menuJson);
}