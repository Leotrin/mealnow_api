(function(){
    var StripeBilling ={
        init:function(){
            this.form = $('#billing-form');
            this.submitButton = this.form.find('input[type=submit]');

            var stripeKey = $('meta[name="publishable_key"]').attr('content');
            Stripe.setPublishableKey(stripeKey);
            this.bindEvents();
        },
        bindEvents:function(){
            this.form.on('submit', $.proxy(this.sendToken,this));
        },
        sendToken:function(event){
            this.submitButton.prop('disabled',true);
            Stripe.createToken(this.form, $.proxy(this.stripeResponseHandler, this));
            event.preventDefault();
        },
        stripeResponseHandler:function(status, response){
            console.log(status,response);
            if(response.error){
                this.submitButton.prop('disabled',false);
                return swal(response.error.message);
            }
            $('<input>',{
                'type':'hidden',
                'name':'stripeToken',
                'value':response.id
            }).appendTo(this.form);
            this.form[0].submit();
        }
    };
    StripeBilling.init();
})();