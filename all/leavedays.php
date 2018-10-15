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

				$qu = $db->query("select count(leave.leaveid) as c, staff.anetleaves as net from staff
				inner join `leave` on staff.staffid = `leave`.staffid
				where staff.staffid='$staffid' and `leave`.`status`='approved' and leave.nature='Annual Leave'");			
				
				$qu2 = $db->query("select count(leave.leaveid) as c, staff.snetleaves as net from staff
				inner join `leave` on staff.staffid = `leave`.staffid
				where staff.staffid='$staffid' and `leave`.`status`='approved' and leave.nature='Sick Leave'");	
				
				$qu3 = $db->query("select count(leave.leaveid) as c, staff.mnetleaves as net from staff
				inner join `leave` on staff.staffid = `leave`.staffid
				where staff.staffid='$staffid' and `leave`.`status`='approved' and leave.nature='Maternity Leave'");	
				
				$qu4 = $db->query("select count(leave.leaveid) as c, staff.pnetleaves as net from staff
				inner join `leave` on staff.staffid = `leave`.staffid
				where staff.staffid='$staffid' and `leave`.`status`='approved' and leave.nature='Paternity Leave'");	
        ?>
		
				<div class="col-md-8">       
					<h3 class="text-center">Annual Leave Days</h3><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>Leave Taken</th>
								<th>Leave Remaining</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu)): ?>
								<tr>
									<td><?=$res['c']; ?></td>
									<td><?=$res['net']; ?></td>
										
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
				</div>
				<br>
				<br> 
				<div class="col-md-8">       
					<h3 class="text-center">Sick Leave Days</h3><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>Leave Taken</th>
								<th>Leave Remaining</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu2)): ?>
								<tr>
									<td><?=$res['c']; ?></td>
									<td><?=$res['net']; ?></td>
										
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
				</div>
				<br>
				<br> 
				<div class="col-md-8">       
					<h3 class="text-center">Maternity Leave Days</h3><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>Leave Taken</th>
								<th>Leave Remaining</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu3)): ?>
								<tr>
									<td><?=$res['c']; ?></td>
									<td><?=$res['net']; ?></td>
										
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
				</div>
				<br>
				<br> 
				<div class="col-md-8">       
					<h3 class="text-center">Paternity Leave Days</h3><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>Leave Taken</th>
								<th>Leave Remaining</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu4)): ?>
								<tr>
									<td><?=$res['c']; ?></td>
									<td><?=$res['net']; ?></td>
										
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


