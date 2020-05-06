function clone_product(number,nr){
    //var count = $('#' + number + '_categoryProduct .categoryProduct').length;
    var count = menuJson.items[number].products.length;
    var newNr = parseInt(count) + 1;
    console.log(nr + '_'+newNr);
    var product = menuJson.items[number].products[nr];
    menuJson.items[number].products[newNr] ={
        "name":product.name,
        "description":product.description,
        "status":product.status,
        "isPizza":product.isPizza,
        "availability":product.availability,
        "order":product.order,
        "type":product.type,
        "topings":product.topings,
        "properties":product.properties
    };
    menuJson.items[number].products[newNr].name =  menuJson.items[number].products[newNr].name+'_cloned';
    menuJson.items[number].products[newNr].order =  menuJson.items[number].products[newNr].order = parseInt(menuJson.items[number].products[newNr].order)+1;
    products.push(number+'_'+menuJson.items[number].products[newNr].name+'_cloned');
    console.log(menuJson.items[number].products[nr]);
    console.log(menuJson.items[number].products[newNr]);
    product = null;
    save_menu();
    regenerate_product(number, newNr);
}
function clone_category(number){
    //var count = $('#' + number + '_categoryProduct .categoryProduct').length;
    var count = menuJson.items.length;
    var newNr = parseInt(count) + 1;
    console.log(number + '_'+newNr);
    var category = menuJson.items[number];
    console.log(category);
    menuJson.items[newNr] ={

        "category_name": category.category_name,
        "category_description": category.category_description,
        "status": category.status,
        "order": category.order,
        "products": category.products
    };
    menuJson.items[newNr].category_name =  menuJson.items[newNr].category_name+'_cloned';
    menuJson.items[newNr].order =  menuJson.items[newNr].order = parseInt(menuJson.items[newNr].order)+1;
    categories.push(newNr+'_'+menuJson.items[newNr].category_name+'_cloned');
    console.log(menuJson.items[number]);
    console.log(menuJson.items[newNr]);
    save_menu();
    item_html('#menuItems',newNr);
}