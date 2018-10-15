<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$schoolQ = $db->query("SELECT * FROM schools");
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
	$ptypeQ = $db->query("SELECT * FROM ptype");
	$ptype = ((isset($_POST['ptype']) && $_POST['ptype'] !='')?ss($_POST['ptype']):'');
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	
	$courseQ = $db->query("SELECT * FROM programs");
	$monthQ = $db->query("SELECT * FROM semesters");
	$modeQ = $db->query("SELECT * FROM stypes");
	
	
	$course = ((isset($_POST['course']) && $_POST['course'] !='')?ss($_POST['course']):'');
	$month = ((isset($_POST['month']) && $_POST['month'] !='')?ss($_POST['month']):'');
	$mode = ((isset($_POST['mode']) && $_POST['mode'] !='')?ss($_POST['mode']):'');
		
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$studentR = $db->query("SELECT * FROM student where studentid = '$edit_id'");
			$student = mysqli_fetch_assoc($studentR);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$student['name']);
			$gender = ((isset($_POST['gender']) && $_POST['gender'] !='')?ss($_POST['gender']):$student['gender']);
			$nationality = ((isset($_POST['nationality']) && $_POST['nationality'] !='')?ss($_POST['nationality']):$student['nationality']);
			$dob = ((isset($_POST['dob']) && $_POST['dob'] !='')?ss($_POST['dob']):$student['dob']);
			$email = ((isset($_POST['email']) && $_POST['email'] !='')?ss($_POST['email']):$student['email']);
			$phone = ((isset($_POST['phone']) && $_POST['phone'] !='')?ss($_POST['phone']):$student['phone']);
			$country = ((isset($_POST['country']) && $_POST['country'] !='')?ss($_POST['country']):$student['country']);
			$high = ((isset($_POST['high']) && $_POST['high'] !='')?ss($_POST['high']):$student['highschool']);
			$sy = ((isset($_POST['sy']) && $_POST['sy'] !='')?ss($_POST['sy']):$student['sy']);
			$ey = ((isset($_POST['ey']) && $_POST['ey'] !='')?ss($_POST['ey']):$student['ty']);
			$another = ((isset($_POST['another']) && $_POST['another'] !='')?ss($_POST['another']):$student['another']);
			$hsc = ((isset($_POST['hsc']) && $_POST['hsc'] !='')?ss($_POST['hsc']):$student['certification']);
			$grade = ((isset($_POST['grade']) && $_POST['grade'] !='')?ss($_POST['grade']):$student['grade']);
			$other = ((isset($_POST['other']) && $_POST['other'] !='')?ss($_POST['other']):$student['collegename']);
			$fy = ((isset($_POST['fy']) && $_POST['fy'] !='')?ss($_POST['fy']):$student['fy']);
			$ty = ((isset($_POST['ty']) && $_POST['ty'] !='')?ss($_POST['ty']):$student['cty']);
			$gs = ((isset($_POST['gs']) && $_POST['gs'] !='')?ss($_POST['gs']):$student['collegegrade']);
			$ca = ((isset($_POST['ca']) && $_POST['ca'] !='')?ss($_POST['ca']):$student['collegecertification']);
			$course = ((isset($_POST['course']) && $_POST['course'] !='')?ss($_POST['course']):$student['course']);
			$month = ((isset($_POST['month']) && $_POST['month'] !='')?ss($_POST['month']):$student['month']);
			$mode = ((isset($_POST['mode']) && $_POST['mode'] !='')?ss($_POST['mode']):$student['mode']);
			$financer = ((isset($_POST['financer']) && $_POST['financer'] !='')?ss($_POST['financer']):$student['financer']);
			$relation = ((isset($_POST['relation']) && $_POST['relation'] !='')?ss($_POST['relation']):$student['relationship']);
			$fnum = ((isset($_POST['fnum']) && $_POST['fnum'] !='')?ss($_POST['fnum']):$student['fnum']);
			$employed = ((isset($_POST['employed']) && $_POST['employed'] !='')?ss($_POST['employed']):$student['employed']);
			$how = ((isset($_POST['how']) && $_POST['how'] !='')?ss($_POST['how']):$student['how']);
			
		}
		
		if($_POST){
			$sql2 = "SELECT MAX(stdnum) as s FROM student";
			$results = $db->query($sql2);
			while($student = mysqli_fetch_assoc($results)){
				$stdnum = $student['s'];
				$stdnum2 = $student['s'] + 1;
			}
			$sql3 = "SELECT code FROM schools WHERE schoolid='$school'";
			$results = $db->query($sql3);
			$student = mysqli_fetch_assoc($results);
				$code = $student['code'];
			
			$sql4 = "SELECT level FROM ptype WHERE ptypeid='$ptype'";
			$results = $db->query($sql4);
			$student = mysqli_fetch_assoc($results);
				$level = $student['level'];
			
			$studentnumber = $code . '-' . $level . '-' . $stdnum2 . '-' . $year;
			echo $studentnumber;
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE student SET verify='1', studentnumber = '$studentnumber', stdnum='$stdnum2', wpass='password'
				WHERE studentid='$edit_id'";
				$db->query($insertSql);
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Student Registered. Student ID: $studentnumber ')
			window.location.href='verify.php';
			</SCRIPT>");
			}		
		}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?' ':' ') ;?> Verify Students & Generate Student Number</h3><hr>
			
				<legend>Personal Info</legend>
					<div class="form-group">
						<label for="name">Name*:</label>
						<input type="text" disabled class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="gender">Gender*:</label><br>
						<input disabled type="radio" name="gender" value="male" checked> Male<br>
						<input disabled type="radio" name="gender" value="female"> Female<br>
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth*:</label>
						<input disabled type="date" class="form-control" name="dob" id="dob" value="<?=$dob; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="email">Email*:</label>
						<input disabled type="email" class="form-control" name="email" id="email" value="<?=$email; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="nationality">Nationality*:</label>
						<input disabled type="nationality" class="form-control" name="nationality" id="nationality" value="<?=$nationality; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number*:</label>
						<input disabled type="number" class="form-control" name="phone" id="phone" value="<?=$phone; ?>"  required />
					</div>
					<div class="form-group">
						<label for="country">County of Origin*:</label>
						<input disabled type="text" class="form-control" name="country" id="country" value="<?=$country; ?>"  required />
					</div>
					
					<legend>Secondary School Information</legend>
					<div class="form-group">
						<label  for="high">High School Attended*:</label>
						<input disabled type="text" class="form-control" name="high" id="high" value="<?=$high; ?>"  required />
					</div>
					<div class="form-group">
						<label  for="sy">Start Year*:</label>
						<input disabled type="number" class="form-control" name="sy" id="sy" value="<?=$sy; ?>" maxlength="4" required />
					</div>
					<div class="form-group">
						<label  for="ey">End Year*:</label>
						<input disabled type="number" class="form-control" name="ey" id="ey" value="<?=$ey; ?>" maxlength="4" required />
					</div>
					<div class="form-group">
						<label for="another">Transferred to Another School?:</label>
						<input disabled type="text" class="form-control" name="another" id="another"  value="<?=$another; ?>" />
					</div>
					<div class="form-group">
						<label for="hsc">High School Certification*:</label>
						<input disabled type="text" class="form-control" name="hsc" id="hsc" value="<?=$hsc; ?>" required />
					</div>
					
					<div class="form-group">
						<label for="grade">Grade Scored*:</label>
						<input disabled type="text" class="form-control" name="grade" id="grade" value="<?=$grade; ?>" required/>
					</div>
					
					<legend>Students Course Selection</legend>
					<div class="form-group">
						<label for="other">Name of Other College:</label>
						<input disabled type="text" class="form-control" name="other" id="other" value="<?=$other; ?>" />
					</div>
					<div class="form-group">
						<label for="fy">From Year:</label>
						<input disabled type="number" class="form-control" name="fy" id="fy" value="<?=$fy; ?>" maxlength="4" />
					</div>
					<div class="form-group">
						<label for="ty">To Year:</label>
						<input disabled type="number" class="form-control" name="ty" id="ty" value="<?=$ty; ?>" maxlength="4" />
					</div>
					<div class="form-group">
						<label for="gs">Grade Scored:</label>
						<input disabled type="text" class="form-control" name="gs" id="gs" value="<?=$gs; ?>"  />
					</div>
					
					<div class="form-group">
						<label for="ca">Certification Awarded:</label>
						<input disabled type="text" class="form-control" name="ca" id="ca" value="<?=$ca; ?>" />
					</div>
					<hr>

					<div class="form-group">
						<label for="course">Course Interested*:</label>
						<select disabled class="form-control" id="course" name="course" required>
							<option value=""<?=(($course == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($courseQ)) : ?>
								<option value="<?= $p['programsid']; ?>"<?=(($course == $p['programsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="month">Intake Month*:</label>
						<select disabled class="form-control" id="month" name="month" required>
							<option value=""<?=(($month == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($monthQ)) : ?>
								<option value="<?= $p['semesterid']; ?>"<?=(($month == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="mode">Mode of Study*:</label>
						<select disabled class="form-control" id="mode" name="mode" required>
							<option value=""<?=(($mode == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($modeQ)) : ?>
								<option value="<?= $p['stypeid']; ?>"<?=(($mode == $p['stypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<legend>Finance Information</legend>
					<div class="form-group">
						<label for="financer">Name of Financer*:</label>
						<input disabled type="text" class="form-control" name="financer" id="financer" value="<?=$financer; ?>" required />
					</div>
					<div class="form-group">
						<label for="relation">Relationship with Financer*:</label><br>
						<input disabled type="radio" name="relation" value="parent" checked> Parent<br>
						<input disabled type="radio" name="relation" value="guardian"> Guardian<br>
					</div>
					<div class="form-group">
						<label for="fnum">Phone Number of Financer*:</label>
						<input disabled type="number" class="form-control" name="fnum" id="fnum" value="<?=$fnum; ?>" required />
					</div>
					<div class="form-group">
						<label for="emp">Employed?*:</label><br>
						<input disabled type="radio" name="emp" value="no" checked> No<br>
						<input disabled type="radio" name="emp" value="yes"> Yes<br>
					</div>
					
					<legend>Gretsa University Information</legend>
					<div class="form-group">
						<label for="how">How Gretsa University was Discovered by Applicant?*:</label>
						<select disabled class="form-control" id="how" name="how" required>
							<option value="<?=$how;?>"><?=$how;?></option>
							<option value="TV">TV</option>
							<option value="Newspaper">Newspaper</option>
							<option value="Word of Mouth">Word of Mouth</option>
						</select>
					</div>
					<div class="form-group">
					<?php 
					$sql = "select * from student where studentid='$edit_id' AND docs IS NOT NULL";
					$res = $db->query($sql);
					$num=mysqli_num_rows($res);
					if($num > 0): ?>
					<a href="download.php?cid=<?=$edit_id;?>" title="Download">Download Student Documents</a>
					<?php else: ?>
					<p class="btn-danger"> Student Documents not Uploaded</p>
					<?php endif; ?>
					</div>
					
					<legend>Course Taken Information</legend>
					<ul class="list-group">
						<?php 
							$res = $db->query("SELECT *, courses.name as n FROM studentprogramme inner join studentunits 
							on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
							inner join courses on courses.coursesid = studentunits.unitid
							WHERE studentid='$edit_id'");
							while($units = mysqli_fetch_assoc($res)) :
						?>
							<li class="list-group-item list-group-item"><?=$units['n'];?></li>
						<?php endwhile; ?>
					</ul>
					<br>
					<legend>Fees Information</legend>
					<?php
								$sql = "select * from studentprogramme
inner join studentfees on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
where studentid = '$edit_id' ORDER BY tamount DESC";
						$results = $db->query($sql);
					?>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th>Amount</th>
						<th>Paid</th>
						<th>Balance</th>
						<th>Invoice Date</th>
								
							</thead>
					<tbody>
						<?php while($result = mysqli_fetch_assoc($results)) : ?>
						<tr>
						<td><?=$result['tamount'];?></td>
							<td><?=$result['tpaid'];?></td>
							<td><u><b><i><?=$result['tamount'] - $result['tpaid'] ;?></i></b></u></td>
							<td><?=$result['dt'];?></td>
							
						</tr>
						<?php endwhile; ?>
					</tbody>
				  </table>
				</div>
				<legend>Student Number Information</legend>
				<form action="verify.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
					
					<div class="form-group mx-sm-3  mb-2">
					<label for="school">School*:</label>
					<select class="form-control" id="school" name="school" required>
						<option value=""<?=(($school == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
							<option value="<?= $p['schoolid']; ?>"<?=(($school == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
					</div>
					
					<div class="form-group mx-sm-3  mb-2">
					<label for="ptype">Programme Level*:</label>
					<select class="form-control" id="ptype" name="ptype" required>
						<option value=""<?=(($ptype == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($ptypeQ)) : ?>
							<option value="<?= $p['ptypeid']; ?>"<?=(($ptype == $p['ptypeid'])?' selected':'');?>><?= $p['name'];?> - <?= $p['level'];?></option>
						<?php endwhile; ?>
					</select>
					</div>
					
					<div class="form-group mx-sm-3  mb-2">
					<label for="year">Year of Admission*:</label>
					<select class="form-control" id="year" name="year" required>
						<option value=""></option>
						<?php
							$years = range ( date( 'y' ), date( 'y') + 10 );
							foreach ( $years as $year )
							{
							echo '<option value='.$year.'>'.$year.'</option>';
							}
						?>
					</select>
					</div>
					<a href="verify.php" class="btn btn-default">Cancel</a>
					<input type="submit" name="submt" value="Verify Student" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref 
			from student inner join activestudent on activestudent.studentid = student.studentid
			WHERE verify='0' OR studentnumber IS NULL OR studentnumber = ''
			ORDER BY referencenumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Verify & Generate Student Number</h2><hr>

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
						<td><a href="verify.php?edit=<?=$studentid;?>" class="btn btn-primary">Proceed</a></td>
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
	
