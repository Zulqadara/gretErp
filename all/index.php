<?php
	require_once '../core.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
?>
<!DOCTYPE html>
<html lang="en">
	<body>
		
		<!-- Navigation -->
		<br>
		<div class="container">
			<div class="row">
				<div class="col-md-12" align="center">
					<div class="card mb-4">
						<div class="card-body">
							<a href="leave.php" class="btn btn-primary">Apply for leave</a><hr>
						</div>
						<div class="card-body">
							<a href="hour.php" class="btn btn-primary">Apply for hour leave</a><hr>
						</div>
						<div class="card-body">
							<a href="overtime.php" class="btn btn-primary">Apply Overtime</a><hr>
						</div>
						<div class="card-body">
							<a href="eassignment.php" class="btn btn-primary">External Assignment Notification</a><hr>
						</div>
						<div class="card-body">
							<a href="off.php" class="btn btn-primary">Offday Application</a><hr>
						</div>	
						<div class="card-body">
							<a href="pay.php" class="btn btn-primary">View Pay Slips</a><hr>
						</div>				
						<div class="card-body">
							<a href="leavedays.php" class="btn btn-primary">View Leave Days</a><hr>
						</div>	
					</div>
				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
		<!-- Footer -->
	</body>
	<?php
		include 'includes/footer.php';
	?>
</html>