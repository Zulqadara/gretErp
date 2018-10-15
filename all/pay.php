<?php
	require_once '../core.php';
	include 'includes/header.php';
	$semesterQ = $db->query("SELECT * FROM semesters");
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	$yearQ = $db->query("SELECT * FROM yearsofstudy");
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	$stageQ = $db->query("SELECT * FROM stages");
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
	$schoolQ = $db->query("SELECT * FROM schools");
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
	$programs = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
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
					<?php
						$qu = $db->query("select *
							from staff
							inner join payroll on staff.staffid = payroll.staffid
							where staff.staffid='$staffid'
						");			
					?>
					<div class="col-md-12">       
						<h2 class="text-center">Payslip</h2><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								<th>Total Gross</th>
								<th>Total Deductions</th>
								<th>PAYE</th>
								<th>NSSF</th>
								<th>NHIF</th>
								<th>NET</th>
								<th>Date</th>
								<th></th>
							</thead>
							<tbody>
								<?php while($res = mysqli_fetch_assoc($qu)): 
									$id=$res['payrollid'];
									?>
								<tr>
									<td><?=$res['gross']; ?></td>
									<td><?=$res['deductions']; ?></td>
									<td><?=$res['paye']; ?></td>
									<td><?=$res['nssf']; ?></td>
									<td><?=$res['nhif']; ?></td>
									<td><?=$res['net']; ?></td>
									<td><?=$res['dt']; ?></td>
									<td>
																<form method="post" action="payp.php" target="_blank">
				<input type="hidden" name="id" value="<?=$id;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
					<br>
					<br>
					<a class="btn btn-primary btn-lg" href="index.php">Back</a>
				</div>
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container -->
		<!-- Footer -->
		<br>
	</body>
	<?php
		include 'includes/footer.php';
	?>
