<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$courseQ = $db->query("SELECT * FROM programs");
	$monthQ = $db->query("SELECT * FROM semesters");
	$modeQ = $db->query("SELECT * FROM stypes");
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$gender = ((isset($_POST['gender']) && $_POST['gender'] !='')?ss($_POST['gender']):'');
	$dob = ((isset($_POST['dob']) && $_POST['dob'] !='')?ss($_POST['dob']):'');
	$email = ((isset($_POST['email']) && $_POST['email'] !='')?ss($_POST['email']):'');
	$phone = ((isset($_POST['phone']) && $_POST['phone'] !='')?ss($_POST['phone']):'');
	$nationality = ((isset($_POST['nationality']) && $_POST['nationality'] !='')?ss($_POST['nationality']):'');
	$country = ((isset($_POST['country']) && $_POST['country'] !='')?ss($_POST['country']):'');
	$high = ((isset($_POST['high']) && $_POST['high'] !='')?ss($_POST['high']):'');
	$sy = ((isset($_POST['sy']) && $_POST['sy'] !='')?ss($_POST['sy']):'');
	$ey = ((isset($_POST['ey']) && $_POST['ey'] !='')?ss($_POST['ey']):'');
	$another = ((isset($_POST['another']) && $_POST['another'] !='')?ss($_POST['another']):'');
	$hsc = ((isset($_POST['hsc']) && $_POST['hsc'] !='')?ss($_POST['hsc']):'');
	$grade = ((isset($_POST['grade']) && $_POST['grade'] !='')?ss($_POST['grade']):'');
	$other = ((isset($_POST['other']) && $_POST['other'] !='')?ss($_POST['other']):'');
	$fy = ((isset($_POST['fy']) && $_POST['fy'] !='')?ss($_POST['fy']):'');
	$ty = ((isset($_POST['ty']) && $_POST['ty'] !='')?ss($_POST['ty']):'');
	$gs = ((isset($_POST['gs']) && $_POST['gs'] !='')?ss($_POST['gs']):'');
	$ca = ((isset($_POST['ca']) && $_POST['ca'] !='')?ss($_POST['ca']):'');
	$course = ((isset($_POST['course']) && $_POST['course'] !='')?ss($_POST['course']):'');
	$month = ((isset($_POST['month']) && $_POST['month'] !='')?ss($_POST['month']):'');
	$mode = ((isset($_POST['mode']) && $_POST['mode'] !='')?ss($_POST['mode']):'');
	$financer = ((isset($_POST['financer']) && $_POST['financer'] !='')?ss($_POST['financer']):'');
	$relation = ((isset($_POST['relation']) && $_POST['relation'] !='')?ss($_POST['relation']):'');
	$fnum = ((isset($_POST['fnum']) && $_POST['fnum'] !='')?ss($_POST['fnum']):'');
	$employed = ((isset($_POST['employed']) && $_POST['employed'] !='')?ss($_POST['employed']):'');
	$how = ((isset($_POST['how']) && $_POST['how'] !='')?ss($_POST['how']):'');
	
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
		
		$monthQ = $db->query("SELECT * FROM semesters where semesterid = '$month'");
		$monthR = mysqli_fetch_assoc($monthQ);
		
		$month2 = $monthR['name'];
		$month3 = substr($month2 , 0, 3);
		$month3 = strtoupper($month3);
		
		$errors = array();
			
		$required = array('name', 'gender' , 'relation');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$year = date("y");
	
			$sql2 = "SELECT referencenumber FROM student";
			$results = $db->query($sql2);
			while($student = mysqli_fetch_assoc($results)){
				$refnum = $student['referencenumber'] + 1;
			}
			$insertSql = "INSERT INTO student (name, gender, dob, email, nationality, phone, country, highschool, sy, ty, another, certification,
			grade, collegename, fy, cty, collegegrade, collegecertification, course, month, mode, financer, relationship, fnum, employed, how, referencename,
			referencenumber, referencemonth, referenceyear)
	VALUES ('$name', '$gender', '$dob', '$email', '$nationality', '$phone', '$country', '$high', '$sy', '$ey', '$another', '$hsc', '$grade', '$other', '$fy'
	, '$ty', '$gs', '$ca', '$course', '$month', '$mode', '$financer', '$relation', '$fnum', '$employed', '$how', 'ADM', '$refnum', '$month3', '$year')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE student SET name='$name', nationality='$nationality', dob='$dob', gender='$gender', email='$email', 
				phone='$phone', country='$country', 
				highschool='$high', sy='$sy',ty='$ey',another='$another',certification='$hsc',grade='$grade',
				collegename='$other',fy='$fy', cty='$ty',collegegrade='$gs',collegecertification='$ca',
				course='$course',month='$month',mode='$mode',financer='$financer',relationship='$relation', fnum='$fnum',
				employed='$employed',how='$how'
				WHERE studentid='$edit_id'";
				$db->query($insertSql);
				header('Location: applicants.php');
			}
			$db->query($insertSql);
			$id = $db->insert_id;
			$sql3 = "SELECT CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref FROM student WHERE studentid='$id'";
			$results2 = $db->query($sql3);
			while($student2 = mysqli_fetch_assoc($results2)){
				$refnum2 = $student2['ref'];
			}
	
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Applicant Registered. Applicant ID: $refnum2 ')
			window.location.href='applicants.php';
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
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Applicants</h3><hr>
				<form action="applicants.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Personal Info</legend>
					<div class="form-group">
						<label for="name">Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="gender">Gender*:</label><br>
						<input type="radio" name="gender" value="male" checked> Male<br>
						<input type="radio" name="gender" value="female"> Female<br>
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth*:</label>
						<input type="date" class="form-control" name="dob" id="dob" value="<?=$dob; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="email">Email*:</label>
						<input type="email" class="form-control" name="email" id="email" value="<?=$email; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="nationality">Nationality*:</label>
						<input type="nationality" class="form-control" name="nationality" id="nationality" value="<?=$nationality; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number*:</label>
						<input type="number" min="0" class="form-control" name="phone" id="phone" value="<?=$phone; ?>"  required />
					</div>
					<div class="form-group">
						<label for="country">County of Origin*:</label>
						<input type="text" class="form-control" name="country" id="country" value="<?=$country; ?>"  required />
					</div>
					
					<legend>Secondary School Information</legend>
					<div class="form-group">
						<label for="high">High School Attended*:</label>
						<input type="text" class="form-control" name="high" id="high" value="<?=$high; ?>"  required />
					</div>
					<div class="form-group">
						<label for="sy">Start Year*:</label>
						<input type="number" min="0" class="form-control" name="sy" id="sy" value="<?=$sy; ?>" maxlength="4" required />
					</div>
					<div class="form-group">
						<label for="ey">End Year*:</label>
						<input type="number" min="0" class="form-control" name="ey" id="ey" value="<?=$ey; ?>" maxlength="4" required />
					</div>
					<div class="form-group">
						<label for="another">Transferred to Another School?:</label>
						<input type="text" class="form-control" name="another" id="another"  value="<?=$another; ?>" />
					</div>
					<div class="form-group">
						<label for="hsc">High School Certification*:</label>
						<input type="text" class="form-control" name="hsc" id="hsc" value="<?=$hsc; ?>" required />
					</div>
					
					<div class="form-group">
						<label for="grade">Grade Scored*:</label>
						<input type="text" class="form-control" name="grade" id="grade" value="<?=$grade; ?>" required/>
					</div>
					
					<legend>Students Course Selection</legend>
					<div class="form-group">
						<label for="other">Name of Other College:</label>
						<input type="text" class="form-control" name="other" id="other" value="<?=$other; ?>" />
					</div>
					<div class="form-group">
						<label for="fy">From Year:</label>
						<input type="number" min="0" class="form-control" name="fy" id="fy" value="<?=$fy; ?>" maxlength="4" />
					</div>
					<div class="form-group">
						<label for="ty">To Year:</label>
						<input type="number" min="0" class="form-control" name="ty" id="ty" value="<?=$ty; ?>" maxlength="4" />
					</div>
					<div class="form-group">
						<label for="gs">Grade Scored:</label>
						<input type="text" class="form-control" name="gs" id="gs" value="<?=$gs; ?>"  />
					</div>
					
					<div class="form-group">
						<label for="ca">Certification Awarded:</label>
						<input type="text" class="form-control" name="ca" id="ca" value="<?=$ca; ?>" />
					</div>
					<hr>

					<div class="form-group">
						<label for="course">Course Interested*:</label>
						<select class="form-control" id="course" name="course" required>
							<option value=""<?=(($course == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($courseQ)) : ?>
								<option value="<?= $p['programsid']; ?>"<?=(($course == $p['programsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="month">Intake Month*:</label>
						<select class="form-control" id="month" name="month" required>
							<option value=""<?=(($month == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($monthQ)) : ?>
								<option value="<?= $p['semesterid']; ?>"<?=(($month == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="mode">Mode of Study*:</label>
						<select class="form-control" id="mode" name="mode" required>
							<option value=""<?=(($mode == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($modeQ)) : ?>
								<option value="<?= $p['stypeid']; ?>"<?=(($mode == $p['stypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<legend>Finance Information</legend>
					<div class="form-group">
						<label for="financer">Name of Financer*:</label>
						<input type="text" class="form-control" name="financer" id="financer" value="<?=$financer; ?>" required />
					</div>
					<div class="form-group">
						<label for="relation">Relationship with Financer*:</label><br>
						<input type="radio" name="relation" value="parent" checked> Parent<br>
						<input type="radio" name="relation" value="guardian"> Guardian<br>
					</div>
					<div class="form-group">
						<label for="fnum">Phone Number of Financer*:</label>
						<input type="number" min="0" class="form-control" name="fnum" id="fnum" value="<?=$fnum; ?>" required />
					</div>
					<div class="form-group">
						<label for="emp">Employed?*:</label><br>
						<input type="radio" name="emp" value="no" checked> No<br>
						<input type="radio" name="emp" value="yes"> Yes<br>
					</div>
					
					<legend>Gretsa University Information</legend>
					<div class="form-group">
						<label for="how">How Gretsa University was Discovered by Applicant?*:</label>
						<select class="form-control" id="how" name="how" required>
							<option value="<?=$how;?>"><?=$how;?></option>
							<option value="TV">TV</option>
							<option value="Newspaper">Newspaper</option>
							<option value="Word of Mouth">Word of Mouth</option>
						</select>
					</div>
						<div class="form-group">
							<input required type="checkbox" required name="agree" value="yes"> I certify that the information I have given in this form is correct and to the best of knowledge<br>
						</div>
					
					<a href="applicants.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Applicant and Generate Reference Number" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref 
			from student
			WHERE
			NOT EXISTS (SELECT *
                   FROM   studentreg od
                   WHERE  student.studentid = od.studentid)  
				   ORDER BY referencenumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="applicants.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Applicant</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Applicants</h2><hr>

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
						<td><a href="applicants.php?edit=<?=$studentid;?>" class="btn btn-primary">Edit</a></td>
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
	
