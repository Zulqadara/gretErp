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
		  
				$qu = $db->query("select staff.staffid as stid, name, staffcontract.end as e, staffcontract.start as s FROM staff 
				INNER JOIN staffcontract on staff.staffid = staffcontract.staffid
				");			
        ?>
		
				<div class="col-md-8">       
					<h2 class="text-center">Contract Staff</h2><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>Staff ID</th>
								<th>Name</th>
								<th>Contract Start</th>
								<th>Contract End</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu)): ?>
								<tr>
									<td><?=$res['stid']; ?></td>
									<td><?=$res['name']; ?></td>
									<td><?=$res['s']; ?></td>
									<td><?=$res['e']; ?></td>
										
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
  	<script>
	jQuery('document').ready(function(){
		get_child_options('<?=$programs;?>');
	});
</script>
<?php
include 'includes/footer.php';
?>


