/*	Function to display the order on the confirm_order.php page for the user. For display, just using the JS object and not getting info from the DB.
	
	get_order - the JS object with the order information
	service_name - the array to map the service_id to the name of the service to display in table 

 */

$(document).ready(function() {
	var today = new Date();
	var urlParams = new URLSearchParams(location.search);
	var user_id = urlParams.get('user_id');
	var get_order = JSON.parse(localStorage.getItem('order'));
	if(get_order != null){
		var count_item = get_order.length;
	}
	//console.log(get_order);
	var confirm_row = '';
	var service_name = [null, 'Warranty', 'APE', 'LCM', 'OOBF', 'Non-Warranty'];
	for(var i = 0; i < count_item; i++){
		confirm_row += '<tr>';
		confirm_row += '<td>'+ (i+1) +'</td>';
		confirm_row += '<td>'+ get_order[i].device +'</td>';
		confirm_row += '<td>'+ get_order[i].part +'</td>';
		confirm_row += '<td>'+ get_order[i].serial +'</td>';
		confirm_row += '<td>'+ service_name[parseInt(get_order[i].service)] +'</td>';
		confirm_row += '<td>'+ get_order[i].prob_desc +'</td>';
		confirm_row += '<tr>';
	}
	$('#confirm_table_row').append(confirm_row);
	//localStorage.removeItem('order');
	$('#display_date').html(today.toLocaleDateString("en-US"));
	$('#submit_rma').on('click', function () {
		if(get_order != null){
			$('#spinner_gif').show();
			$('#submit_rma').attr('disabled', true);
			$.ajax({
				type: 'POST',
				url: 'push_order.php',
				data: {order: get_order, user: user_id, items: count_item},
				datatype: 'json',
				success: function(result) {
					$('#spinner_gif').hide();
					result = JSON.parse(result);
					localStorage.setItem('rma_num', result);
				 	window.location = "print_order.php?user_id="+user_id;
				},
				error: function(){
					$('#spinner_gif').hide();
					$('#submit_rma').attr('disabled', false);
					alert("Can't connect to the server");
				}
			});	//ajax ends
		}
		else{
			alert("You need to make a new RMA order");
		}
	});	// submit rma click function ends	
});	//document ready function ends