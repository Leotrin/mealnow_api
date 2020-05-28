function generate_type(number, nr){
    var myReturn = `

          <div class="col-md-12 text-left" style="padding:10px;border:1px solid #ccc;"><strong>Types</strong><br />`;
    myReturn = myReturn + types(number,nr);
    myReturn = myReturn + `<div class="col-md-12 p0" id="`+number+`_`+nr+`_custom_types">`+generate_custom_types(number,nr)+`</div>

            <div class="col-md-6 p5">
                <p>Add Custom type</p>
                <div class="col-md-5 p5">
                <input type="text" id="`+number+`_`+nr+`_custom_name" placeholder="Custom Type title" class="form-control" />
                </div>
                <div class="col-md-5 p5">
                <input type="text" id="`+number+`_`+nr+`_custom_type_price" placeholder="Price $" class="form-control" />
                </div>
                <div class="col-md-2 p5">
                <button type="button" onclick="add_custom_type(`+number+`,`+nr+`);" class="form-control btn btn-info"><i class="fa fa-plus"></i></button>
                </div>
            </div>
          <div class="clearfix"></div>
          </div>
       `;
    return myReturn;
}
function types(number, nr){

    myReturn = ``;
    $.map( menuJson.items[number].products[nr].type, function( type, i ) {
        i = parseInt(i);
        if(type!=null) {
            console.log(i + '  ------  '+type.name);
            myReturn = myReturn + `
                <div class="col-md-6 p5" style="background:#efefef;border:1px solid #fff;" id="` + number + `_` + nr + `_` + i + `">
                    <div class="col-md-5 p5">
                        <input type="text" class="form-control" value="` + type.name + `" id="` + number + `_` + nr + `_` + i + `_type_price_name" onkeyup="update_type_name(` + number + `,` + nr + `,` + i + `)"  />
                    </div>
                    <div class="col-md-5 p5">
                        <input type="text" id="` + number + `_` + nr + `_` + i + `_type_price" value="` + type.price + `" onkeyup="update_type_price(` + number + `,` + nr + `,` + i + `)"  class="form-control" />
                    </div>
                    <div class="col-md-2 p5">
                        <button type="button" class="form-control btn btn-danger" onclick="delete_type(` + number + `,` + nr + `,` + i + `)"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                    <div class="clearfix"></div>
            `;
        }
    });
    return myReturn;
}
function saveTypes(number, nr){

    // $.map( menuJson.items[number].products[nr].type, function( n, i ) {
    //     var price = $('#'+number+'_'+nr+'_'+i+'_type_price').val();
    //     menuJson.items[number].products[nr].type[String(i)] = price;
    //
    // });
    $('#'+number+'_'+nr+"_topings").empty();
    $('#'+number+'_'+nr+"_topings").html(generate_topings(number, nr,menuJson.items[number].products[nr].isPizza));

    toping_html(number,nr);
    $('#'+number+'_'+nr+"_property").empty();
    $('#'+number+'_'+nr+"_property").html(generate_properties(number, nr,menuJson.items[number].products[nr].properties));

    save_menu();
    $('#'+number+'_'+nr+'_product_type').trigger('click.dismiss.bs.modal')
}
function update_type_price(number,nr,typeNr){
    var price =$('#'+number+'_'+nr+'_'+typeNr+'_type_price').val();
    if(price!=null && price!=""){
        menuJson.items[number].products[nr].type[typeNr].price = price;
        save_menu();
    }
}
function update_type_name(number,nr,typeNr){
    var price_type =$('#'+number+'_'+nr+'_'+typeNr+'_type_price_name').val();
    if(price_type!=null && price_type!=""){
        menuJson.items[number].products[nr].type[typeNr].name = price_type;
        save_menu();
    }
}
function add_custom_type(number,nr){
    var mytype =$('#'+number+'_'+nr+'_custom_name').val();
    var price =$('#'+number+'_'+nr+'_custom_type_price').val();
    if(mytype!='' && price!=''){
        var types = menuJson.items[number].products[nr].type, typeNr;
        for (typeNr in types){ };
        typeNr = parseInt(typeNr) +1;
        // var typeNr = menuJson.items[number].products[nr].type.length;
        // console.log(typeNr);
        //
        // typeNr = parseInt(typeNr) +1;
        console.log(typeNr);
        menuJson.items[number].products[nr].type[typeNr] = {
            "name": mytype,
            "price":price
        };
        save_menu();
        generate_custom_type(number,nr,typeNr);
    }else{
        alert('Please write type and price !');
    }
    saveTypes(number,nr);
    $('#'+number+'_'+nr+'_custom_type_price').val('');
    $('#'+number+'_'+nr+'_custom_name').val('');
}
function generate_custom_types(number,nr){
    var type = menuJson.items[number].products[nr].type;
    $.each(type, function(i, item) {
        generate_custom_type(number,nr,parseInt(i));
    });
    return '';
}
function generate_custom_type(number,nr,typeNr){
    var type = menuJson.items[number].products[nr].type[typeNr];
    if(type!=null) {
        var custom_type = `
        <div class="col-md-6 p5" style="background:#efefef;border:1px solid #fff;" id="` + number + `_` + nr + `_` + typeNr + `">
            <div class="col-md-5 p5">
                <input type="text" class="form-control" value="` + type.name + `" onkeyup="update_type_name(` + number + `,` + nr + `,` + typeNr + `)"   />
            </div>
            <div class="col-md-5 p5">
                <input type="text" id="` + number + `_` + nr + `_` + typeNr + `_type_price" value="` + type.price + `" onkeyup="update_type_price(` + number + `,` + nr + `,` + typeNr + `)" class="form-control" />
            </div>
            <div class="col-md-2 p5">
                <button type="button" class="form-control btn btn-danger" onclick="delete_type(` + number + `,` + nr + `,` + typeNr + `)"><i class="fa fa-trash"></i></button>
            </div>
            <div class="clearfix"></div>
        </div>
            <div class="clearfix"></div>
    `;
        $('#' + number + '_' + nr + '_custom_types').append(custom_type);
    }
}
function delete_type(number,nr,typeNr){
    if(typeNr!=0) {
        $('#'+number+'_'+nr+'_'+typeNr).remove();
        delete menuJson.items[number].products[nr].type[typeNr];
        save_menu();
        saveTypes(number,nr);
    }else{
        swal('Base price can not be deleted !');
    }
}
