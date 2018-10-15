<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$edit_id = (int)$_GET['add'];
$date = date("Y-m-d");
$flag=0;
$update=0;
if(isset($_POST['submit'])){
	$studentid = $_POST['studentid'];
	$unitid = $_POST['unitid'];
	
	$res = $db->query("SELECT * FROM lecturerattendance WHERE date='$date' AND lecturerid='$studentid'");
	$num=mysqli_num_rows($res);
	if($num){
		foreach($_POST['status'] as $id=>$status){
			
			
			$unitid = $_POST['unitid'][$id];
			$result = $db->query("UPDATE lecturerattendance SET status='$status' WHERE date='$date' AND lecturerid='$studentid' and unitid='$unitid'");
			if($result){
				$update=1;
			}
		}
	}else{
		foreach($_POST['status'] as $id=>$status){
			
			$unitid = $_POST['unitid'][$id];
			$result = $db->query("INSERT INTO lecturerattendance (lecturerid, status, date, hodid, unitid) VALUES
			('$studentid','$status','$date','$staffid','$unitid')");
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
				Lecturers Attendance Details Entered
			</div>
			<?php endif; ?>
			<?php if($update): ?>
			<div class="alert alert-warning">
				Lecturers Attendance Details Updated
			</div>
			<?php endif; ?>
				<h3 class="text-center">Lecturer Attendance - <?=$date;?></h3><hr>

				<?php
					$sql = "select courses.name as cname, courses.code as code, courses.coursesid as cid, staff.name, staff.staffid from staff 
					inner join lecturerunit on lecturerunit.lecturerid = staff.staffid
					inner join courses on lecturerunit.unitid = courses.coursesid
					WHERE staff.staffid='$edit_id'
					ORDER BY courses.name ";
					$sresults = $db->query($sql);
					$nums=mysqli_num_rows($sresults);
					if($nums){
				?>
				<form action="attendance2.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Unit Code</th>
						<th>Unit Name</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						$counter=0;
						while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['staffid'];
						$unitid = $student['cid'];
						$name = $student['code'];
						
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$student['cname'];?></td>
						<input type="hidden" value="<?=$unitid;?>" name="unitid[]">
						<td>
							<input type="radio" name="status[<?=$counter;?>]" value="Present"
							<?php 
							$res = $db->query("SELECT * FROM lecturerattendance WHERE date='$date' and lecturerid='$studentid' and unitid = '$unitid' and status='Present'");
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
							<input type="radio" name="status[<?=$counter;?>]" value="Absent"
							<?php 
							$res = $db->query("SELECT * FROM lecturerattendance WHERE date='$date' and lecturerid='$studentid' and unitid = '$unitid' and status='Absent'");
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
				<a href="attendance.php" class="btn btn-default">Cancel</a>
				<input type="hidden" value="<?=$studentid;?>" name="studentid">
				<input type="submit" name="submit" value="<?=((isset($_GET['edit']))?'Update ':'Enter ') ;?> Lecturer Attendance" class="btn btn-primary" />
				</form>
									<?php } else { ?>
				<a href="attendance.php" class="btn btn-default">Lecturer Not Allocated Any Units. Go Back</a>
					<?php } ?>
			</div>
		</div>
	</div>
		<br>		
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
	
