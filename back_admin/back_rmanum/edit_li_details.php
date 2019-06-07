<?php 
	session_start();
	if(!isset($_SESSION['account'])){
		die("You need to login to view this page");
	}
	require_once "../../server.php";
	include "../back_admin_header.php";

	$role = $_SESSION['user_role'];
	
	if(isset($_GET['li'])){
		$li = $_GET['li'];
		$misc_id = array();
		//Getting all the details for the particular line_item
		$sql = "SELECT * FROM line_item, device, service WHERE li_id = :li AND device.part_number = line_item.device_number AND service.service_id = line_item.service ";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':li' => $li));
		$row = $stmt->fetch();

		$serial = $row['serial_number'];
		$dnumber = $row['device_number'];
		$device = $row['device_name'];
		$service = $row['service_name'];
		$prob = $row['prob_found'];
		$repair = $row['repair_done'];
		$technician = $row['technician'];
		$status = $row['status'];
		$date1 = $row['date_arrived'];
		$date2 = $row['date_closed'];
		$labor = $row['labor_hrs'];
		$note = $row['note'];

		//checking to see if the line_item has got some previously checked misc_repair info. 
		//If it has, populate an array {$misc_id} to do the checking in the html part below.
		$sql = "SELECT misc_id FROM li_misc WHERE li_id = :li";
		$stmt = $dbh->prepare($sql);
		$stmt->execute(array(':li' => $li));
		while($row = $stmt->fetch()){
			array_push($misc_id, $row['misc_id']);
		}

		$hold_note = $po_num = $eta = $dmr = $date = $missing = '';

		//checking the Hold table for the current Line Item and getting the info if the item is currently on hold or ever was
		$sql2 = "SELECT note, PO_NO, ETA, dmr, date_hold, missing_part FROM hold WHERE li_id = :li";
		$stmt2 = $dbh->prepare($sql2);
		$stmt2->execute(array(':li' => $li));
		if($row2 = $stmt2->fetch()){
			$hold_note = $row2['note'];
			$po_num = $row2['PO_NO'];
			$eta = $row2['ETA'];
			$dmr = $row2['dmr'];
			$date = $row2['date_hold'];
			$missing = $row2['missing_part'];
		}
	}

?>

<!DOCTYPE html>
 <html>
 <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon">
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
	<script src="update_li_details.js"></script>
 </head>

 <body>
 	<div class="mp-pusher" id="mp-pusher">
		<div class="stage"> </div>
		<main class="main" >
			<div class="container">
				<div class="content">  
					<div class="form-row">
					    <div class="form-group col-md-4">
						    <label for="li_id"><b>Line Item</b></label>
						    <input type="text" class="form-control" id="li_id" value="<?php echo $li; ?>" required readonly>
					    </div>
					    <div class="form-group col-md-4">
						    <label for="device_name"><b>Device Name</b></label>
						    <input type="text" class="form-control" id="device_name" value="<?php echo $device; ?>" required readonly>
					    </div>
					    <div class="form-group col-md-4">
					    	<label for="serv_name"><b>Service</b></label>
					    	<input type="text" class="form-control" id="serv_name" value="<?php echo $service; ?>" required readonly> 
					    </div>
					</div>    
					<div class="form-row">
					    <div class="form-group col-md-4">
					    <?php 
					    	if($role == 2){ ?>
					    	<label for="serial_num"><b>Serial Number</b></label>
						    <input type="text" class="form-control" id="serial_num" value="<?php echo $serial; ?>"> 
					    <?php }
					    	else{	?>
					    	<label for="serial_num"><b>Serial Number</b></label>
						    <input type="text" class="form-control" id="serial_num" value="<?php echo $serial; ?>" readonly> 
					    <?php }
					    ?> 
					    </div>
					    <div class="form-group col-md-4">
					    <?php 
					    	if($role == 2){ ?>
						    <label for="part_num"><b>Part Number</b></label>
						    <input type="text" class="form-control" id="part_num" value="<?php echo $dnumber; ?>">
						<?php }
							else{	?>
							<label for="part_num"><b>Part Number</b></label>
						    <input type="text" class="form-control" id="part_num" value="<?php echo $dnumber; ?>" readonly>
						<?php	}
						?>
					    </div>
					    <div class="form-group col-md-4">  
						    <label for="select_tech"><b>Choose Technician</b></label> 
					    	<select id="select_tech" class="form-control">
					    		<option value="">Select Technician..</option>
					    		<?php 
					    			$stmt = $dbh->query("SELECT tech_id, tech_name FROM technician");
					    			while($row = $stmt->fetch()){
					    				if($row['tech_id'] === $technician){
					    					echo '<option value="'.$row['tech_id'].'" selected="selected">'.$row['tech_name'].'</option>';
					    				}
					    				else{
					    					echo '<option value="'.$row['tech_id'].'">'.$row['tech_name'].'</option>';
					    				}
					    			}
					    		?>
					    	</select>
					    </div>
					</div>
					<div class="form-row">
					    <div class="form-group col-md-4 not_hold">
						    <label for="prob_found"><b>Problem Found</b></label>
						    <textarea class="form-control" id="prob_found" rows="4"><?php echo $prob; ?></textarea>
					    </div>
					    <div class="form-group col-md-4 not_hold">  
						    <label for="repair"><b>Repair Narrative</b></label>
						    <textarea class="form-control" id="repair" rows="4"><?php echo $repair; ?></textarea>
					    </div>
					    <div class="form-group col-md-4">  
						    <label for="status"><b>Select Status</b></label> 
					    	<select id="status" class="form-control">
					    		<?php 
					    			$stmt = $dbh->query("SELECT status_id, status_name FROM status");
					    			while($row = $stmt->fetch()){
					    				if($row['status_id'] === $status){
					    					echo '<option value="'.$row['status_id'].'" selected="selected">'.$row['status_name'].'</option>';
					    				}
					    				else{
					    					echo '<option value="'.$row['status_id'].'">'.$row['status_name'].'</option>';
					    				}
					    			}
					    		?>
					    	</select>
					    </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<?php 
								if ($date1 == '0000-00-00'){
									$date1 = '-';
								}
							?>
						  	<label for="date_arrived"><b>Date Arrived</b></label>
						  	<input type="text" class="form-control datepicker" id="date_arrived" onfocus="this.value=''" style="padding: 5px;" value="<?php echo $date1; ?>">
						</div>
						<div class="form-group col-md-4 not_hold">
							<?php 
								if ($date2 == '0000-00-00'){
									$date2 = '-';
								}
							?>
						    <label for="date_closed"><b>Date Closed</b></label>
						    <input type="text" class="form-control datepicker" id="date_closed" onfocus="this.value=''" style="padding: 5px;" value="<?php echo $date2; ?>">
						</div>
						<div class="form-group col-md-4 not_hold">
						    <label for="labor_time"><b>Labor Time</b></label>
						    <input type="text" class="form-control" id="labor_time" style="padding: 5px;" value="<?php echo $labor; ?>">
						</div>
					</div>
					<div class="misc_problems not_hold" style="margin-top: 20px;">
						<div style="width: 25%; display: inline-block;">
							<!-- Checking the array {$misc_id} with misc_id values. If the array has the id value, display the checkbox as checked.
								Otherwise display it normally. 
								$misc_id is an array populated in the php part at the top. -->
							<?php
								$sql = "SELECT misc_id, repair FROM misc_repair";
								$stmt = $dbh->prepare($sql);
								$stmt->execute();
								while($row = $stmt->fetch()){
									if(in_array($row['misc_id'], $misc_id)){ ?>
										<label class="ch_design"><b><?php echo $row['repair']; ?></b>
						    			<input class="misc_check" type="checkbox" value="<?php echo $row['misc_id']; ?>" checked="checked"><span class="checkmark"></span></label>
							   <?php }
							    	else{	?>
							    		<label class="ch_design"><b><?php echo $row['repair']; ?></b>
						    			<input class="misc_check" type="checkbox" value="<?php echo $row['misc_id']; ?>"><span class="checkmark"></span></label>
							    <?php } 
								}
							?>
						</div>
						<div style="width:66%; float:right; display: inline-block;">
							<label for="extra_note"><b>Note: </b></label>
							<textarea class="form-control" id="extra_note" rows="4"><?php echo $note; ?></textarea>
						</div>
					</div>
					<!-- 
						Checking the database if there's component information already available about this line item. 
						If there is, show the information and show only that amount of textboxes for which the info is there. [e.g. - If ony 1 part was removed and installed, only show one row of information as opposed to the default of three rows.]
						If no info is there previously (entering information about the Line Item for the first time or the item has not been repaired), display three rows of empty textboxes to enter the details.
					-->
					<div class="not_hold" id="replacement_info" style="margin-top: 20px;">
						<?php
						$i = 1; 
						$sql = "SELECT remove_p1, remove_s1, install_s1 FROM component_info WHERE li_id = :li";
						$stmt = $dbh->prepare($sql);
						$stmt->execute(array(':li' => $li));
						//Information found in the database
						if($row = $stmt->fetch()){
							do{	?>
								<div class="form-row">
								<div class="form-group col-md-4">
									<label><b>Removed Part #<?php echo $i ?></b></label>
								    <input type="text" class="form-control" id="rem_part<?php echo $i ?>" style="padding: 5px;" value="<?php echo $row['remove_p1'] ?>">
								</div>
								<div class="form-group col-md-4">
									<label><b>Removed Serial #<?php echo $i?></b></label>
								    <input type="text" class="form-control" id="rem_serial<?php echo $i ?>" style="padding: 5px;" value="<?php echo $row['remove_s1']?>">
								</div>
								<div class="form-group col-md-4">
									<label><b>Installed Serial #<?php echo $i ?></b></label>
								    <input type="text" class="form-control" id="inst_serial<?php echo $i ?>" style="padding: 5px;" value="<?php echo $row['install_s1']?>">
								</div>
							</div>
						<?php	
							$i++;
							} while($row = $stmt->fetch()); 
						} 
						//Information not found in the database
						else{	
							for($i = 1; $i <=3; $i++) {?>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label><b>Removed Part #<?php echo $i?></b></label>
								    <input type="text" class="form-control" id="rem_part<?php echo $i?>" style="padding: 5px;">
								</div>
								<div class="form-group col-md-4">
									<label><b>Removed Serial #<?php echo $i?></b></label>
								    <input type="text" class="form-control" id="rem_serial<?php echo $i?>" style="padding: 5px;">
								</div>
								<div class="form-group col-md-4">
									<label><b>Installed Serial #<?php echo $i?></b></label>
								    <input type="text" class="form-control" id="inst_serial<?php echo $i?>" style="padding: 5px;">
								</div>
							</div>
						<?php  }
						}
						?>
					</div>
					<!-- Elements to be shown when the status is 'HOLD'. -->
					<div class="on_hold" style="display:none;">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="po_no"><b>PO NO:</b></label>
								<input type="text" class="form-control" id="po_no" style="padding: 5px;" value="<?php echo $po_num; ?>">
							</div>
							<div class="form-group col-md-6">
								<label for="eta"><b>ETA:</b></label>
								<input type="text" class="form-control" id="eta" style="padding: 5px;" value="<?php echo $eta; ?>">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="dmr"><b>DMR No:</b></label>
								<input type="text" class="form-control" id="dmr" style="padding: 5px;" value="<?php echo $dmr; ?>">	
							</div>
							<div class="form-group col-md-6">
								<label for="missing"><b>Missing Part:</b></label>
								<input type="text" class="form-control" id="missing" style="padding: 5px;" value="<?php echo $missing; ?>">	
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-3"></div>
							<div class="form-group col-md-6">
								<label for="hold_note"><b>Note:</b></label>
								<textarea class="form-control" rows="4" id="hold_note"><?php echo $hold_note; ?></textarea>
							</div>
							<div class="form-group col-md-3"></div>
						</div>
					</div>
				</div>
			</div>		
		 	<div class="container noprint">
		 		<button type="button" class="more-dark btn" onclick="window.print()" style="float: right; margin-left: 40px;">Print</button>
				<span class="error_success" style="display: none; float: right;"></span>
		 		<button type="button" class="more-dark btn" id="update_li">Update</button><br>
		 		<?php 
					if($role == 2){ ?>
		 				<button type="submit" class="more-dark btn more-back" onclick="window.location.href = 'by_rmanum.php?r=2';">Back</button><br>
		 		<?php }
		 			else if($role == 4){ ?>
		 				<button type="submit" class="more-dark btn more-back" onclick="window.location.href = 'by_rmanum.php?r=4';">Back</button><br>
		 		<?php	} 
		 		?>
		 	</div>
		</main>
	</div> 
 </body>
 </html>

