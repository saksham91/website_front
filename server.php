<?php

	try{
		$dbh = new PDO('mysql:host=localhost;dbname=RMADB', 'user', 'pass123');
	  }
	  catch (PDOException $e) {
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	  }

?>