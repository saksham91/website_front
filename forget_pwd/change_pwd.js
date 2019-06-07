$(document).ready(function(){
	//Regex for: At least 1 digit, at least one lowercase alphabet, at least one uppercase alphabet and minimum length of 6
	var reg = new RegExp(/(?=^.{6,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*()]*$/);
	$('#fpwd_confirm').on('click', function(){
		var user = $('#user_confirm');
		var new_pwd = $('#new_password');
		var confirm_pwd = $('#confirm_password');
		var user_error = $('#user_error');
		var new_pwd_error = $('#new_pwd_error');
		var confirm_pwd_error = $('#pwd_confirm_error');
		//If any of the inputs are empty
		if(user.val().length === 0){
			var msg = "This field cannot be empty";
			display_empty_error(user, user_error, msg);
		}
		else if(new_pwd.val().length === 0){
			var msg = "This field cannot be empty";
			display_empty_error(new_pwd, new_pwd_error, msg);
		}
		else if(confirm_pwd.val().length === 0){
			var msg = "This field cannot be empty";
			display_empty_error(confirm_pwd, confirm_pwd_error, msg);
		}
		//If the password doesn't match the pattern
		else if(!reg.test(new_pwd.val())){

			var msg = "Wrong format. Please type the password again";
			display_empty_error(new_pwd, new_pwd_error, msg);
		}
		//If the password entered and confirm passwords do not match
		else if(new_pwd.val() != confirm_pwd.val()){
			var msg = "Passwords don't match. Please type the password(s) again.";
			display_empty_error(confirm_pwd, confirm_pwd_error, msg);
		}
		//finally, if there's no error, send the username to the database to check if it exists
		//If it doesn't display another error (A GET request to the DB)
		//If the username exists, replace the current password using PHP's hashpassword. (A PUT request to the DB)
		//Display a success message or svg
		else{
			var uname = user.val();
			var pwd = new_pwd.val();
			$.ajax({
				type: "POST",
				url: "change_pwd.php",
				data: {name: uname, pass: pwd},
				datatype: 'json',
				success: function(result){
					result = JSON.parse(result);
					if(result.failure_message){
						display_confirmation(result.failure_message);
					}
					else{
						display_confirmation('success');
					}
				},
				error: function(result){
					alert("Could not connect to the database..");
				}
			});	//end of ajax call
		}
	});	//end of on click function
	$(document).keypress(function(event){
	    var keycode = (event.keyCode ? event.keyCode : event.which);
	    if(keycode == '13'){
	        $('#fpwd_confirm').click();   
	    }
	});
});

//Takes in the element, the error div of respective element and a text message
function display_empty_error(el, error_p, msg){
	error_p.text(msg);
	error_p.show();
	el.val("");
	el.addClass("error_input_bg");
	setTimeout(function() {
		error_p.hide();
		el.removeClass("error_input_bg");
	}, 3000); 
}

function display_confirmation(message){
	if(message == 'success'){
		$('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
    	$('.error_success').show();
		setTimeout(function() { 
		$('.error_success').hide(); }, 2000);
	}
	else{
		$('.error_success').html('<p style="color: red;">' + message + '<i class="fa fa-times-circle fa-4x" aria-hidden="true"></i></p>');
    	$('.error_success').show();
		setTimeout(function() { 
		$('.error_success').hide(); }, 2000);
	}
}