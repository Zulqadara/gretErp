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
$units = ((isset($_POST['unit']) && $_POST['unit'] !='')?ss($_POST['unit']):'');
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

		   <form class="form-inline" action="stdsemc.php" method="post">
			   
			   				<div class="form-group mb-2">
					<label for="semester">Semester*:</label>
					<select class="form-control" id="semester" name="semester" required>
						<option value=""<?=(($semester == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
							<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group mx-sm-3 mb-2">
					<label for="year">Year*:</label>
					<select class="form-control" id="year" name="year" required>
						<option value=""<?=(($year == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($yearQ)) : ?>
							<option value="<?= $p['yearsid']; ?>"<?=(($year == $p['yearsid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group mb-2">
					<label for="stage">Stage*:</label>
					<select class="form-control" id="stage" name="stage" required>
						<option value=""<?=(($stage == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($stageQ)) : ?>
							<option value="<?= $p['stagesid']; ?>"<?=(($stage == $p['stagesid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group mx-sm-3  mb-2">
					<label for="school">School*:</label>
					<select class="form-control" id="school" name="school" required>
						<option value=""<?=(($school == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
							<option value="<?= $p['schoolid']; ?>"<?=(($school == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group mb-2">
					<label for="program">Programme*:</label>
					<select class="form-control" id="program" name="program" required>
					</select>
				</div>
				<div class="form-group mb-2">
					<label for="unit">Unit*:</label>
					<select class="form-control" id="unit" name="unit" required>
					</select>
				</div>
				<div class="form-group mx-sm-3 mb-2">
			   <button name="sub" class="btn btn-success">Proceed</button>
			   </div>
		   </form>
		   <?php
		   if(isset($_POST['sub'])):

$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
$programs = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
$units = ((isset($_POST['unit']) && $_POST['unit'] !='')?ss($_POST['unit']):'');

				$qu = $db->query("select student.studentnumber as c, courses.name from student
inner join activestudent on activestudent.studentid = student.studentid
inner join stypes on stypes.stypeid = student.`mode`
inner join studentprogramme on  student.studentid = studentprogramme.studentid
inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
inner join courses on courses.coursesid = studentunits.unitid
where activestudent.semester='$semester' and activestudent.`year`='$year' and activestudent.stage='$stage'
and studentprogramme.school='$school' and studentprogramme.programmeid='$programs' and studentunits.status='1' and studentunits.unitid='$units'");			
        ?>
		
				<div class="col-md-8">       
					<h2 class="text-center">Student in Course</h2><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								
								<th>#</th>
								<th>Student Number</th>
								<th>Unit Name</th>
							</thead>
							<tbody>
							<?php 
								$count=1;
								while($res = mysqli_fetch_assoc($qu)): ?>
								<tr>
									<td><?=$count; ?></td>
									<td><?=$res['c']; ?></td>
									<td><?=$res['name']; ?></td>
										
								</tr>
								<?php
									$count++;
									endwhile; ?>
							</tbody>
						</table>
				</div>
				<br>
				<br>
							<form method="post" action="stdsemcp.php" target="_blank">
								<input type="hidden" name="semester" value="<?=$semester;?>" />
				<input type="hidden" name="year" value="<?=$year;?>" />
				<input type="hidden" name="stage" value="<?=$stage;?>" />
				<input type="hidden" name="school" value="<?=$school;?>" />
				<input type="hidden" name="programs" value="<?=$programs;?>" />
				<input type="hidden" name="units" value="<?=$units;?>" />
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
	<script>
	jQuery('document').ready(function(){
		get_child_options1('<?=$units;?>');
	});
</script>
<?php
include 'includes/footer.php';
?>


