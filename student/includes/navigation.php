<?php
	if (!isset($_SESSION["studentid"])) {
		header("location: login.php"); 
		exit();
	}
	$studentid = $_SESSION["studentid"];
	
	$sR = $db->query("SELECT studentnumber, name FROM student WHERE studentid='$studentid'");
	$s = mysqli_fetch_assoc($sR);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
        <a class="navbar-brand" href="index.php">Gretsa University - Student</a>
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
						<?=$s['studentnumber'];?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<h6 class="dropdown-item disabled"><?=$s['name'];?> </h6>
						<a class="dropdown-item" href="change.php">Change Password</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>