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
	$grading = ((isset($_POST['grading']) && $_POST['grading'] !='')?ss($_POST['grading']):'');
	$date = date("Y-m-d");
	$flag=0;
	$update=0;
	if(isset($_POST['submit'])){
		
		$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
		$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
		$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
		$units = ((isset($_POST['unit']) && $_POST['unit'] !='')?ss($_POST['unit']):'');
		$grading = ((isset($_POST['grading']) && $_POST['grading'] !='')?ss($_POST['grading']):'');
		$grade = '';
		$marks = 0;
		
		$res = $db->query("SELECT * FROM studentexam 
		where studentexam.unitid='$units' and year(studentexam.date)='$date' 
		and studentexam.semester ='$semester' and studentexam.year = '$year' and studentexam.stage='$stage' 
		");
		$num=mysqli_num_rows($res);
		if($num){
			foreach($_POST['cat1'] as $id=>$cat1){
				
				$studentid = $_POST['studentid'][$id];
				
				$cat2 = $_POST['cat2'][$id];
				$exam = $_POST['exam'][$id];
				$marks = $cat1 + $cat2 + $exam;
						switch ($grading) {
			case 'Certificate':
			if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'Fail';
			}
			break;
			case 'Diploma':
						if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'F';
			}
			break;
			case 'Degree':
						if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'Fail';
			}
			break;
			case 'Medical Programme':
			if($marks >= 75){
				$grade ='A';
				}else if($marks >= 65 && $marks <= 74){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 64){
				$grade = 'C';
				}else if($marks <= 40){
				$grade = 'F';
			}
			break;
			default:
			echo 'select a grading system' ;
			exit();
		}
				//cahneg date to sem and year and actual year
				$result = $db->query("UPDATE studentexam SET cat1='$cat1', cat2='$cat2', exam='$exam' , grade='$grade' , marks='$marks'
				WHERE studentid='$studentid' and semester='$semester' and year='$year' and stage='$stage' and grading='$grading'");
				if($result){
					$update=1;
				}
			}
			}else{
			foreach($_POST['cat1'] as $id=>$cat1){
				
				$studentid = $_POST['studentid'][$id];
				$cat2 = $_POST['cat2'][$id];
				$exam = $_POST['exam'][$id];
				$marks = $cat1 + $cat2 + $exam;
						switch ($grading) {
			case 'Certificate':
			if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'Fail';
			}
			break;
			case 'Diploma':
						if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'F';
			}
			break;
			case 'Degree':
						if($marks >= 70){
				$grade ='A';
				}else if($marks >= 60 && $marks <= 69){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 59){
				$grade = 'C';
				}else if($marks >= 40 && $marks <= 49){
				$grade = 'D';
				}else if($marks <= 40){
				$grade = 'Fail';
			}
			break;
			case 'Medical Programme':
			if($marks >= 75){
				$grade ='A';
				}else if($marks >= 65 && $marks <= 74){
				$grade = 'B';
				}else if($marks >=50 && $marks <= 64){
				$grade = 'C';
				}else if($marks <= 40){
				$grade = 'F';
			}
			break;
			default:
			echo 'select a grading system' ;
			exit();
		}
				//cahneg date to sem and year and actual year
				$result = $db->query("INSERT INTO studentexam (studentid, cat1 , cat2, exam,  lecturerid, unitid, semester, year, stage, grading, grade, marks) 
				VALUES ('$studentid','$cat1', '$cat2', '$exam',$staffid,'$units','$semester','$year', '$stage', '$grading', '$grade', '$marks')");
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
			<?php if($flag): ?>
			<div class="alert alert-success">
				Students Exam Details Entered
			</div>
			<?php endif; ?>
			<?php if($update): ?>
			<div class="alert alert-warning">
				Students Exam Details Updated
			</div>
			<?php endif; ?>
			<form class="form-inline" action="exam.php" method="post">
				
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
				<div class="form-group mx-sm-3  mb-2">
					<label for="grading">Grading System*:</label>
					<select class="form-control" id="grading" name="grading" required>
						<option value=""<?=(($grading == '')?' selected':'');?>><?=(($grading == '')?'':$grading);?></option>
						<option value="Certificate">Certificate</option>
						<option value="Diploma">Diploma</option>
						<option value="Degree">Degree</option>
						<option value="Medical Programme">Medical Programme</option>
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
				$grading = ((isset($_POST['grading']) && $_POST['grading'] !='')?ss($_POST['grading']):'');
				
			?>
			<div class="col-md-12" align="">
				
				<h3 class="text-center">Student Exam - <?=$date;?></h3><hr>
				
				<?php
					$sql = "select *, student.studentid as std,  student.studentnumber AS ref,
					CASE WHEN studentexam.unitid = '$units'>0 THEN studentexam.unitid 
					ELSE ''
					END AS unitids
					from student 
					inner join activestudent on activestudent.studentid = student.studentid
					inner join studentprogramme on studentprogramme.studentid = student.studentid
					inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
					left join studentexam on student.studentid = studentexam.studentid and studentexam.unitid='$units' 
					and year(studentexam.date)='$date' and studentexam.semester ='$semester' and studentexam.year = '$year' and studentexam.stage='$stage' 
					where activestudent.semester ='$semester' and activestudent.year = '$year' and activestudent.stage='$stage' 
					and year(activestudent.dt)='$date' and studentunits.unitid='$units' and studentunits.status = '1'
					ORDER BY student.name  ";
					$sresults = $db->query($sql);
				?>
				<form action="exam.php" method="post">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								
								<th>Student Number:</th>
								<th>Name</th>
								<th>CAT 1</th>
								<th>CAT 2</th>
								<th>Exam</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
								$counter=0;
								while($student = mysqli_fetch_assoc($sresults)) : 
								$studentid = $student['std'];
								$studentref = $student['ref'];
								$name = $student['name'];
								$cat1 = $student['cat1'];
								$cat2 = $student['cat2'];
								$exam = $student['exam'];
							?>
							<tr>
								<td><?=$studentref;?></td>
								<td><?=$name;?></td>
								<input type="hidden" value="<?=$studentid;?>" name="studentid[]">
								
								<td>
									<input type="number" class="form-control" name="cat1[<?=$counter;?>]" value="<?=$cat1;?>" />
								</td>
								<td>
									<input type="number" class="form-control" name="cat2[<?=$counter;?>]" value="<?=$cat2;?>" />
								</td>
								<td>
									<input type="number" class="form-control" name="exam[<?=$counter;?>]" value="<?=$exam;?>" />
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
					<input type="hidden" name="grading" value="<?=$grading;?>" />
					<input type="submit" name="submit" value="Submit Students Marks" class="btn btn-primary" />
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
	
