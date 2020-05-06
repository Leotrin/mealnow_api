function generate_availability(number, nr){
    var available = menuJson.items[number].products[nr].availability;
    return `
    <button type="button" data-toggle="modal" data-target="#product_availability_`+number+`_` + nr + `" class="btn btn-warning btn-small">
        <i class="fas fa-clock"></i> Availability
    </button>
    <div class="modal fade" id="product_availability_`+number+`_` + nr + `" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Product Availability</h4>
          </div>
          <div class="modal-body text-left">
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_monday_hours_status" `+check_days(available.monday.status)+` /> Monday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_monday_hours_from" value="`+available.monday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_monday_hours_to" value="`+available.monday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_tuesday_hours_status" `+check_days(available.tuesday.status)+` /> Tuesday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_tuesday_hours_from" value="`+available.tuesday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_tuesday_hours_to" value="`+available.tuesday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_wednesday_hours_status" `+check_days(available.wednesday.status)+` /> Wednesday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_wednesday_hours_from" value="`+available.wednesday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_wednesday_hours_to" value="`+available.wednesday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_thursday_hours_status" `+check_days(available.thursday.status)+` /> Thursday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_thursday_hours_from" value="`+available.thursday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_thursday_hours_to" value="`+available.thursday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_friday_hours_status" `+check_days(available.friday.status)+` /> Friday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_friday_hours_from" value="`+available.friday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_friday_hours_to" value="`+available.friday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_saturday_hours_status" `+check_days(available.saturday.status)+` /> Saturday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_saturday_hours_from" value="`+available.saturday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_saturday_hours_to" value="`+available.saturday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 p10">
                <div class="col-md-4">
                    <label><input type="checkbox" id="`+number+`_`+nr+`_sunday_hours_status" `+check_days(available.sunday.status)+` /> Sunday</label>
                </div>
                <div class="col-md-4">
                    <label>From </label>
                    <input type="text" id="`+number+`_`+nr+`_sunday_hours_from" value="`+available.sunday.from_hour+`" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label>To </label>
                    <input type="text" id="`+number+`_`+nr+`_sunday_hours_to" value="`+available.sunday.to_hour+`" class="form-control" />
                </div>
                <div class="clearfix"></div>
            </div>
          <div class="clearfix"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveAvailability(`+number+`,` + nr + `)">Save changes</button>
          </div>
        </div>
      </div>
    </div>`;

}
function check_days(day){
    if(day==true){
        return ' checked ';
    }
    return '';
}
function daysForJson(day){
    if(day!=''){
        return true;
    }else{
        return false;
    }
}
function saveAvailability(number, nr){

    var monday      = number+'_'+nr+'_monday_hours_status';
    var mondayFrom  = number+'_'+nr+'_monday_hours_from';
    var mondayTo    = number+'_'+nr+'_monday_hours_to';
    if ($('#'+monday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.monday = {
            'status':true,
            'from_hour':mondayFrom,
            'to_hour':mondayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.monday = {
            'status':false,
            'from_hour':mondayFrom,
            'to_hour':mondayTo
        }
    }

    var tuesday     = number+'_'+nr+'_tuesday_hours_status';
    var tuesdayFrom = number+'_'+nr+'_tuesday_hours_from';
    var tuesdayTo   = number+'_'+nr+'_tuesday_hours_to';
    if ($('#'+tuesday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.tuesday = {
            'status':true,
            'from_hour':tuesdayFrom,
            'to_hour':tuesdayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.tuesday = {
            'status':false,
            'from_hour':tuesdayFrom,
            'to_hour':tuesdayTo
        }
    }

    var wednesday       = number+'_'+nr+'_wednesday_hours_status';
    var wednesdayFrom   = number+'_'+nr+'_wednesday_hours_from';
    var wednesdayTo     = number+'_'+nr+'_wednesday_hours_to';
    if ($('#'+wednesday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.wednesday = {
            'status':true,
            'from_hour':wednesdayFrom,
            'to_hour':wednesdayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.wednesday = {
            'status':false,
            'from_hour':wednesdayFrom,
            'to_hour':wednesdayTo
        }
    }

    var thursday        = number+'_'+nr+'_thursday_hours_status';
    var thursdayFrom    = number+'_'+nr+'_thursday_hours_from';
    var thursdayTo      = number+'_'+nr+'_thursday_hours_to';
    if ($('#'+thursday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.thursday = {
            'status':true,
            'from_hour':thursdayFrom,
            'to_hour':thursdayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.thursday = {
            'status':false,
            'from_hour':thursdayFrom,
            'to_hour':thursdayTo
        }
    }

    var friday      = number+'_'+nr+'_friday_hours_status';
    var fridayFrom  = number+'_'+nr+'_friday_hours_from';
    var fridayTo    = number+'_'+nr+'_friday_hours_to';
    if ($('#'+friday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.friday = {
            'status':true,
            'from_hour':fridayFrom,
            'to_hour':fridayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.friday = {
            'status':false,
            'from_hour':fridayFrom,
            'to_hour':fridayTo
        }
    }

    var saturday    = number+'_'+nr+'_saturday_hours_status';
    var saturdayFrom= number+'_'+nr+'_saturday_hours_from';
    var saturdayTo  = number+'_'+nr+'_saturday_hours_to';
    if ($('#'+saturday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.saturday = {
            'status':true,
            'from_hour':saturdayFrom,
            'to_hour':saturdayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.saturday = {
            'status':false,
            'from_hour':saturdayFrom,
            'to_hour':saturdayTo
        }
    }

    var sunday      = number+'_'+nr+'_sunday_hours_status';
    var sundayFrom  = number+'_'+nr+'_sunday_hours_from';
    var sundayTo    = number+'_'+nr+'_sunday_hours_to';
    if ($('#'+sunday+':checkbox:checked').length > 0) {
        menuJson.items[number].products[nr].availability.sunday = {
            'status':true,
            'from_hour':sundayFrom,
            'to_hour':sundayTo
        }
    }else{
        menuJson.items[number].products[nr].availability.sunday = {
            'status':false,
            'from_hour':sundayFrom,
            'to_hour':sundayTo
        }
    }
    save_menu();
    $('#'+number+'_'+nr+'_product_availability').trigger('click.dismiss.bs.modal')
}