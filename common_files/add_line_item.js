$(document).ready(function() {
	var order = new Array();
	var error = new Array();
	var urlParams = new URLSearchParams(location.search);
	var user_id = urlParams.get('user_id');

	$('#add_li').on('click', function() {
		//if there is some error displaying, it should be hidden once the user clicks add item
		$('#error_display').hide();
		var new_line_item = '';
		var num_of_li = $('.accordion').children().length + 1;		//will return 0 children at first; that's why +1
		new_line_item += '<div class="accordion-group" id="li_parent_'+ num_of_li +'">';
		new_line_item += 	'<div class="accordion-heading">';
		new_line_item += 		'<a class="accordion-toggle" data-toggle="collapse" data-parent="#li_add_accordion" href="#collapse_'+ num_of_li +'">Line Item '+ num_of_li +'</a>';
		new_line_item +=	'</div>';
		new_line_item += 	'<div id="collapse_'+ num_of_li +'" class="accordion-body collapse">';
		new_line_item += 		'<div class="accordion-inner">';
		new_line_item += 			'<form name="line_item_form" class="li_form">';
		new_line_item +=				'<div class="row">';
		new_line_item +=					'<div class="form-group col-md-4"><label>Part Number</label><input class="form-control partNumber" id="liPart_'+ num_of_li +'" type="text" /></div>';
		new_line_item +=					'<div class="form-group col-md-4"><label>Serial Number</label><input class="form-control serialNumber" id="liSerial_'+ num_of_li +'" type="text"/></div>';
		new_line_item +=					'<div class="form-group col-md-4"><label>Device Type</label><input class="form-control" id="liDeviceType_'+ num_of_li +'" type="text" readonly></div>';
		new_line_item +=				'</div>';
		new_line_item +=				'<div class="row">';
		new_line_item +=					'<div class="form-group col-md-4"><label>Problem Description</label><textarea class="form-control" rows="5" name="problem_desc" id="liProbDesc_'+ num_of_li +'" placeholder="Enter the problem in detail.."></textarea></div>';
		new_line_item +=					'<div class="form-group col-md-4"><label>Service</label><select id="liService_'+ num_of_li +'" class="form-control"></select></div>';
		new_line_item +=				'</div>';
		new_line_item +=				'<div class="row">';
		new_line_item += 					'<div class="form-group col-md-4"><button style="float:left;" type="button" class="btn more button_delete" id="delete_'+ num_of_li +'">DELETE</button></div>';
		new_line_item += 					'<div class="form-group col-md-4"></div>';
		new_line_item += 					'<div class="form-group col-md-4"><button type="button" class="btn more button_add" id="addConfirm_'+ num_of_li +'">ADD</button></div>';
		new_line_item +=				'</div>';
		new_line_item +=			'</form>';
		new_line_item +=		'</div>';	//div class accordion inner ends
		new_line_item +=	'</div>'; //div class collapse ends
		new_line_item += '</div>';	// div class accordion group ends
		$('#li_add_accordion').append(new_line_item);
		populateService(user_id);		//function that will populate the service dropdown with AJAX
	});

	/*	******************************************************************************
		When the user enters the 7 digit part number, on removing the focus from the input label, 
		the the device name will be automatically updated based on the part number. 
		Not found will be printed if no device is found with the given number.

		****************************************************************************** */

	$('.accordion').on('keyup', '.partNumber', function() {
		var id = this.id;
		var split_id = id.split("_");
  		var index = split_id[1];
  		displayDevice(index, user_id);
	});

	/* ****************************************************************************** 
		Event handling for when the user enters the line item information and presses the add button.
		Gets the value for the current line item in order to grab the elements by their id's based on that value
		Creates the line item object by calling the getElementValues() function
		Pushes the object into an array if there are no validation errors. 

	   ****************************************************************************** */
	$('.accordion').on('click', '.button_add', function() {
		var id = this.id;
		var split_id = id.split("_");
  		var index = split_id[1];
  		var line_item = getElementValues(index, error);
  		//console.log(line_item);
  		var initial_num_of_li = order.length;
  		//Pushes the object into the array only if the validation is successful
  		if (error.length === 0) {
  			order.push(line_item);
  			//console.log(order);
  			printAddMessage(order, initial_num_of_li, index);
  		}
  		//reset the error array to 0
  		error.length = 0;
	});

	/*  *************************************************************************
		If the user decides to delete a line item for some reason, this function will delete the accordion
		as well as the line item object inside the array. The index of the array will be one less as 
		the array index starts from 0.
		To delete the object at that particular index in the array, splice the array starting from that index
		and give it the length of 1 to only delete that one item at that index

		************************************************************************* */

	$('.accordion').on('click', '.button_delete', function() {
		var id = this.id;
		var split_id = id.split("_");
  		var index = split_id[1];
  		if(index > 0){
  			order.splice(index-1, 1);
  			//console.log("After delete" + order);
  			$('#li_parent_' + index).remove();
  			//printDeleteMessage(order, initial_num_of_li, index);
  		}
	});

	// Event handler for the check button currently for debugging purposes. Functionality needs to be changed
	$('#check').on('click', function() { 
		if($('#li_add_accordion').children().length > 0 && order.length > 0){
			localStorage.setItem('order', JSON.stringify(order));
			window.location = "confirm_order.php?user_id=" + user_id;
		}
		else{
			$('#error_display').text("No Item Selected");
			errorShowHide();
		}
	});
});

//creating the constructor for a line item
function LineItem(part, serial, prob_desc, service, device) {
	this.part = part;
	this.serial = serial;
	this.prob_desc = prob_desc;
	this.service = service;
	this.device = device;
} 

/*	****************************************************************************** 

	This function will populate the drop down select options for 'Service' based on user's services that have been paid for.
	index	- get the index for the current list item that is being added
	user_id	- using the jquery urlParam object to get the search query of the URL to extract the user_id. 
			  This will be used to extract the correct service information in the database which corresponds to the current user.
	select 	- variable to store the id for select dropdown tag which shows the service 

	****************************************************************************** */
function populateService(user_id) {
	var index = $('.accordion').children().length;
	var options = '';
	var select = $('#liService_'+ index);
 	$.ajax({
 		type: "GET",
 		url: "get_service.php?user_id=" + user_id,
 		datatype: 'json',
 		success: function(result) {
 			result = JSON.parse(result);
 			for(var i = 0; i < result.length; i++){
 				console.log("ID -> "+ result[i].service_id +" Value => "+ result[i].service_name);
 				options += '<option value="'+ result[i].service_id +'">'+ result[i].service_name +'</option>';
 			}
 			select.append(options);
 		}
 	});
}

/*	******************************************************************************
	This function maps the entered part number to the device from the database and displays the device name.
	Gets the value entered by the user in the part number box, send this data as a GET parameter through AJAX and
	receives a JSON value. If no value returned, prints out not found under device type.

	****************************************************************************** */
function displayDevice(index, user_id) {
	var element = $('#liPart_'+ index);
	var part_num = element.val();
	if (part_num.length == 7) {
		$.ajax({
	 		type: "GET",
	 		url: "get_part_number.php?part_number=" + part_num ,
	 		datatype: 'json',
	 		success: function(result) {
	 			if(result){
	 				result = JSON.parse(result);
	 				$('#liDeviceType_' + index).val(result.device_name);
	 			}
	 			else{
	 				$('#liDeviceType_' + index).val("Item not in the list");			
	 			}
	 		}
		});
	}
	else if(part_num.length != 7){
		$('#liDeviceType_' + index).val("Not found");
	}
}

/*	******************************************************************************
	On pressing the add button, show the success message if added succesfully and then disable the button.
	****************************************************************************** */

function printAddMessage(order, initial_size, index){
  		if (order.length > initial_size) {	//checking if the object is successfully added in the array
  			var success_add_msg = '<h3 class="msg_success">Added Line Item ' + index + '</h3>';
  			$('#display_li_add').html(success_add_msg);
  			$('#addConfirm_' + index).prop('disabled', true);
  		}
}

/* ****************************************************************************** 
	This function stores the values entered by the user, validates them by calling validate functions and makes a new line item object.
	It then returns the object to the button_add click event handler function

   ******************************************************************************  */
function getElementValues(index, error) {
	var li_part = $('#liPart_'+ index).val();
	validatePart(li_part, index, error);
	var li_serial = $('#liSerial_'+ index).val();
	validateSerial(li_serial, index, error);
	var li_prob_desc = $('#liProbDesc_'+ index).val();
	var li_service = $('#liService_'+ index).val();
	var li_device = $('#liDeviceType_'+ index).val();
	//Creates the object only if the validation is successful
	if (error.length == 0){
  		var item = new LineItem(li_part, li_serial, li_prob_desc, li_service, li_device);
  		return item;
	}
}

function validatePart(el_value, index, error) {
	//if the field is empty
	if (el_value.length == 0) {
		error[0] = "Part Number cannot be empty";
		var element = $('#liPart_'+ index);
		$('#error_display').text(error[0]);
		errorShowHide();
		input_box_error(element);
	}
	//if the user inputs invalid part number
	else if (el_value.length != 7){
		error[1] = "Invalid Part Number";
		var element = $('#liPart_'+ index);
		$('#error_display').text(error[1]);
		errorShowHide();
		input_box_error(element);
	}
}

function validateSerial(el_value, index, error){
	//if the user inputs invalid serial number
	if (el_value.length > 10){
		error[2] = "Invalid Serial Number";
		var element = $('#liSerial_'+ index);
		$('#error_display').text(error[2]);
		errorShowHide();
		input_box_error(element);
	}
}

function errorShowHide(){
		$('#error_display').show();
		setTimeout(function() {
			$('#error_display').hide();
		}, 3000);
}

function input_box_error(element){
	element.addClass("error_input_bg");
	element.val("");
	setTimeout(function() {
			element.removeClass("error_input_bg");
		}, 3000);
}


//Remove the error class and keep it removed once the user clicks on the error element
//Display the error text and then remove it as soon as the user clicks anywhere in the form
//Prevent adding the same object when the user presses add multiple times

