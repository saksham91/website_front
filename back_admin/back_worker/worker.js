$(document).ready(function(){
	$('.datepicker').datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		maxDate: 0
	});
	$('#view_list_btn').click(function(){
		var date_from = $('#date_from').val();
		var tech = $('#tech_name').val();
		var date_to = $('#date_to').val();
		//console.log(date_to);
		if(date_from != '' && (date_to < date_from || date_to === '' )){
			date_to = date_from;
		}
		if(date_from === ''){
			alert("Enter the first date");
		}
		/*	Selected the date range but no technician.
			Display all the li numbers for the period for which a technician has been assigned	*/
		else if (date_from != '' && tech === ''){
			var data = '';
			$.ajax({
				type: 'POST',
				url: 'get_all_li.php',
				data: {from: date_from, to: date_to},
				datatype: 'json',
				success: function(result){
					result = JSON.parse(result);
					console.log(result);
					$('#num_items').show().html('<h4><b>Number of Items: '+ result.length +'</b></h4>');
					if(result.length > 0){
						$('#li_list_table2').hide();	//hide the table 2 when no technician is selected
						$('#li_list_table').show();
						for(var i = 0; i < result.length; i++){
							if((result[i].date_arrived == '0000-00-00') || (result[i].date_arrived == null)) {
								result[i].date_arrived = '-';
							}
							if((result[i].date_closed == '0000-00-00') || (result[i].date_closed == null)) {
								result[i].date_closed = '-';
							}
							data += '<tr>';
							data += '<td>'+ result[i].RMA_number +'</td>';
							data += '<td>'+ result[i].li_id +'</td>';
							data += '<td>'+ result[i].device_name +'</td>';
							data += '<td>'+ result[i].device_number +'</td>';
							data += '<td>'+ result[i].serial_number +'</td>';
							data += '<td>'+ result[i][0] +'</td>';
							data += '<td>'+ result[i].tech_name +'</td>';
							data += '<td>'+ result[i].status_name +'</td>';
							data += '<td>'+ result[i].date_arrived +'</td>';
							data += '<td>'+ result[i].date_closed +'</td>';
							data += '</tr>';
						}
						$('#li_list_data').html(data);
					}
					else{
						//hide the tables which are already in display if there are no rows for the selected period
						$('#num_items').hide();
						$('#li_list_table').hide();
						$('#li_list_table2').hide();
					}
				},
				error: function(jqxhr, dataText){
					$('#num_items').hide();
				}
			});
		}
		// selected the technician and the date range
		else if(date_from != '' && tech != ''){
			var data = '';
			$.ajax({
				type: 'POST',
				url: 'get_worker_li.php',
				data: {from: date_from, to: date_to, tech: tech},
				datatype: 'json',
				success: function(result){
					result = JSON.parse(result);
					$('#num_items').show().html('<h4><b>Number of Items: '+ result.length +'</b></h4>');
					/*	Display the tables only if there is atleast one row for the selected date range
						for a selected technician	*/
					if(result.length > 0){
						$('#li_list_table').hide();		//hide the table 1 when a technician is selected
						$('#li_list_table2').show();
						for(var i = 0; i < result.length; i++){
							if(result[i].date_arrived == '0000-00-00' || result[i].date_arrived == null){
								result[i].date_arrived = '-';
							}
							if(result[i].date_closed == '0000-00-00' || result[i].date_closed == null){
								result[i].date_closed = '-';
							}
							data += '<tr>';
							data += '<td>'+ result[i].RMA_number +'</td>';
							data += '<td>'+ result[i].li_id +'</td>';
							data += '<td>'+ result[i].device_name +'</td>';
							data += '<td>'+ result[i].device_number +'</td>';
							data += '<td>'+ result[i].serial_number +'</td>';
							data += '<td>'+ result[i][0] +'</td>';
							data += '<td>'+ result[i].status_name +'</td>';
							data += '<td>'+ result[i].date_arrived +'</td>';
							data += '<td>'+ result[i].date_closed +'</td>';
							data += '</tr>';
						}
						$('#li_list_data2').html(data);
					}
					/*	hide the tables which are already in display if there are no rows
						for the selected period for the selected technician	*/
					else{
						$('#num_items').hide();
						$('#li_list_table').hide();
						$('#li_list_table2').hide();
					}
				},
				error: function(jqxhr, dataText){
					$('#num_items').hide();
				}
			});
		}
	});
});