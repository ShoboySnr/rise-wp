jQuery(function () {
	let $ = jQuery;



	var ajaxurl = rer_rise_users_registration.ajaxurl;


	//
	jQuery("#rer-frontend-form").validate({
		submitHandler: function () {
			var postdata = jQuery("#rer-frontend-form").serialize();

			postdata += "&action=public_ajax_request&param=rise_user_reg_plugin";

			$.post(ajaxurl, postdata, function (response) {

			var data = jQuery.parseJSON(response);

			if(data.status == 1){
				$rer_response = data.message;
				$(".rer_response").css('display', 'block');
				$(".rer_response").html(" <h2 >" + data.message + "</h2>");
				// $("html,.rer_response").animate({ scrollTop:$('.rer_response').prop("scrollHeight")}
				$('#rer-frontend-form').fadeOut();
				$('.rer-hide').fadeOut();
			}
			});


		}

	});


	$('select').on('change', function() {
		if ($(this).val()) {
			return $(this).css('color', 'black');
		} else {
			return $(this).css('color', 'gray');
		}
	});



});