<?php
	$dname = basename(dirname(__DIR__));
	if($_SESSION['staffuser']['role']!=$dname){
	 header('location:../login.php');
	}
	$staffid = $_SESSION['staffuser']['userid'];
	$stR = $db->query("SELECT staffid, name FROM staff WHERE staffid='$staffid'");
	$st = mysqli_fetch_assoc($stR);
?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Gretsa University - HR</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
			<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?=$st['staffid'];?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<h6 class="dropdown-item disabled"><?=$st['name'];?> </h6>
						<a class="dropdown-item" href="change.php">Change Password</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
          </ul>
        </div>
      </div>
    </nav>