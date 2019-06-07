$(document).ready(function(){
	$('#search_rma').on('click', function(){
		var number = $('#myInput').val();
		$.ajax({
			type: 'GET',
			url: '../../common_files/get_rma_info.php?rma=' + number,
			datatype: 'json',
			success: function(result){
				result = JSON.parse(result);
				if(result.message){
					$('#rma_detail').hide();
					alert ("Error: " + result.message);
				}
				else{
					console.log(result);
					$('#rma_detail').show();
					$('#print_rma').html('<b>RMA Number: </b>'+ result[0]);	//display rma_number
					$('#print_date').html('<b>Date: </b>' + result[2]);	//display date of rma submit
					$('#print_quantity').html('<b>Number of Items: </b>' + result[3]);	//display the number of line items in the rma 
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log('onFail(jqXHR, textStatus, errorThrown)');
		        console.log(jqXHR);
		        console.log(textStatus);
		        console.log(errorThrown);
			}
		});	//	end of ajax call to find_rma_details.php
		$.ajax({
			type: 'GET',
			url: 'find_li_details.php?rma=' + number,
			datatype: 'json',
			success: function(result){
				result = JSON.parse(result);
				if(result.message){
					//alert ("Error: " + result.message);
					$('#print_order_table').hide();
				}
				else{
					console.log(result);
					$('#print_order_table').show();
					var print_row = '';
					for(var i = 0; i < result.length; i++){
						print_row += '<tr>';
						print_row += '<td>'+ result[i].li_id +'</td>';
						print_row += '<td>'+ result[i].device_name +'</td>';
						print_row += '<td>'+ result[i].device_number +'</td>';
						print_row += '<td>'+ result[i].serial_number +'</td>';
						print_row += '<td>'+ result[i].service_name +'</td>';
						print_row += '<td>'+ result[i].prob_desc +'</td>';
						print_row += '<td><button type="button" class="btn btn-outline-dark edit_li" id="'+ result[i].li_id +'">Edit</button></td>';
						print_row += '<td><button type="button" class="btn btn-outline-info print_form" id="'+ result[i].li_id +'">Print</button></td>';
						print_row += '</tr>';
					}
					$('#print_table_row').html(print_row);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				console.log('onFail(jqXHR, textStatus, errorThrown)');
		        console.log(jqXHR);
		        console.log(textStatus);
		        console.log(errorThrown);
			}
		});	//end of ajax call to find_li_details
	});	//end of onclick event function

	$('#print_order_table').on('click', '.edit_li', function(){
		var li = this.id;
		//console.log(li);
		window.location = 'edit_li_details.php?li=' + li;
	});

	$('#print_order_table').on('click', '.print_form', function(){
		var li = this.id;
		//console.log(li);
		window.location = 'print_form.php?li=' + li;
	});

	//This function binds the onclick function with enter key
	$('#myInput').keyup(function(e){
		if(e.keyCode === 13){	//if enter key pressed
			$('#search_rma').click();
		}
	});
});	//end of document ready function