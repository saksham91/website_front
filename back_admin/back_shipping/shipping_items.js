$(document).ready(function(){
	$('.datepicker').datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		maxDate: 1
	});    //end of datepicker
	$('#ship_items').click(function(){
    	var date_ship = $('#select_date').val();
    	console.log(date_ship);
    	if(date_ship === ''){
    		alert("Enter the date");
    	}
    	else{
    		$.ajax({
                type: 'GET',
                url: 'list_repair_done.php?date=' + date_ship,
                datatype: 'json',
                success: function(result){
                    result = JSON.parse(result);
                    console.log(result);
                    if(result.length < 1){
                        $('#list_ship_table').hide();
                        alert("No item for shipping for " + date_ship);
                    }
                    else{
                        $('#list_ship_table').show();
                        var print_row = '';
                        for(var i = 0; i < result.length; i++){
                            print_row += '<tr>';
                            print_row += '<td>'+ result[i].RMA_number +'</td>';
                            print_row += '<td>'+ result[i].li_id +'</td>';
                            print_row += '<td>'+ result[i].device_number +'</td>';
                            print_row += '<td>'+ result[i].serial_number +'</td>';
                            print_row += '<td>'+ result[i].date_arrived +'</td>';
                            print_row += '<td><button type="button" class="btn btn-outline-dark view_li" id="'+ result[i].li_id +'">View</button></td>';
                            print_row += '<td><label class="ch_design"><input type="checkbox" class="change_status" id="'+ result[i].li_id +'" value="'+ result[i].li_id +'"><span class="checkmark"></span></label></td>';
                            print_row += '</tr>';
                        }
                        $('#print_ship_row').html(print_row);
                    }
                },
                error: function(result){
                    alert(result.message);
                }
            }); //end of ajax call clicking the view shipping items button
    	}
	});    //end of click function for list items

    $('#change_multi_status').click(function(){
        var all_li = check_selected_li();
        if(all_li.length < 1){
            alert("No Line Item selected to change the status. Please select at least one..");
        }
        else{
            console.log("Selected Li -> " + all_li);
            $('#spinner_gif').show();
            $.ajax({
                type: 'POST',
                url: 'update_ship_status.php',
                data: {shipping_items: all_li},
                datatype: 'json',
                success: function(result){
                    display_success(true);
                    //result = JSON.parse(result);
                    console.log(result);
                },
                error: function(result){
                    display_success(false);
                }
            }); //end of ajax call after clicking the change status button
        }
    }); //end of change status function

    $('#print_ship_row').on('click', '.view_li', function(){
        var li = this.id;
        console.log(li);
        window.location = 'print_shipping_li.php?li=' + li;
    }); //end of view shipping id details function
}); //end of doc_ready function

function check_selected_li(){
    var arr = $('.change_status:checked').map(function(){
        return this.value;
    }).get();
    return arr; 
}

function display_success(msg){
    if (msg === true){
        $('#spinner_gif').hide();
        $('.error_success').html('<i class="fa fa-check-circle fa-4x" aria-hidden="true" style="color: green;"></i>');
        $('.error_success').show();
        setTimeout(function() { 
        $('.error_success').hide(); }, 2000);
    }
    else{
        $('#spinner_gif').hide();
        $('.error_success').html('<i class="fa fa-times-circle fa-4x" aria-hidden="true" style="color: red;"></i>');
        $('.error_success').show();
        setTimeout(function() { 
        $('.error_success').hide(); }, 2000);
    }
}