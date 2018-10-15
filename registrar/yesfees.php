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
$date = date("Y-m-d");
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
		   


$qu = $db->query("select student.studentnumber as c, (sum(studentfees.tamount) - sum(studentfees.tpaid)) as a from student
	inner join studentprogramme on studentprogramme.studentid = student.studentid
	inner join studentfees on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
	inner join studentinvoice on studentinvoice.studentfeesid = studentfees.studentfeesid
	where student.status='1'
	group by student.studentid
	having a >= 0
");			
        ?>
		
				<div class="col-md-8">       
					<h2 class="text-center">Students with Fee Balance</h2><hr>
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Student Number</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$count=1;
						while($res = mysqli_fetch_assoc($qu)): ?>
						<tr>
							<td><?=$count; ?></td>									
							<td><?=$res['c']; ?></td>									
						</tr>
					<?php
						$count++;
						endwhile; ?>
				</tbody>
			</table>
				</div>
				<br>
				<br>
							<form method="post" action="yesfeesp.php" target="_blank">
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>


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
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ]
    } );
} );
	</script>
<?php
include 'includes/footer.php';
?>


