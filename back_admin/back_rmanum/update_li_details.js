$(document).ready(function(){
	var line_item = $('#li_id').val();
	$('.datepicker').datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		maxDate: 0
	});
	var num_children = $('#replacement_info').children().length; 

	//when the page opens, check for the status value. If status = 'HOLD', hide the 'not_hold' class elements and show the 'on_hold' elements
	if($('#status').val() == 6){
		$('.not_hold').hide();
		$('.on_hold').show();
	}

	//will show different set of input elements if status is 'HOLD'
	$('#status').on('change', function() {
		if ($(this).val() == 6){
			$('.not_hold').hide();
			$('.on_hold').show();
		}
		else{
			$('.on_hold').hide();
			$('.not_hold').show();
		}
	});

	$('#part_num').on('keyup', function(){
		var part_num = $('#part_num').val();
		if (part_num.length == 7) {
			$.ajax({
		 		type: "GET",
		 		url: "../../common_files/get_part_number.php?part_number=" + part_num ,
		 		datatype: 'json',
		 		success: function(result) {
		 			if(result){
		 				result = JSON.parse(result);
		 				$('#device_name').val(result.device_name);
		 			}
		 			else{
		 				$('#device_name').val("Item not in the list");			
		 			}
		 		}
			});
		}
		else if(part_num.length != 7){
			$('#device_name').val("Not found");
		}
	});	//end of part_num on_keyup function

	$('#update_li').on('click', function(){
		var status = $('#status').val();
		if(status != 6){
			var part = $('#part_num').val();
			var serial = $('#serial_num').val();
			var tech = $('#select_tech').val();
			var prob = $('#prob_found').val();
			var repair = $('#repair').val();
			var date1 = $('#date_arrived').val();
			var date2 = $('#date_closed').val();
			var labor = $('#labor_time').val();
			var note = $('#extra_note').val();
			var update_info = new Array(part, serial, tech, prob, repair, status, date1, date2, labor, note);
			//console.log(update_info);
			var misc = update_misc();
			var component = update_component(num_children);
			//console.log(component);
			//console.log(misc);
			$.ajax({
				type: 'POST',
				url: 'update_li_details.php',
				data: {line_item: line_item, info: update_info, misc: misc, component: component},
				datatype: 'json',
				success: function(result){
					//console.log(result);
					display_confirmation('success');
				},
				error: function(jqXHR, textStatus){
					alert("Request Failed: " + textStatus);
					display_confirmation('fail');
				}
			});	//end of ajax call for non-HOLD status update
		}
		else if(status == 6){
			var po_no = $('#po_no').val();
			var eta = $('#eta').val();
			var dmr = $('#dmr').val();
			var missing = $('#missing').val();
			var hold_note = $('#hold_note').val();
			var day = get_date();
			var tech = $('#select_tech').val();
			//console.log("Tech name -> " + tech);
			var date1 = $('#date_arrived').val();
			//console.log("Arrived -> " + date1);
			$.ajax({
				type: 'POST',
				url: 'update_li_details.php',
				data: {line_item: line_item, status: status, po_no: po_no, eta: eta, dmr: dmr, miss: missing, hnote: hold_note, day: day, tech: tech, arrived: date1},
				datatype: 'json',
				success: function(result){
					//console.log(result);
					display_confirmation('success');
				},
				error: function(result){
					alert(result.message);
					display_confirmation('fail');
				}
			});	//end of ajax call for HOLD update
		}
	});	// end of update_li click event function
});

//check for the values of the checkboxes which have been checked and puts them into an array. 
//These values range from 1-5 and correlate to the misc_id's in the misc repair table. Misc_repair means function test, cleaning done, 3rd party repair.....
function update_misc(){
	var arr = $('.misc_check:checked').map(function(){
        return this.value;
    }).get();
    return arr;
}

function Component(part, serial_r, serial_i){
	this.part_removed = part;
	this.serial_removed = serial_r;
	this.serial_installed = serial_i;
}

function update_component(children){
	var rem_part, rem_serial, inst_serial;
	var arr = new Array();
	for (var i = 1; i <= children; i++){
		rem_part = checkVal($('#rem_part'+i).val());
		//console.log(rem_part);
		rem_serial = checkVal($('#rem_serial'+i).val());
		inst_serial = checkVal($('#inst_serial'+i).val());
		var obj = new Component(rem_part, rem_serial, inst_serial);
		arr.push(obj);
	}
	return arr;
}

function checkVal(numb){
	if(numb.length === 0){
		return 'NA';
	}
	else{
		return numb;
	}
}

function get_date(){
	var today = new Date();
	var d = today.getDate();
	var m = today.getMonth() + 1;
	var y = today.getFullYear();
	return (y + '-' + m + '-' + d);
}

function display_confirmation(message){
	if(message == 'success'){
		$('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
    	$('.error_success').show();
		setTimeout(function() { 
		$('.error_success').hide(); }, 2000);
	}
	else{
		$('.error_success').html('<p style="color: red;">Invalid Value.. <i class="fa fa-times-circle fa-4x" aria-hidden="true"></i></p>');
    	$('.error_success').show();
		setTimeout(function() { 
		$('.error_success').hide(); }, 2000);
	}
}