$(document).ready(function(){
	// Get the modal
	var modal = document.getElementById('myModal');

	// When the user clicks the button, open the modal 
	$('#add_device').on('click', function() {
	    //modal.style.display = "block";
	    $('.modal').fadeIn(500);
	});

	$('#modal_btn1').on('click', function(){
		var device_name = $('#dev_name').val();
		var device_number = $('#dev_number').val();
		var valid = true;
		valid = valid && checkText(device_name, device_number);
		if(valid){
			console.log("Valid...");
			$.ajax({
				type: 'POST',
				url: 'add_device.php',
				data: {dname: device_name, dnum: device_number},
				datatype: 'json',
				success: function(result){
					$('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
		        	$('.error_success').show();
					setTimeout(function() { 
					$('.error_success').hide(); }, 2000);
	    			$('#modal_btn2').click();
				},
				error: function(result){
			        //console.log(result);
			        alert("Request failed: " + result.responseJSON.message);
			        $('.error_success').html('<i class="fa fa-times-circle fa-4x" aria-hidden="true" style="color: red;"></i>');
		        	$('.error_success').show();
					setTimeout(function() { 
					$('.error_success').hide(); }, 2000);			
				}
			});
		}
		else{
			console.log("Invalid");
		}
	    removeText();
	});


	$('#modal_btn2').on('click', function(){
		//modal.style.display = "none";
		$('.modal').fadeOut(500);
	    removeText();
	});

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        // modal.style.display = "none";
	        $('.modal').fadeOut(500);
	        removeText();
	    }
	}
})

function checkText(dname, dnum){
	if(dname.length === 0 || dnum.length === 0){
		alert("Fields cannot be empty!");
		return false;
	}
	else if(dnum.length !== 7){
		alert ("Device number should be 7 digits long..");
		return false;
	}
	else{
		return true;
	}
}

function removeText(){
	$('#dev_name').val('');
	$('#dev_number').val('');
}