<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
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
$stypeQ = $db->query("SELECT * FROM stypes");
$stype = ((isset($_POST['stype']) && $_POST['stype'] !='')?ss($_POST['stype']):'');

$date = date("Y-m-d");
$flag=0;
$update=0;
if(isset($_POST['submit'])){
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
	$units = ((isset($_POST['unit']) && $_POST['unit'] !='')?ss($_POST['unit']):'');
	$stype = ((isset($_POST['stype']) && $_POST['stype'] !='')?ss($_POST['stype']):'');
	
	$res = $db->query("SELECT * FROM studentattendance WHERE date='$date'");
	$num=mysqli_num_rows($res);
	if($num){
		foreach($_POST['status'] as $id=>$status){
			
			$studentid = $_POST['studentid'][$id];
			$result = $db->query("UPDATE studentattendance SET status='$status' 
			WHERE date='$date' AND studentid='$studentid' and semester='$semester' and year='$year' and stage='$stage'");
			if($result){
				$update=1;
			}
		}
	}else{
		foreach($_POST['status'] as $id=>$status){
			
			$studentid = $_POST['studentid'][$id];
			$result = $db->query("INSERT INTO studentattendance (studentid, status, date, lecturerid, unitid, semester, year, stage, mode) VALUES
			('$studentid','$status','$date',1,'$units', '$semester', '$year', '$stage', '$stype')");
			if($result){
				$flag=1;
			}
		}
	}
}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
			<div class="col-md-12" align="">
			<?php if($flag): ?>
			<div class="alert alert-success">
				Students Attendance Details Entered
			</div>
			<?php endif; ?>
			<?php if($update): ?>
			<div class="alert alert-warning">
				Students Attendance Details Updated
			</div>
			<?php endif; ?>
			 <form class="form-inline" action="attendance.php" method="post">
			   
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
				<div class="form-group mb-2">
					<label for="stype">Day/Evening/ODL*:</label>
					<select class="form-control" id="stype" name="stype" required>
						<option value=""<?=(($stype == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($stypeQ)) : ?>
							<option value="<?= $p['stypeid']; ?>"<?=(($stype == $p['stypeid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group mx-sm-3 mb-2">
			   <button name="sub" class="btn btn-success mb-2">Proceed</button>
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
$stype = ((isset($_POST['stype']) && $_POST['stype'] !='')?ss($_POST['stype']):'');

?>

				<h3 class="text-center">Student Attendance - <?=$date;?></h3><hr>
				<?php
				
					$sql = "select *,  student.studentnumber AS ref from student 
					inner join activestudent on activestudent.studentid = student.studentid
					inner join studentprogramme on studentprogramme.studentid = student.studentid
					inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
					where activestudent.semester ='$semester' and activestudent.year = '$year' and activestudent.stage='$stage' 
					and year(activestudent.dt)='$date' and studentunits.unitid='$units' and studentunits.status = '1' and student.mode='$stype'
					ORDER BY student.name  ";
					$sresults = $db->query($sql);
				?>
				<form action="attendance.php" method="post">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>

						<th>Reference ID:</th>
						<th>Name</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						$counter=0;
						while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$studentref = $student['ref'];
						$name = $student['name'];
						
					?>
					<tr>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<input type="hidden" value="<?=$studentid;?>" name="studentid[]">
						<td>
							<input type="radio" name="status[<?=$counter;?>]" value="Present" required
							<?php 
							$res = $db->query("SELECT * FROM studentattendance WHERE date='$date' and studentid='$studentid' and status='Present'");
							$num=mysqli_num_rows($res);
							if($num){
								echo "checked=checked";
							}else{
								if(isset($_POST['status'][$counter]) && $_POST['status'][$counter] == "Present") {
									echo "checked=checked";
								}
							}
							?>
							> Present 
							<input type="radio" name="status[<?=$counter;?>]" value="Absent" required
							<?php 
							$res = $db->query("SELECT * FROM studentattendance WHERE date='$date' and studentid='$studentid' and status='Absent'");
							$num=mysqli_num_rows($res);
							if($num){
								echo "checked=checked";
							}else{
								if(isset($_POST['status'][$counter]) && $_POST['status'][$counter] == "Absent") {
									echo "checked=checked";
								}
							}
							?>
							> Absent
						</td>
					</tr>
					<?php 
					$counter++;
					endwhile; ?>
				</tbody>
				</table>
				<a href="index.php" class="btn btn-default">Cancel</a>
				<input type="hidden" name="semester" value="<?=$semester;?>"/>
				<input type="hidden" name="year" value="<?=$year;?>" />
				<input type="hidden" name="stage" value="<?=$stage;?>" />
				<input type="hidden" name="unit" value="<?=$units;?>" />
				<input type="hidden" name="stype" value="<?=$stype;?>" />
				
				<input type="submit" name="submit" value="<?=((isset($_GET['edit']))?'Update ':'Enter ') ;?> Students" class="btn btn-primary" />
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
		<br>		
<?php
include 'includes/footer.php';
?>
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
	
