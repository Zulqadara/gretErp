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
	$date = $student['dt'];
	$stn = ((isset($_POST['stn']) && $_POST['stn'] !='')?ss($_POST['stn']):$student2['studentnumber']);
	
		if($_POST){
		
		$errors = array();
			

		if(!empty($errors)){
			echo display_errors($errors);
		}else{

			$insertSql2 = "UPDATE student SET studentnumber='$stn' where studentid='$edit_id'";

			$db->query($insertSql2);
			echo "<script type=\"text/javascript\">window.alert('Student Number Saved');window.location.href = 'register.php';</script>"; 
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
			<h3 class="text-center"> Register Student Number for Continuing Student</h3><hr>
				<form action="register.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				<?php if($date!=''): ?>
				<p class="text-primary">Last Admission on '<b><?=$date;?></b>'</p>
				<?php else: ?>
				<p class="text-danger">Student Not Yet Admitted</p>
				<?php endif; ?>
					<div class="form-group">
						<label for="stn"> Student Number:</label>
						<input type="text" value="<?=$stn;?>" name="stn" id="stn" class="form-control" placeholder = "Use for Continuing Students With No Student Number in the System"/>
					</div>
					<a href="register.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?' ':'Register ') ;?> Student Number" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
		<br>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS 
			ref from student 
			inner join studentreg on studentreg.studentid = student.studentid 
			where student.status='1' and studentreg.registrationstatus != 'new' and student.studentnumber IS NULL OR student.studentnumber=''
			GROUP BY student.studentid
			ORDER BY referencenumber and studentregid DESC";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Register Student Number for Continuing Student</h2><hr>

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
						<td><a href="register.php?add=<?=$studentid;?>" class="btn btn-primary">Register Student Number</a></td>
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
	
