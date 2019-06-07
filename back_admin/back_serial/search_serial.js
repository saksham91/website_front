$(document).ready(function(){
	$('#search_serial').on('click', function(){
		var snum = $('#myInput').val();
		if(snum.length > 10){
			alert("Invalid Serial Number!");
		}
		else{
			$.ajax({
				type: 'POST',
				url: 'get_snum_info.php',
				data: {serial: snum},
				datatype: 'json',
				success: function(result){
					result = JSON.parse(result);
					//console.log(result);
					if(result.message){
						alert("Error: " + result.message);
					}
					else{
						var print_row = '';
						$('#snum_detail').show();
						//$('#print_company').html('<b>Customer: </b>'+ result[0][0]);	//display company name
						//$('#print_date').html('<b>Date: </b>' + result[0][1]);	//display date of rma submit
						$('#snum_table').show();
						for(var i = 0; i < result.length; i++){
							print_row += '<tr>';
							print_row += '<td>'+ result[i].RMA_number +'</td>';
							print_row += '<td>'+ result[i][0] +'</td>';
							print_row += '<td>'+ result[i].li_id +'</td>';
							print_row += '<td>'+ result[i].device_name +'</td>';
							print_row += '<td>'+ result[i].device_number +'</td>';
							print_row += '<td>'+ result[i].serial_number +'</td>';
							print_row += '<td>'+ result[i].service_name +'</td>';
							print_row += '<td>'+ result[i].status_name +'</td>';
							print_row += '</tr>';
						}
						$('#print_table_row').html(print_row);
					}
				},
				error: function(jqXHR, textStatus){
					alert("Problem in connection: " + textStatus);
				}
			});	//end of ajax call
		}
	});	//end of on click function
	//This function binds the onclick function with enter key
	$('#myInput').keyup(function(e){
		if(e.keyCode === 13){	//if enter key pressed
			$('#search_serial').click();
		}
	});
});