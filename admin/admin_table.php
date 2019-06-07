<?php
	session_start();
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../server.php";
	include "../header.php";
 ?>

 <!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" media="all">
	<link rel="stylesheet" type="text/css" href="../css/sb-styles.css" media="all">
 	<title>Scheidt & Bachmann</title>
 	<meta property="og:type" content="website" />
	<meta property="og:title" content="Scheidt &amp; Bachmann" />
	<meta property="og:url" content="https://www.scheidt-bachmann.de/en/" />
	<meta property="og:site_name" content="Scheidt &amp; Bachmann" />
	<meta property="og:image" content="img/sblogo.png" />
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:title" content="Scheidt &amp; Bachmann" />
	<meta name="twitter:creator" content="@ScheidtBachmann" />
	<meta property="twitter:image" content="img/sblogo.png" />
	<meta name="msapplication-square70x70logo" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon.png">
	<link rel="icon" sizes="192x192" href="img/apple-touch-icon.png">
	<link rel="icon" sizes="128x128" href="img/apple-touch-icon.png">
	<script src="../js/jquery.min.js"></script> 
 </head>
 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div style="height: 80px;">
					<!-- Custom styling of the input box in css file. Hover over id=myInput -->
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for company name..">
				</div>
			</div>
			<div class="container">
			<div class="content">	
				<div id="user_table">
					<table class="table table-hover" id="myTable">
						<thead class="thead-light" >
						<tr>
						    <th>User_ID</th>
						    <th>Company Name</th>
						    <th>Username</th>
						    <th>Email</th>
						    <th>Phone</th>
					    </tr>
					    </thead>
					    <tbody>
					<?php
						$sql = "SELECT * FROM users WHERE perm_code = 3";
						$stmt = $dbh->prepare($sql);
						$stmt->execute();
						
						//display the database user table
						while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
					 		<tr>
					 			<td><?php echo $row['user_id'] ?></td>
					 			<td><?php echo $row['company_name'] ?></td>
					 			<td><?php echo $row['username'] ?></td>
					 			<td><?php echo $row['email'] ?></td>
					 			<td><?php echo $row['phone'] ?></td>
					 		</tr>
						<?php } ?>
						</tbody>
					</table>
					<script>
						function myFunction() {
						  // Declare variables 
						  var input, filter, table, tr, td, i;
						  input = document.getElementById("myInput");
						  filter = input.value.toUpperCase();
						  table = document.getElementById("myTable");
						  tr = table.getElementsByTagName("tr");

						  // Loop through all table rows, and hide those who don't match the search query
						  for (i = 0; i < tr.length; i++) {
						    td = tr[i].getElementsByTagName("td")[1];
						    if (td) {
						      if (td.innerHTML.toUpperCase().indexOf(filter) == 0) {
						        tr[i].style.display = "";
						      } else {
						        tr[i].style.display = "none";
						      }
						    } 
						  }
						}
					</script>
				</div>
		 	</div>
		 </div>
		 	<div class="container">
		 		<button type="submit" class="more-dark btn more-back" onclick="window.location.href = 'admin_page.php';">Back</button><br>
		 	</div>
		</main>
	</div> 
	<script src="../js/modernizr.custom.js"></script> 
	<script src="../js/classie.js"></script>
	<script src="../js/tether.js"></script>
 </body>
 </html>