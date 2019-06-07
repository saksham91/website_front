$(document).ready(function(){
	var id = '';
	// On clicking view button, it will generate the service table for the selected customer
	$('#view_service').on('click', reproduce_table);
	
	/*	On clicking add new service--- 
		On success, it will add the service for the selected customer and reproduce the new table
		On Failure, it will show an alert with failed text message	*/
	$('#add_service').on('click', function(){
		var service = $('#service_1').val();
		id = $('#company_name').val();
		$.ajax({
			type: 'POST',
			url: 'add_user_service.php',
			data: {user_id: id, service: service}, 
			datatype: 'json',
			success: function(){
				$('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
	        	$('.error_success').show();
				setTimeout(function() { 
				$('.error_success').hide(); }, 2000);
				reproduce_table();
			},
			error: function(jqXHR, textStatus, errorThrown){
				//console.log('onFail(jqXHR, textStatus, errorThrown)');
		        //console.log(jqXHR);
		        alert("Request failed: " + textStatus);
		        console.log(errorThrown);	
		        $('.error_success').html('<p style="color: red;">Invalid Value.. <i class="fa fa-times-circle fa-4x" aria-hidden="true"></i></p>');
	        	$('.error_success').show();
				setTimeout(function() { 
				$('.error_success').hide(); }, 2000);			
			}
		});	//end of ajax call
	});//	end of add_service function

	/*
		Delete the service, show the success/error notification on request completion and then reproduce the table
		along with the choose service dropdown which is also updated
	*/
	$('#user_service').on('click', '.del_service', function(){
		var service = this.id;
		id = $('#company_name').val();
		$.ajax({
			type: 'POST',
			url: 'delete_user_service.php',
			data: {user_id: id, service: service}, 
			datatype: 'json',
			success: function(){
				$('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
	        	$('.error_success').show();
				setTimeout(function() { 
				$('.error_success').hide(); }, 2000);
				reproduce_table();
			},
			error: function(jqXHR, textStatus, errorThrown){
		        alert("Request failed: " + textStatus);
		        console.log(errorThrown);	
		        $('.error_success').html('<p style="color: red;">Invalid Value.. <i class="fa fa-times-circle fa-4x" aria-hidden="true"></i></p>');
	        	$('.error_success').show();
				setTimeout(function() { 
				$('.error_success').hide(); }, 2000);			
			}
		});	//end of ajax call
	});	//end of del_service on click function
});	//end of doc.ready function


/*
	The function which reproduces service table of the selected user as well as
	populates the service dropdown from the services that are not availed by the user. (By calling display_service)
	diff - a variable that uses a slick function to get the difference of two arrays. Here, it will return the service ID's not available to the current user
*/
function reproduce_table(){
	var user_service = [];
	var all_service = ['1', '2', '3', '4', '5'];
	var map_name = [null, "Warranty", "APE", "LCM", "OOBF", "Non-warranty"];
	id = $('#company_name').val();
		var row = '';
		$.ajax({
			type: 'GET',
			url: 'get_user_service.php?user_id=' + id,
			datatype: 'json',
			success: function(result){
				$('#myTable').show();
				result = JSON.parse(result);
				//console.log(result);
				for(var i = 0; i < result.length; i++){
					user_service.push(result[i].service_id);	//filling the array with current services of the user
					row += '<tr><td><b>'+ result[i].service_id +'</b></td>';
					row += '<td><b>'+ result[i].service_name +'</b></td>';
					row += '<td><button type="button" class="btn btn-outline-danger del_service" id="'+ result[i].service_id +'">Delete</button></td></tr>';
				}
				$('#user_service').html(row);
				var diff = $(all_service).not(user_service).get();
				//console.log(diff);
				display_service(diff, map_name);
				user_service.length = 0;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log('onFail(jqXHR, textStatus, errorThrown)');
		        console.log(jqXHR);
		        console.log(textStatus);
		        console.log(errorThrown);
			}
		});
	}

/*
	Based on the services not found for the user by the above function, 
	the choose service dropdown will be populated accordingly. That is,
	the choose service will only list services which are not availed by the user.
*/
function display_service(difference, map_name){
	var row = '';
	for(var i = 0; i < difference.length; i++){
		row += '<option value="'+ difference[i] +'">'+ map_name[parseInt(difference[i])] +'</option>';
	}
	$('#service_1').html(row);
}