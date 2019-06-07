<?php 
	require_once "../../server.php";
	session_start();
	
	if(!isset($_SESSION['account']) || $_SESSION['user_role'] != 2){
		die("You need to login to view this page");
	}

	include "../back_admin_header.php";

?>

<!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="../../css/sb-styles.css" media="all">
	<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css" media="all">
 	<title>Scheidt & Bachmann</title>
 	<meta property="og:type" content="website" />
	<meta property="og:title" content="Scheidt &amp; Bachmann" />
	<meta property="og:url" content="https://www.scheidt-bachmann.de/en/" />
	<meta property="og:site_name" content="Scheidt &amp; Bachmann" />
	<meta property="og:image" content="../../img/sblogo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
	<meta name="twitter:creator" content="@ScheidtBachmann" />
	<meta property="twitter:image" content="../../img/sblogo.png" />
	<meta name="msapplication-square70x70logo" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../../img/apple-touch-icon.png">
	<link rel="icon" sizes="192x192" href="../../img/apple-touch-icon.png">
	<link rel="icon" sizes="128x128" href="../../img/apple-touch-icon.png">
	<script src="../../js/jquery.min.js"></script>
	<script src="../../js/modernizr.custom.js"></script> 
	<script src="../../js/classie.js"></script>
	<script src="../../js/tether.js"></script>
	<script src="../../js/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function(){
    		$('.datepicker').datepicker({
    			dateFormat: "yy-mm-dd",
    			changeMonth: true,
    			changeYear: true,
    			maxDate: 1
    		});
	  		$('#view_RMA_btn').click(function(){
    			var date_from = $('#date_from').val();
    			console.log(date_from);
    			var date_to = $('#date_to').val();
    			console.log(date_to);
    			if(date_to < date_from || date_to === '' ){
    				date_to = date_from;
    			}
    			if(date_from === ''){
    				alert("Enter the first date");
    				window.location = "by_rmadate.php";
    			}
    			else{
    				window.location = "view_rmalist.php?d1=" + date_from + "&d2=" + date_to;
    			}
	  		});
  		});

  	</script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div class="content">
					<div class="form-row align-items-center">
					    <div class="form-group col-md-3">
					    	<p><b>From: </b><input type="text" class="form-control datepicker" id="date_from" onfocus="this.value=''" style="padding: 5px;" required></p>
					    </div>
					    <div class="form-group col-md-3">
					    	<p><b>To: </b><input type="text" class="form-control datepicker" id="date_to" onfocus="this.value=''" style="padding: 5px;"></p>
					    </div>
				  	</div>
				  	<button type="button" class="btn more-dark" id="view_RMA_btn">View RMA</button>
			 	</div>
			</div>	
		</main>
	</div> 
 </body>
 </html>

