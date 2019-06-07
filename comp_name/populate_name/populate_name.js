$(document).ready(function() {
	var current_path = window.location.pathname.split('/').pop();
	//console.log(current_path);
	var options = '';
	var select = $('#company_name');
	$.ajax({
		type: 'GET',
		url: '../../comp_name/populate_name/populate_name.php',
		datatype: 'json',
		success: function(result) {
			result = JSON.parse(result);
			for(var i = 0; i < result.length; i++){
				if(result[i].perm_code == 3){
					//console.log("User_ID: " + result[i].user_id + " Name: " + result[i].company_name);
					options += '<option value="' + result[i].user_id + '">' + result[i].company_name + '</option>';
				}	
			}
			select.append(options);
	 	},
	 	error: function() {
	 		alert("Couldn't connect to the server... Please contact the admin or try again");
	 	}
	});	//ajax request ends
	$('#view_RMA_btn').on('click', function(){
		var company_id = $('#company_name').val();
		if(current_path == "admin_rma.php" || current_path == "by_rmacomp.php"){
			window.location = "../../common_files/admin_viewrma.php?user_id=" + company_id;
		}
		else if (current_path == "admin_addrma.php"){
			window.location = "../../common_files/new_rma.php?user_id=" + company_id;
		}
	});// view RMA button click function ends
});	//ready function ends