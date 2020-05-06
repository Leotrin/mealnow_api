var newProduct = {
    'name':null,
    'option':null,
    'items':[],
    'qty':1,
    'special':null
};
function reloadProduct(category, product, productType, price){
    newProduct = {
        'name':product,
        'option':{
            'type':productType,
            'price':parseFloat(price)
        },
        'items':[],
        'qty':1,
        'special':null
    };
    $('input#category_'+category+'_product_'+product+'_qty').val(1);
    $('input[name="category_'+category+'_product_'+product+'_type"]:first').prop('checked', true);
    clearPopUp();
    updaterPrice();
}
function minus(categoryKey, product){
    newProduct.name = product;
    var qty = $('input#category_'+categoryKey+'_product_'+product+'_qty').val();
    if(qty<=1){
        // swal({
        //     type:'error',
        //     title:'Minimum allowed quantity is 1 !',
        // });
        alert("Minimum allowed quantity is 1 !");
    }else{
        qty = parseInt(qty)-1;
        $('input#category_'+categoryKey+'_product_'+product+'_qty').val(qty);
        newProduct.qty = qty;
        updaterPrice();
    }
}
function plus(categoryKey, product){
    newProduct.name = product;
    var qty = $('input#category_'+categoryKey+'_product_'+product+'_qty').val();
    qty = parseInt(qty)+1;
    $('input#category_'+categoryKey+'_product_'+product+'_qty').val(qty);
    newProduct.qty = qty;
    updaterPrice();
}
function changeOption(product,option,value){
    newProduct.name = product;
    newProduct.option = {
        'type':option,
        'price':parseFloat(value)
    };
    newProduct.items=[];
    clearPopUp();
    updaterPrice();
}
function clearPopUp(){
    $('.mealNowNotMultiple_price').empty();
    $('.mealNowTopping').prop('checked',false);
    $('.mealNowTopping_price').empty();
    $('.mealNowMultiple').prop('checked',false);
    $('.mealNowMultiple_price').empty();
}
function addTopingToCart(product,toping,value,categoryKey, topingKey){
    var type = $("input[name='category_"+categoryKey+"_product_"+product+"_type']:checked").val();
    if(value==3){
        var price = menuJson[categoryKey].products[product].topings.options[topingKey].prices[type].whole_price;
    }else if(value==2 || value==1){
        var price = menuJson[categoryKey].products[product].topings.options[topingKey].prices[type].half_price;
    }
    var found = false;
    $.each(newProduct.items, function(i, item){
        try {
            if ((typeof item.name) && item.name == toping && item.group == 'topings') {
                try {
                    if (item.value == value) {
                        $('input[type="radio"].category_' + categoryKey + '_product_' + product + '_toping_' + topingKey).prop('checked', false);
                        found = true;
                    }
                    $('p#category_' + categoryKey + '_product_' + product + '_pizzaShow_' + topingKey).html(toping);
                    newProduct.items.splice(i, 1);
                }
                catch (err) {
                    //swal(err.message);
                }
            }
        }catch (err){}
    });
    if(found===false){
        if(this.checkSelectedTopingsLimit(menuJson[categoryKey].products[product].topings.min,
                                          menuJson[categoryKey].products[product].topings.max,
                                          topingKey)){
            $('input[type="radio"].category_' + categoryKey + '_product_' + product + '_toping_' + topingKey).prop('checked', false);
            return false;
        }

        var size = '1half';
        if(value == 2){
            size = '2half';
        }
        if(value == 3){
            size = 'whole';
        }
        newProduct.name = product;
        newProduct.items.push(
            {
                'group'     :'topings',
                'topingKey' :topingKey,
                'name'      :toping,
                'value'     :value,
                'size'      :size,
                'price'     :price
            }
        );
        $('p#category_'+categoryKey+'_product_'+product+'_pizzaShow_'+topingKey).html(toping + ' <strong class="mealNowTopping_price">£'+price+'</span>');
    }
    updaterPrice();
}
function addExtraMultiple(product, extra,propertyKey,categoryKey, extraKey){
    var myType = $("input[name='category_"+categoryKey+"_product_"+product+"_type']:checked").val();

    var price =menuJson[categoryKey].products[product].properties[propertyKey].options[extraKey].prices[myType].price;
    //console.log(price);

    var found = false;
    $.each(newProduct.items, function(i, item){
        try {
            if((typeof newProduct.items[i].name !== 'undefined') && item.name == extra && item.group == propertyKey){
                newProduct.items.splice(i, 1);
                found = true;
            }
        }
        catch(err) {
            //swal(err.message);
        }
    });
    if(found===false){
        if(this.checkSelectedLimit(menuJson[categoryKey].products[product].properties[propertyKey].min, menuJson[categoryKey].products[product].properties[propertyKey].max, propertyKey)){
            var namexx = 'input[name=category_'+categoryKey+'_product_'+product+'_extra_'+propertyKey+'_'+extraKey+']:checkbox';

            $(namexx).prop('checked',false);
            return false;
        }
        newProduct.name = product;

        newProduct.items.push(
            {
                'group' :propertyKey,
                'name'  :extra,
                'price' :price
            }
        );
        $('#category_'+categoryKey+'_product_'+product+'_extra_'+propertyKey+'_'+extraKey).html(price+' &pound;');

    }else{
        $('#category_'+categoryKey+'_product_'+product+'_extra_'+propertyKey+'_'+extraKey).empty();
    }
    updaterPrice();
}
function checkSelectedLimit(min, max, key) {
    //console.log(min+" "+max);
    console.log(newProduct);
    var numOccurences = $.grep(newProduct.items, function (elem) {
        return elem['group'] === key;
    }).length; // Returns 2
    console.log('appearing '+numOccurences);
    if(numOccurences<max){
        return false;
    }else{
        //uncheck item by code
        // swal('You can select maximum '+max +'items');
        alert('You can select maximum '+max +'items')
        return true;
    }
}
function checkSelectedTopingsLimit(min, max, key) {

    console.log(min+" "+max);
    console.log(newProduct);
    var numOccurences = $.grep(newProduct.items, function (elem) {
        return elem['group'] === 'topings';
    }).length; // Returns 2
    console.log('appearing '+numOccurences);
    if(numOccurences<max){
        return false;
    }else{
        //uncheck item by code
        // swal('You can select maximum '+max +'items');
        alert('You can select maximum '+max +'items')
        return true;
    }
}
function addExtraNotMultiple(product, extra,propertyKey,categoryKey, extraKey){

    var myType = $("input[name='category_"+categoryKey+"_product_"+product+"_type']:checked").val();
    var price = menuJson[categoryKey].products[product].properties[propertyKey].options[extraKey].prices[myType].price;


    var found = false;
    $.each(newProduct.items, function(i, item){
        try {
            if(item.group == propertyKey){
                item.name   = extra;
                item.price  = price;
                found       = true;
            }
        }
        catch(err) {
            //swal(err.message);
        }
    });
    if(found===false){
        newProduct.name = product;
        newProduct.items.push(
            {
                'group' : propertyKey,
                'name'  : extra,
                'price' : price
            }
        );
    }

    $('.mealNowNotMultiple_price').empty();

    $('#category_'+categoryKey+'_product_'+product+'_extra_'+propertyKey+'_'+extraKey+'_notMultiple').html(price+' &pound;');
    updaterPrice();
}
function updaterPrice(){
    var total = parseFloat(0.00);
    $.each(newProduct.items, function(i, item) {
        total = total + parseFloat(item.price);
    });
    total = total + parseFloat(newProduct.option.price);
    total = total * newProduct.qty;
    var product = JSON.stringify(newProduct);
    $('input#product_'+newProduct.name).val(product);
    var printTotal = total.toFixed(2).toString()+' £';
    $('h4#total_'+newProduct.name).html(printTotal);
}
function replaceVar(variable){
    return  variable.replace(/ /g,"_");
}
function add_to_cart(productKey, categoryKey){
    showLoading();
    var checkLimit = this.checkMinimumSelectedOptions(productKey, categoryKey);
    console.log(checkLimit);
    if(checkLimit<=0){
        hideLoading();
        return;
     }
    var specialInstruction = $('#category_'+categoryKey+'_product_'+productKey+'_special_requests').val();
    newProduct.special = specialInstruction;
    newProduct.category = categoryKey;
    var product = JSON.stringify(newProduct);
    $('input#productJson'+productKey).val(product);
    var data = {
        'product':product
    };
    $.post(baseUrl+'/addToCart', data)
        .done(function(response) {
            if(response.error != null){
                console.log(response.error);
                if(response.values != null){
                    // swal({
                    //     title: response.error,
                    //     type: 'error',
                    //     html:'<span style="font-size:11pt;">Minumum:<b> ' + response.values.min + '</b><br />Maximum:<b> ' + response.values.max+'</b></span>',
                    //     showCloseButton: false,
                    //     showCancelButton: false,
                    //     focusConfirm: false
                    // });
                    alert('<span style="font-size:11pt;">Minumum:<b> ' + response.values.min + '</b><br />Maximum:<b> ' + response.values.max+'</b></span>')
                }else{
                    // swal({
                    //     title: response.error,
                    //     type: 'error',
                    //     showCloseButton: false,
                    //     showCancelButton: false,
                    //     focusConfirm: false
                    // });
                    alert(response.error);
                    document.getElementById(newProduct.name).reset();
                    $(".modal .close").click();
                }
                hideLoading();
                return '';
            }
            if(response.status == true) {
                var products = `<table style="width:100%;" class="table table-striped">`;
                $.each(response.values.products, function (i, product) {
                    products += `
                        <tr id="` + product.name + `">
                            <td style="width:5%;">
                                <span class="deleteIcon"><i onclick="deleteItemFromCart(`+i+`)" class="fa fa-trash "></i></span>
                            </td>
                            <td style="width:70%;">
                                ` + product.name + `<br />
                                <small>` + product.description + `</small>
                            </td>
                            <td style="width:25%;text-align:right;">
                                <strong>` + product.price + ` £</strong>
                            </td>
                        </tr>
                    `;
                });
                products += `</table>`;
                $('#myShoppingCart').html(products);

                var deliveryPrice = 0;
                if (response.values.service.length>0){
                    deliveryPrice =response.values.service.price;
                }
                deliveryFee = '<strong>' + deliveryPrice.toString() + ' £</strong>';
                var subtotal = '<strong>'+response.values.total.toString() + ' £</strong>';

                var total = parseFloat(response.values.total) + parseFloat(deliveryPrice);
                total    =  '<strong>'+total.toString() + ' £</strong>';

                $('#_delivery').html(deliveryFee);
                $('#_subtotal').html(subtotal);
                $('#_total').html(total);

                total_price_to_check = total;
                $(".modal .close").click();
            }
            hideLoading();
        }).fail(function error(){ /*swal('error');*/ alert("error"); hideLoading(); });

    hideLoading();
}
function checkMinimumSelectedOptions(productKey, categoryKey) {
    //check topings
    var status = true;
    var topings = menuJson[categoryKey].products[productKey].topings;
    var topingOcurrences =  $.grep(newProduct.items, function (elem) {
        return elem['group'] === 'topings';
    }).length; // Returns 2
    if(topingOcurrences < topings.min){
        swal('At least '+topings.min + ' topings should be selected');
        alert('At least '+topings.min + ' topings should be selected');
        status = false;
    }

    var properties = menuJson[categoryKey].products[productKey].properties;
    $.each(properties, function (i, menuItem) {
        if(menuItem!=null) {
            //console.log(menuItem);
            var appearance = 0;
            $.each(newProduct.items, function (j, selectedItem) {

                if (i == selectedItem.group) {
                    appearance++;
                }
            });
            console.log(menuItem);
            if (appearance < menuItem.min) {
                // swal("Minimum 1 selection required for " + menuItem.name);
                alert("Minimum 1 selection required for " + menuItem.name);
                status = false;
            }
        }
    });
    return status;
}
function changeService(toService){
    showLoading();
    var data = null;
    $.post(baseUrl+'/changeservice/'+toService, data)
        .done(function(response) {
            if(toService=='pickup'){
                $('.changeToDelivery').removeClass('btn-primary');
                $('.changeToPickup').addClass('btn-primary');
                $('#serviceType').html('Pickup');
                $('.deliveryAddress').css('display','none');
                $('.deliveryAddressModal').css('display','none');
            }else if(toService=='delivery'){
                $('.changeToDelivery').addClass('btn-primary');
                $('.changeToPickup').removeClass('btn-primary');
                $('#serviceType').html('Delivery');
                $('.deliveryAddress').css('display','block');
                $('.deliveryAddressModal').css('display','block');
            }

            var deliveryFee = '<strong>'+response.values.service.price+ ' £</strong>';
            var subtotal = '<strong>'+response.values.total + ' £</strong>';

            var total = parseFloat(response.values.total) + parseFloat(response.values.service.price);
            total    =  '<strong>'+total + ' £</strong>';

            $('#_delivery').html(deliveryFee);
            $('#_subtotal').html(subtotal);
            $('#_total').html(total);
            total_price_to_check = total;
            hideLoading();
        }).fail(function error(){ alert('error')/*swal('error')*/; hideLoading(); });
}
function changeTime(toTime){
    showLoading();
    var data = null;
    $.post(baseUrl+'/changetime/'+toTime, data)
        .done(function(response) {
            if(toTime=='now'){
                $('.changeToLater').removeClass('btn-primary');
                $('.changeToNow').addClass('btn-primary');
                $('.serviceTime').html('ASAP');
                $('.scheduleDateTime').css('display', 'none');
                $('.deliveryAddress').css('display','none');
            }else if(toTime=='later'){
                $('.changeToLater').addClass('btn-primary');
                $('.changeToNow').removeClass('btn-primary');
                $('.scheduleDateTime').css('display', 'flex');
                $('.serviceType').html('');
                $('.deliveryAddress').css('display','block');
            }
            hideLoading();
        }).fail(function error(){ alert('error')/*swal('error')*/; hideLoading(); });
}
function deleteItemFromCart(key){
    showLoading();
    var data = null;
    $.post(baseUrl+'/delete/'+key, data)
        .done(function(response) {
            if(response.status == true){
                console.log(response.values);

                var products = `<table style="width:100%;" class="table table-striped">`;
                $.each(response.values.products, function(i, product){
                    products += `
                        <tr id="`+replaceVar(product.name)+`">
                            <td style="width:5%;">
                                <span class="deleteIcon"><i onclick="deleteItemFromCart(`+i+`)" class="fa fa-trash "></i></span>
                            </td>
                            <td style="width:70%;">
                                `+product.name+`<br />
                                <small>`+product.description+`</small>
                            </td>
                            <td style="width:25%;text-align:right;">
                                <strong>`+product.price+` £</strong>
                            </td>
                        </tr>
                    `;
                });
                products += `</table>`;
                $('#myShoppingCart').html(products);

                var deliveryPrice = 0;
                if (response.values.service.length>0){
                    deliveryPrice =response.values.service.price;
                }
                deliveryFee = '<strong>' + deliveryPrice + ' £</strong>';
                var subtotal = '<strong>'+response.values.total + ' £</strong>';

                var total = parseFloat(response.values.total) + parseFloat(deliveryPrice);
                total    =  '<strong>'+total + ' £</strong>';

                $('#_delivery').html(deliveryFee);
                $('#_subtotal').html(subtotal);
                $('#_total').html(total);
                total_price_to_check = total;
                hideLoading();
            }
        }).fail(function error(){ /*swal('error');*/alert('error'); hideLoading(); });
}
function scheduleOrder(){
    if(!$('.changeToNow').hasClass('btn-danger')) {
        var date = $('#schedule_date').val();
        if (date == '') {
            // swal('Please select Date !');
            alert('Please select Date !');
            return false;
        }
        var time = $('#schedule_time').val();
        if (time == '') {
            // swal('Please select Time');
            alert('Please select Time');
            return false;
        }
        //$(".modal .close").click();
        showLoading();
        $.post(baseUrl + '/scheduleOrder', {'date': date, 'time': time})
            .done(function (response) {
                if (response.values.date != null) {
                    var serviceTime = new Date(Date.parse(response.values.date));
                    serviceTime = ('0' + serviceTime.getDate()).slice(-2) +'-'
                                + ('0' + (serviceTime.getMonth()+1)).slice(-2) +'-'
                                + serviceTime.getFullYear()+ ' '
                                + serviceTime.getHours()+':'
                                + ('0' + serviceTime.getMinutes()).slice(-2);

                    $('#serviceTime').html(serviceTime);
                    hideLoading();
                    return true;
                }
            }).fail(function error() { alert('error');/*swal('error');*/ hideLoading(); return false; });
    }
}
function changeAddress(isFormValid, lat, lng, shop_lat_ng){

    // console.log(lat+' '+ lng);
    // console.log(shop_lat_ng);
    var address = $('#address_input').val();
    var name = $('#name_input').val();

    if(name==''){
        // swal('Please enter name !');
        alert('Please enter name !');
        return false;
    }
    if(address==''){
        // swal('Please enter the Address !');
        alert('Please enter the Address !');
        return false;
    }

    if(isFormValid == null || !isFormValid){
        // swal('Please fill valid address with at least street name, number , zip and city');
        alert('Please fill valid address with at least street name, number , zip and city');
        return false;
    }

    var tmp = shop_lat_ng.split(',');
    var lat2 = tmp[0];
    var lng2 = tmp[1];


    var d = distance(lat, lng, lat2, lng2,'K');
    // console.log(d);


    showLoading();
    $(".modal .close").click();
    var data = {
        'service':'delivery',
        'address':address,
        'name':name
    };
    $.post(baseUrl+'/changeAddress', data)
        .done(function(response) {
            console.log(response);
            $('#nameForDelivery').html(response.values.name);
            $('#addressForDelivery').html(response.values.address);
            hideLoading();
            return true;
            //$(".modal .close").click();
        })
        .fail(function error(){ alert('error');/*swal('error');*/ hideLoading(); return false; });
}
function showLoading(){
    $('#overlayLoading').css('visibility','visible');
    $('#overlayLoading').css('height',$(window).height());
    $('#overlayLoading').css('padding-top',$(window).height()/2-40);
    $('#overlayLoading').css('z-index','9');
}
function hideLoading(){
    $('#overlayLoading').css('visibility','hidden');
}
function continueToCheckout(){
    showLoading();
    if(minimum_delivery_price_to_check > total_price_to_check){
        hideLoading();
        // swal({
        //     type:'error',
        //     title:"You don't meet the minimum price to make an order !",
        // });
        alert("You don't meet the minimum price to make an order !");
        return '';
    }
    data = null;
    $.post(baseUrl+'/checkout', data)
        .done(function(response) {
            if(response.status == true){
                window.location = response.values.url;
            }
            if(response.status == false){
                // swal({
                //     type:'error',
                //     title:response.error,
                // });
                alert(response.error);
            }
            hideLoading();
        }).fail(function error(){ alert('error');/*swal('error');*/ hideLoading(); });;
}
function getWorkingHours(working_hours) {
    working_hours = JSON.parse(working_hours);
    var date = $('#schedule_date').val();
    date = date.split('-');
    var selectedDate = new Date(date[2], date[1]-1, date[0]);
    $('#schedule_time').val('');
    var days = {7:'sunday', 1:'monday', 2:'tuesday', 3:'wednesday', 4:'thursday', 5:'friday', 6:'saturday'};
    var dayName = days[selectedDate.getDay()];
    var tmp1 = working_hours[dayName]['hours_from'].split(':');
    tmp1 = [parseInt(tmp1[0]), parseInt(tmp1[1])];
    var tmp2 = working_hours[dayName]['hours_to'].split(':');
    tmp2 = [parseInt(tmp2[0]),parseInt(tmp2[1])];

    var now = new Date();
    if(now.getDate() == selectedDate.getDate()){
        tmp1 = [now.getHours(), Math.ceil(now.getMinutes()/10)*10 ];
    }

    var time_picker = $('#schedule_time').pickatime({
        interval: 10,
        formatSubmit: 'HH:i',
        format: 'HH:i',
        min:tmp1,
        max:tmp2,
    }).pickatime('picker');
    time_picker.set('min', tmp1);
    time_picker.set('max', tmp2);
}
function distance(lat1, lon1, lat2, lon2, unit) {
    var radlat1 = Math.PI * lat1/180
    var radlat2 = Math.PI * lat2/180
    var theta = lon1-lon2
    var radtheta = Math.PI * theta/180
    var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
    if (dist > 1) {
        dist = 1;
    }
    dist = Math.acos(dist)
    dist = dist * 180/Math.PI
    dist = dist * 60 * 1.1515
    if (unit=="K") { dist = dist * 1.609344 }
    if (unit=="N") { dist = dist * 0.8684 }
    return dist
}

function shop_is_closed(){
    $('#schedule_order_button').trigger('click');
}
function changeOrder(isFormValid, lat, lng, shop_lat_ng){

    let scheduleReturn = scheduleOrder();
    if(scheduleReturn == false){
        return;
    }
    let addressReturn = true;
    if($('.changeToDelivery').hasClass('btn-danger')) {
        addressReturn = changeAddress(isFormValid, lat, lng, shop_lat_ng);
    }
    if(scheduleReturn != false && addressReturn != false){
        $(".modal .close").click();
    }
}
