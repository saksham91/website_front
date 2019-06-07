$(document).ready(function() {
	var get_order = JSON.parse(localStorage.getItem('order'));
	var rma_num = JSON.parse(localStorage.getItem('rma_num'));
	var urlParams = new URLSearchParams(location.search);
	var user_id = urlParams.get('user_id');
	printAddress();
	localStorage.clear();
	$('#print_rma').append(rma_num);
	$.ajax({
		type: 'GET',
		url: 'get_rma_info.php?user_id='+user_id+'&rma='+rma_num,
		datatype: 'json',
		success: function(result){
			result = JSON.parse(result);
			//console.log(result);
			$('#print_date').append(result[2]);
			$('#print_quantity').append(result[3]);
		},
		error: function(){
			alert("Couldn't connect to the server...");
		}
	});
	$.ajax({
		type: 'GET',
		url: 'get_li_info.php?user_id='+user_id+'&rma='+rma_num,
		datatype: 'json',
		success: function(result){
			result = JSON.parse(result);
			//console.log(result);
			var print_row = '';
			var service_name = [null, 'Warranty', 'APE', 'LCM', 'OOBF', 'Non-Warranty'];
			for(var i = 0; i < result.length; i++){
				print_row += '<tr>';
				print_row += '<td>'+ result[i].id +'</td>';
				print_row += '<td>'+ result[i].name +'</td>';
				print_row += '<td>'+ result[i].pno +'</td>';
				print_row += '<td>'+ result[i].sno +'</td>';
				print_row += '<td>'+ service_name[parseInt(result[i].serv)] +'</td>';
				print_row += '<td>'+ result[i].problem +'</td>';
				print_row += '<td>'+ result[i].stat +'</td>';
				print_row += '<tr>';
			}
			$('#print_table_row').append(print_row);
		},
		error: function(){
			alert("Couldn't connect to the server...");
		}
	});
	// $('#print_rma').click(function(){
	// });
});

function printAddress() {
	var address = "";
	address += "<h4><b>Shipping Address: </b></h4>";
	address += "Scheidt &amp; Bachmann<br>";
	address += "1001 Pawtucket Blvd.<br>";
	address += "Lowell, MA 01854";
	$('#print_address').html(address);
}