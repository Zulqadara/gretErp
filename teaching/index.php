<?php
	require_once '../core.php';
	include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
	<body>
		<?php include 'includes/navigation.php';?>
		<!-- Navigation -->
		<br>
		<div class="container">
			<div class="row">
				<div class="col-md-12" align="center">
					<div class="card mb-4">
						<div class="card-body">
							<a href="room.php" class="btn btn-primary">Create Lecture Rooms</a><hr>
						</div>
						<div class="card-body">
							<a href="allocation.php" class="btn btn-primary">Lecture Room Allocation</a><hr>
						</div>
						<div class="card-body">
							<a href="allocationrep.php" class="btn btn-primary">Room Utilization Report</a><hr>
						</div>	
						<div class="card-body">
							<a href="areports.php" class="btn btn-primary">Students Count Report</a><hr>
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