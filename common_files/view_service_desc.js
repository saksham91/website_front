$(document).ready(function(){
	var modal = document.getElementById('myModal');
	$('#disp_table').on('click', '.view_btn', function(){
		var li = this.id;
		console.log(li);
		$('.modal').fadeIn(500);
		populate_info(li);
	});

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        // modal.style.display = "none";
	        $('.modal').fadeOut(500);
	        //removeText();
	    }
	}
});	//end of document function

function populate_info(li){
	var problem, repair, arrive, closed;
	$.ajax({
		type: 'GET',
		url: 'get_service_desc.php?li=' + li,
		datatype: 'json',
		success: function(result){
			result = JSON.parse(result);
			console.log(result);
			problem = isEmpty(result[0].prob_found) ? "Item hasn't been checked yet" : result[0].prob_found;
			repair = isEmpty(result[0].repair_done) ? 'Repair not finished' : result[0].repair_done;
			arrive = invalid_date(result[0].date_arrived) ? 'Not Arrived' : print_date(result[0].date_arrived);
			closed = invalid_date(result[0].date_closed) ? '-' : print_date(result[0].date_closed);
			$('#prob_found').val(problem);
			$('#rep_done').val(repair);
			$('#date_arrived').val(arrive);
			$('#date_closed').val(closed);

		},
		error: function(result){
			alert("Request failed: " + result.responseJSON.message);
		}
	})	//end of ajax call
}

function isEmpty(expr){
	if (expr === '' || expr === null)
		return true;
	else
		return false;
}

function invalid_date(date_to_check){
	if(date_to_check === null){
		return true;
	}
	var days = date_to_check.split('-');
	if(days[0] === '0000'){
		return true;
	}
	else{
		return false;
	}
}

/* 
	Format the date received (YYYY-MM-DD) as (DD Monthname, YYYY)
	date_to_print - The date we receive from the database(MySQL)
	days - Split the date into an array containing 3 elements [yyyy, mm, dd]
	d_month - To get the name of the month, we map the month to the array 'months' which contains name of months.
	
	Needed to adjustment as month is received as a two-digit number, i.e. - 04 (April). The adjustment is, check if the month is < 10.
	If it's not no adjustment needed. If it is, split the two digits and store the new single-digit value of month.
	In the end, months[d_month-1] is needed as the array index start from 0.
*/
function print_date(date_to_print){
	var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
	var days = date_to_print.split('-');
	var d_year = days[0];
	var d_month = days[1];
	if (d_month < 10){
		var arr_index = d_month.split('');
		d_month = arr_index[1];
	}
	console.log(d_month);
	var d_day = days[2];
	var format_date = d_day + ' ' + months[d_month-1] + ', ' + d_year;
	return format_date; 
}