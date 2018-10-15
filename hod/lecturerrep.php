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

		   <form class="form-inline" action="lecturerrep.php" method="post">
			   
			<div class="form-group mb-2">
					<label for="dep">Department*:</label>
					<select class="form-control" id="dep" name="dep" required>
						<option value=""></option>
						<option value="Business">Business</option>
						<option value="Accounts">Accounts</option>
						<option value="IT">IT</option>	
					</select>
				</div>
				
				<div class="form-group mx-sm-3 mb-2">
			   <button name="sub" class="btn btn-success mb-2">Proceed</button>
			   </div>
		   </form>
		   <?php
		   if(isset($_POST['sub'])):

$dep = ((isset($_POST['dep']) && $_POST['dep'] !='')?ss($_POST['dep']):'');

$qu = $db->query("select (staff.staffid) as c,(staff.name) as d, GROUP_CONCAT(courses.name SEPARATOR '<br>') AS courses
	from staff
	inner join lecturerunit on lecturerunit.lecturerid = staff.staffid
	inner join courses on courses.coursesid = lecturerunit.unitid
	where staff.department='$dep'
	group by lecturerunit.lecturerid");			
        ?>
		
				<div class="col-md-12">       
					<h2 class="text-center">Lecturers List</h2><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>#</th>
								<th>Lecturer ID</th>
								<th>Lecturer Name</th>
								<th>Lecturer Courses</th>
							</thead>
							<tbody>
							<?php
								$count=1;
								while($res = mysqli_fetch_assoc($qu)): ?>
								<tr>
									<td><?=$count; ?></td>
									<td><?=$res['c']; ?></td>
									<td><?=$res['d']; ?></td>
									<td><?=$res['courses']; ?></td>
								</tr>
								<?php
									$count++;
									endwhile; ?>
							</tbody>
						</table>
				</div>
				<br>
				<br>
							<form method="post" action="lecturerrepp.php" target="_blank">
				<input type="hidden" name="dep" value="<?=$dep;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
<?php endif; ?>

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
  	<script>
	jQuery('document').ready(function(){
		get_child_options('<?=$programs;?>');
	});
</script>
<?php
include 'includes/footer.php';
?>


