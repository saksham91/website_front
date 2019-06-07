$(document).ready(function(){
	$('#internal_submit').on('click', function(){
		var user_role = $('#user_role').val();
		var company = $('#comp_name').val();
		var username = $('#username').val();
		var phone = $('#input_phone').val();
		var password = $('#input_password').val();
		var password_confirm = $('#input_password_confirm').val();
		var authenticity = authenticate_fields(company, username, password, password_confirm);
		if(authenticity === true){
			$.ajax({
				type: 'POST',
				url: 'register_verify.php',
				data: {role: user_role, comp: company, uname: username, phone: phone, pwd: password, pwd_confirm: password_confirm},
				datatype: 'json',
				success: function(result){
					result = JSON.parse(result);
					console.log(result);
					if (result.success){
						$('.error_success').html('<p style="color:green;"><b>'+ result.success +'</b></p>');
			        	$('.error_success').show();
						setTimeout(function() { 
						$('.error_success').hide(); }, 2000);
					}
					else{
						$('.error_success').html('<p style="color:red;"><b>'+ result.error +'</b></p>');
			        	$('.error_success').show();
						setTimeout(function() { 
						$('.error_success').hide(); }, 2000);
					}
				},
				error: function(result){

				}
			})
		}
	});
});

function authenticate_fields(company, username, password, password_confirm){
	var msg = '';
	if(username == "" || company == "" || password == "" || password_confirm == ""){
		msg = "Fields cannot be empty..";
		display_error(msg);
		return false;
	}
	else if(password.length != password_confirm.length){
		msg = "Passwords differ... Please enter again";
		display_error(msg);
		return false;
	}
	return true;
}

function display_error(msg){
	$('.error_success').html('<p style="color: red;"><b>'+ msg +'</b></p>');
	$('.error_success').show();
	setTimeout(function() { 
	$('.error_success').hide(); }, 2000);
}