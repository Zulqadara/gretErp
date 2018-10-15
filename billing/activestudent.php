<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';


$semesterQ = $db->query("SELECT * FROM semesters");
$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$yearQ = $db->query("SELECT * FROM yearsofstudy");
$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
$stageQ = $db->query("SELECT * FROM stages");
$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
$dt =  date("Year");

if(isset($_GET['add'])){
	$studentid = (int)$_GET['add'];
	$year = (int)$_GET['year'];
	$semester = (int)$_GET['semester'];
	$stage = (int)$_GET['stage'];
	$sql = "INSERT INTO activestudent (studentid, semester, year, stage) VALUES ('$studentid','$semester','$year', '$stage')";
			$sresults = $db->query($sql);
echo "<script type=\"text/javascript\">window.alert('Student Activated');window.location.href = 'activestudent.php';</script>"; 
	//header('Location: activestudent.php');
}
?> 
  <body>
<div class="container">
      <div class="row">
	     
		 <div class="col-md-12" align="">
				<h2 class="text-center">Student Activation</h2><hr>
				<form action="activestudent.php" method="post" enctype="multipart/form-data">
					
				<div class="form-group">
					<label for="semester">Semester*:</label>
					<select class="form-control" id="semester" name="semester" required>
						<option value=""<?=(($semester == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
							<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="year">Year*:</label>
					<select class="form-control" id="year" name="year" required>
						<option value=""<?=(($year == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($yearQ)) : ?>
							<option value="<?= $p['yearsid']; ?>"<?=(($year == $p['yearsid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="stage">Stage*:</label>
					<select class="form-control" id="stage" name="stage" required>
						<option value=""<?=(($stage == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($stageQ)) : ?>
							<option value="<?= $p['stagesid']; ?>"<?=(($stage == $p['stagesid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
					
					<a href="index.php" class="btn btn-default">Cancel</a>
					<button name="cf" class="btn btn-primary"><?=((isset($_POST['cf']))?'Refresh':'Next');?></button>
					<br>
				<?php
						if(isset($_POST['cf'])) :
							$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
							$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
							$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
							//echo $program;
			$sql = "select *,  CONCAT(student.referencename, '/', student.referencemonth, '/', student.referenceyear, '/', student.referencenumber) AS ref 
			from student inner join studentreg on studentreg.studentid = student.studentid 
			WHERE student.status='1' and NOT EXISTS (SELECT *
                   FROM   activestudent od
                   WHERE  student.studentid = od.studentid and od.semester='$semester' and od.stage='$stage' and od.year = '$year' and year(dt) = '$dt')  
				   /*  GROUP BY studentreg.studentid */
				   ORDER BY student.referencenumber
				   
				   ";
			$sresults = $db->query($sql);
						?>
						<br>				
						
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Reference ID:</th>
						<th>Student Number:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Phone</th>
						<th>County</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$studentref = $student['ref'];
						$name = $student['name'];
						$gender = $student['gender'];
						$dob = $student['dob'];
						$email = $student['email'];
						$phone = $student['phone'];
						$country = $student['country'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$studentref;?></td>
						<td><?=$student['studentnumber'];?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="activestudent.php?add=<?=$studentid;?>&semester=<?=$semester;?>&year=<?=$year;?>&stage=<?=$stage;?>" class="btn btn-primary">Activate Student</a></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
					<?php endif; ?>
					</form>
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
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
		 "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
    } );
} );
	</script>
	
