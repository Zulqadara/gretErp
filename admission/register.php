<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add'])){
	
	$edit_id = (int)$_GET['add'];
	$studentR = $db->query("SELECT * FROM studentreg where studentid = '$edit_id' ORDER BY studentregid DESC");
	$student = mysqli_fetch_assoc($studentR);
	$studentR2 = $db->query("SELECT studentnumber FROM student where studentid = '$edit_id'");
	$student2 = mysqli_fetch_assoc($studentR2);
	$modeQ = $db->query("SELECT * FROM stypes");
	$levelQ = $db->query("SELECT * FROM ptype");
	$semesterQ = $db->query("SELECT * FROM semesters");
	$programmeQ = $db->query("SELECT * FROM programs");
	$yearQ = $db->query("SELECT * FROM yearsofstudy");
	$stageQ = $db->query("SELECT * FROM stages");
	$schoolQ = $db->query("SELECT * FROM schools");
	$date = $student['dt'];

	$mode = ((isset($_POST['mode']) && $_POST['mode'] !='')?ss($_POST['mode']):$student['mode']);
	$level = ((isset($_POST['level']) && $_POST['level'] !='')?ss($_POST['level']):$student['level']);
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):$student['semester']);
	$programme = ((isset($_POST['programme']) && $_POST['programme'] !='')?ss($_POST['programme']):$student['programme']);
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):$student['year']);
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):$student['stage']);
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):$student['school']);
	$registrationstatus = ((isset($_POST['registrationstatus']) && $_POST['registrationstatus'] !='')?ss($_POST['registrationstatus']):$student['registrationstatus']);
	$stn = ((isset($_POST['stn']) && $_POST['stn'] !='')?ss($_POST['stn']):$student2['studentnumber']);
	$studycenter = ((isset($_POST['studycenter']) && $_POST['studycenter'] !='')?ss($_POST['studycenter']):$student['studycenter']);
		if($_POST){
		
		$filename=$_FILES['doc']['name'];
		if($filename!=''){
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$errors = array();
			
			$allowed = array('png', 'jpeg', 'jpg');
		$tmpLoc = array();
		$uploadPath = array();
		
			$ffile = fopen($_FILES['doc']['tmp_name'],"rb");
				$contents = fread($ffile,$_FILES['doc']['size']);
				$fileupload = mysqli_escape_string($db, $contents);

		if(!in_array($ext, $allowed)){
					$errors[] = 'The file extension must be a PNG/JPEG/JPG';
		}
			}else{
			$fileupload='';
			}
			
		$required = array('mode', 'level' , 'semester');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}			

		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO studentreg (studentid, mode, registrationstatus, studycenter, level, semester, programme, year, stage, school, 
			photoname, photo) VALUES 
			('$edit_id', '$mode', '$registrationstatus', '$studycenter', '$level', '$semester', '$programme', '$year', '$stage', '$school', 
			'$filename', '$fileupload')";

			$db->query($insertSql);
			$insertSql2 = "UPDATE student SET mode='$mode' where studentid='$edit_id'";

			$db->query($insertSql2);
			echo "<script type=\"text/javascript\">window.alert('Student Admitted');window.location.href = 'register.php';</script>"; 
			//header('Location: register.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

        <div class="col-md-12" align="">
			<h3 class="text-center"> Admit</h3><hr>
				<form action="register.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				<?php if($date!=''): ?>
				<p class="text-primary">Last Admission on '<b><?=$date;?></b>'</p>
				<?php endif; ?>
					<div class="form-group">
						<label for="mode">Mode of Study*:</label>
						<select class="form-control" id="mode" name="mode" required>
							<option value=""<?=(($mode == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($modeQ)) : ?>
								<option value="<?= $p['stypeid']; ?>"<?=(($mode == $p['stypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="registrationstatus">Admission Status*:</label>
						<select class="form-control" id="registrationstatus" name="registrationstatus" disabled required>
						<option value="new">New Student</option>
							<option value="new">New Student</option>
							<option value="continuing">Continuing Student</option>
							<option value="upgrading">Upgrading Student</option>
						</select>
					</div>
					<div class="form-group">
						<label for="studycenter">Study Center*:</label><br>							
							<input type="text" name="studycenter" value="<?=$studycenter;?>" list="exampleList">
								<datalist id="exampleList">
									<option value="Thika">
								</datalist>
					</div>
					<div class="form-group">
						<label for="level">Level of Study*:</label>
						<select class="form-control" id="level" name="level" required>
							<option value=""<?=(($level == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($levelQ)) : ?>
								<option value="<?= $p['ptypeid']; ?>"<?=(($level == $p['ptypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
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
						<label for="programme">Academic Programme*:</label>
						<select class="form-control" id="programme" name="programme" required>
							<option value=""<?=(($programme == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($programmeQ)) : ?>
								<option value="<?= $p['programsid']; ?>"<?=(($programme == $p['programsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="year">Year of Study*:</label>
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
					<div class="form-group">
						<label for="school">School*:</label>
						<select class="form-control" id="school" name="school" required>
							<option value=""<?=(($school == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
								<option value="<?= $p['schoolid']; ?>"<?=(($school == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="doc">Upload Passport Photo:</label>
						<input type="file" name="doc" class="form-control" id="doc" accept=".png, .jpeg" />
					</div>
					<a href="register.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?' ':'Register ') ;?> Student" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS 
			ref from student st where st.status='1' 
			AND  st.studentid NOT IN (SELECT studentreg.studentid FROM studentreg)
			ORDER BY st.referencenumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Admit Student</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Reference ID:</th>
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
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="register.php?add=<?=$studentid;?>" class="btn btn-primary">Admit</a></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   <br>
  </body>
<?php
}
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
	
