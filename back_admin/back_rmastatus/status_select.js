$(document).ready(function(){
	var result;
	var status = '';
	var status_names = ["In Transit", "Received", "In Repair", "Repair Done", "Shipped", "On Hold"];
	$('.datepicker').datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		maxDate: 0
	});
	$('#view_list_btn').click(function(){
		var date_from = $('#date_from').val();
		status = $('#stat_select').val();
		//console.log(status);
		var date_to = $('#date_to').val();
		if(date_from != '' && (date_to < date_from || date_to === '' )){
			date_to = date_from;
		}
		if(date_from === ''){
			alert("Enter the first date");
		}
		else if (date_from != ''){
			var data = '';
			//any status selected except "Hold"
				$.ajax({
					type: 'POST',
					url: 'get_status.php',
					data: {from: date_from, to: date_to, status: status},
					datatype: 'json',
					success: function(result){
						result = JSON.parse(result);
						console.log(result);
						//result.message will be set only if there's some error getting the data from the DB
						if(result.message){
							alert(result.message);
						}
						$('#num_items').show().html('<h4><b>Number of Items: '+ result.length +'</b></h4>');
						if(result.length > 0) {
							//	If "In Transit" status is selected, show the table with non redundant data
							//	{'date arrived, technician name', etc. become redundant}
							if(status == 1){
								//Hide the remaining three tables on the page
								$('#li_list_table2').hide();
								$('#li_list_table3').hide();
								$('#li_list_table_hold').hide();
								$('#li_list_table1').show();
								for(var i = 0; i < result.length; i++){
									data += '<tr>';
									data += '<td>'+ result[i].RMA_number +'</td>';
									data += '<td>'+ result[i].li_id +'</td>';
									data += '<td>'+ result[i].device_name +'</td>';
									data += '<td>'+ result[i].device_number +'</td>';
									data += '<td>'+ result[i].serial_number +'</td>';
									data += '<td>'+ result[i].service_name +'</td>';
									data += '<td>'+ result[i][0] +'</td>';
									data += '</tr>';
								}
								$('#li_list_data1').html(data);
							}
							// If "In Repair" has been selected
							else if(status == 3){
								//Hide the remaining three tables on the page
								$('#li_list_table1').hide();
								$('#li_list_table3').hide();
								$('#li_list_table_hold').hide();
								$('#li_list_table2').show();
								for(var i = 0; i < result.length; i++){
									data += '<tr>';
									data += '<td>'+ result[i].RMA_number +'</td>';
									data += '<td>'+ result[i].li_id +'</td>';
									data += '<td>'+ result[i].device_name +'</td>';
									data += '<td>'+ result[i].device_number +'</td>';
									data += '<td>'+ result[i].serial_number +'</td>';
									data += '<td>'+ result[i].service_name +'</td>';
									data += '<td>'+ result[i][0] +'</td>';
									data += '<td>'+ result[i].date_arrived +'</td>';
									data += '</tr>';
								}
								$('#li_list_data2').html(data);
							}
							else if(status == 4 || status == 5){
								//Hide the remaining three tables on the page
								$('#li_list_table1').hide();
								$('#li_list_table2').hide();
								$('#li_list_table_hold').hide();
								$('#li_list_table3').show();
								for(var i = 0; i < result.length; i++){
									data += '<tr>';
									data += '<td>'+ result[i].RMA_number +'</td>';
									data += '<td>'+ result[i].li_id +'</td>';
									data += '<td>'+ result[i].device_name +'</td>';
									data += '<td>'+ result[i].device_number +'</td>';
									data += '<td>'+ result[i].serial_number +'</td>';
									data += '<td>'+ result[i].service_name +'</td>';
									data += '<td>'+ result[i][0] +'</td>';
									data += '<td>'+ result[i].date_arrived +'</td>';
									data += '<td>'+ result[i].date_closed +'</td>';
									data += '<td>'+ result[i].tech_name +'</td>';
									data += '<td>'+ result[i].prob_found +'</td>';
									data += '<td>'+ result[i].repair_done +'</td>';
									data += '</tr>';
								}
								$('#li_list_data3').html(data);
							}
							else if(status == 6){
								//alert("Getting the hold data back...");
								$('#li_list_table1').hide();
								$('#li_list_table2').hide();
								$('#li_list_table3').hide();
								$('#li_list_table_hold').show();
								for(var i = 0; i < result.length; i++){
									data += '<tr>';
									data += '<td>'+ result[i][0].RMA_number +'</td>';
									data += '<td>'+ result[i].li_id +'</td>';
									data += '<td>'+ result[i][0].device_name +'</td>';
									data += '<td>'+ result[i][0].device_number +'</td>';
									data += '<td>'+ result[i][0].serial_number +'</td>';
									data += '<td>'+ result[i][0].service_name +'</td>';
									data += '<td>'+ result[i][1] + '</td>';
									data += '<td>'+ result[i].date_hold +'</td>';
									data += '<td>'+ result[i].PO_NO +'</td>';
									data += '<td>'+ result[i].ETA +'</td>';
									data += '<td>'+ result[i].dmr +'</td>';
									data += '<td>'+ result[i].missing_part +'</td>';
									data += '<td>'+ result[i].note +'</td>';
									data += '</tr>';
								}
								$('#li_list_data_hold').html(data);
							}
						}
						//no row was returned for the status and the given time period.
						else{
							//hide the tables which are already in display if there are no rows for the selected period
							$('#num_items').hide();
							$('#li_list_table1').hide();
							$('#li_list_table2').hide();
							$('#li_list_table3').hide();
							$('#li_list_table_hold').hide();
						}
					},
					error: function(jqxhr, dataText){
						$('#num_items').hide();
						alert("Error: " + dataText);
					}
				});	//end of ajax call
			// //hold status information is required
			// else if(status == 6){
			// 	$.ajax({
			// 		type: 'POST',
			// 		url: 'get_status.php',
			// 		data: {from: date_from, to: date_to, status: status},
			// 		datatype: 'json',
			// 		success: function(result){
			// 			result = JSON.parse(result);
			// 			console.log(result);
			// 			//result.message will be set only if there's some error getting the data from the DB
			// 			if(result.message){
			// 				alert(result.message);
			// 			}
			// 			$('#num_items').show().html('<h4><b>Number of Items: '+ result.length +'</b></h4>');
			// 		}
			// 	});
			// }
		}
	});	//end of view_list button click event function
	$('#export').click(function(){
		var sname = status_names[status-1];
		//console.log(sname);
		if($('#li_list_table1').css('display') != 'none'){
			$('#li_list_table1').excelexportjs({
				containerid: "li_list_table1",
				datatype: 'table',
				worksheetName: sname
			});
		}
		else if($('#li_list_table2').css('display') != 'none'){
			$('#li_list_table2').excelexportjs({
				containerid: "li_list_table2",
				datatype: 'table',
				worksheetName: sname
			});
		}
		else if($('#li_list_table3').css('display') != 'none'){
			$('#li_list_table3').excelexportjs({
				containerid: "li_list_table3",
				datatype: 'table',
				worksheetName: sname
			});
		}
		else if($('#li_list_table_hold').css('display') != 'none'){
			$('#li_list_table_hold').excelexportjs({
				containerid: "li_list_table_hold",
				datatype: 'table',
				worksheetName: sname
			});
		}
	});
});	//end of document ready function