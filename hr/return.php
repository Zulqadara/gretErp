<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$schoolQ = $db->query("SELECT * FROM schools");
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
		
			if(isset($_GET['edit'])){
			$date= date("Y-m-d");
			$edit_id = (int)$_GET['edit'];
			$studentR = $db->query("SELECT *, DATEDIFF(NOW(), rdate) as adate FROM gown where studentid = '$edit_id' and status = '0'");
			$student = mysqli_fetch_assoc($studentR);
			$item = ($student['items']);
			$rdate = ((isset($_POST['rdate']) && $_POST['rdate'] !='')?ss($_POST['rdate']):$student['rdate']);
			$adate = ((isset($_POST['adate']) && $_POST['adate'] !='')?ss($_POST['adate']):$student['adate']);
			$fine = max($adate,0) * 500;

		}
		
		if($_POST){
			$insertSql = "UPDATE gown SET adate =NOW(), fine ='$fine', status = 1 where studentid = '$edit_id' and `status` = '0'";
				$db->query($insertSql);
				header('Location: return.php');
					
		}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?' ':' ') ;?> Gown Return</h3><hr>
				<form action="return.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
					
					<div class="form-group mx-sm-3  mb-2">
					<label for="items">Items Collected:</label><br>
					<input type="text" disabled class="form-control" value="<?=$item;?>" name="item"/>
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="rdate">Date of Return*:</label>
					<input type="date" disabled name="rdate" value="<?=$rdate;?>" class="form-control" />
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="adate">Days Returned After*:</label>
					<input type="text" disabled name="adate" value="<?=$adate;?>" class="form-control" />
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="fine">Fine*:</label>
					<input type="text" disabled name="fine" value="<?=$fine;?>" class="form-control" />
					</div>
					
					<a href="return.php" class="btn btn-default">Cancel</a>
					<input type="submit" name="submt" value="Take Gown" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref 
			from student inner join activestudent on activestudent.studentid = student.studentid
			inner join gown on student.studentid = gown.studentid
			WHERE student.verify='1' AND gown.status = '0'
			ORDER BY studentnumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Gown Return</h2><hr>

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
						<th>Country</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$ref = $student['ref'];
						$studentref = $student['studentnumber'];
						$name = $student['name'];
						$gender = $student['gender'];
						$dob = $student['dob'];
						$email = $student['email'];
						$phone = $student['phone'];
						$country = $student['country'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$ref;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="return.php?edit=<?=$studentid;?>" class="btn btn-primary">Proceed</a></td>
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
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            }
        ]
    } );
} );
	</script>
	
