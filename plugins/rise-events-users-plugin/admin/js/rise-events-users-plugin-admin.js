jQuery(function(){

	let $ = jQuery;

	if($('#rer-list-users').length > 0){

		$('#rer-list-users').DataTable({

			"order": [[ 0, "desc" ]],
			dom: 'Bfrtip',
			buttons: [
			{
				extend: 'csv',
				footer: false,
				exportOptions: {
					columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14]
				}

			},

		]
		});
	}

	//change datatable csv button text
	const btn_csv = document.querySelector('.buttons-csv');
	btn_csv.innerHTML = "Export CSV";

	function path(uri, key, value, keyone, valueone) {
		let re = new RegExp('([?&])' + key + '=.*?(&|$)', 'i');
		let separator = uri.indexOf('?') !== -1 ? '&' : '?';

		if (uri.match(re)) {
			return uri.replace(re, '$1' + key + '=' + value + '$2');
		}
		else {

			return uri + separator + key + '=' + value + '&' + keyone + '=' + valueone;
		}
	}

	function pathshort(uri, key, value) {
		let re = new RegExp('([?&])' + key + '=.*?(&|$)', 'i');
		let separator = uri.indexOf('?') !== -1 ? '&' : '?';

		if (uri.match(re)) {
			return uri.replace(re, '$1' + key + '=' + value + '$2');
		}
		else {
			return uri + separator + key + '=' + value;

		}
	}



	$(document).on('click', '.rer_filter_date', function() {

		const tab_value = $('#rer_date').val();
		const tab_name = $('#rer_date').attr('name');

		const tab_from = $('#rer_date_from').val();
		const tab_name_from = $('#rer_date_from').attr('name');



		if(tab_value != '' && tab_from != ''){
			document.location.href = path(window.location.href, tab_name, tab_value, tab_name_from, tab_from);
			}else if(tab_value !== ""){

				document.location.href = pathshort(window.location.href, tab_name, tab_value);
			}else{
				document.location.href = pathshort(window.location.href, tab_name_from, tab_from);
			}


	});

	$(document).on('click', '#rer_filter', function() {

		const tab_value = $('#rer_events_title').val();
		const tab_name = $('#rer_events_title').attr('name');

		document.location.href = path(window.location.href, tab_name, tab_value);


	});


	$(document).on("click", ".rer_delete_user", function () {

		var rer_user_id = $(this).attr("data-id");

		var conf = confirm("Are you sure you want to delete?");


		if(conf){

			var postdata = "action=admin_ajax_request&param=delete_rer_user&rer_user_id=" + rer_user_id;

			$.post(ajaxurl, postdata, function(response){

				var data = $.parseJSON(response);




				if(data.status == 1){

					alert(data.message);

					setTimeout(function(){
						location.reload();
					}, 1000);
				}else{

					alert(data.message);
				}

			});

		}



	});



});