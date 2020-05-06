/* Webarch Admin Dashboard 
-----------------------------------------------------------------*/ 
$(document).ready(function() {		
	$('#login-form').validate({

                focusInvalid: false, 
                ignore: "",
                rules: {
                    txtusername: {
                        minlength: 2,
                        required: true
                    },
                    txtpassword: {
                        required: true,
                    }
                },

                invalidHandler: function (event, validator) {
					//display errors alert on form submit
                },

                errorPlacement: function (label, element) { // render errors placement for each input type
					$('<span class="errors"></span>').insertAfter(element).append(label)
                    var parent = $(element).parent('.input-with-icon');
                    parent.removeClass('success-control').addClass('errors-control');
                },

                highlight: function (element) { // hightlight errors inputs
					
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
					var parent = $(element).parent('.input-with-icon');
					parent.removeClass('errors-control').addClass('success-control');
                },
			    submitHandler: function(form) {
						form.submit();
				}
            });	

});