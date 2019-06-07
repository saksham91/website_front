<?php 
  $role = $_SESSION['user_role'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Scheidt & Bachmann</title>
</head>
<body>
<header class="header noprint">
    <div class="topbar">
      <div class="container"> </div>
    </div>
    <div class="container"> 
    	<span class="logo"><a href="javascript:void(0)" title="Scheidt &amp; Bachmann">Scheidt &amp; Bachmann</a></span>
    	<nav class="main-nav d-none d-xl-block ">
        <ul>
          <?php if($role == 2) {  ?>
                    <li><a href="../back_admin_home.php?r=2">Home</a></li>
          <?php    }
                else if($role == 4) { ?>
                    <li><a href="../back_admin_tech.php?r=4">Home</a></li>
          <?php    }
                else if($role == 5) { ?>
                    <li><a href="../back_admin_receiving.php?r=5">Home</a></li>
          <?php    }
          ?>
          <li><a href="../../logout.php">Log out</a></li>
        </ul>
      </nav>
      <i id="trigger-menu" class="fa fa-bars menu-trigger d-xl-none"></i>
    </div>
  </header>
</body>
</html>