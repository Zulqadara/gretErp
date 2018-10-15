<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['approve'])){
	$edit_id = (int)$_GET['approve'];
	$lresults = $db->query("SELECT * from `overtime` 
		inner join staff on staff.staffid = `overtime`.staffid
		where overtimeid = '$edit_id'");	
	$leaver = mysqli_fetch_assoc($lresults);
		
		$overtime = $leaver['expected'];
		$netleave = $leaver['netleave'];
		$staff = $leaver['staffid'];
		$days = $overtime / 24;
		$newnet = $netleave - $days;
		
	$db->query("UPDATE `staff` SET netleave='$newnet' WHERE staffid='$staff'");		
	$db->query("UPDATE `overtime` SET status='approved' WHERE overtimeid='$edit_id'");	
	header('Location: overtime.php');
}
if(isset($_GET['reject'])){
	$edit_id = (int)$_GET['reject'];
	$db->query("UPDATE `overtime` SET status='rejected' WHERE overtimeid='$edit_id'");	
	header('Location: overtime.php');
}
?> 
  <body>

    <!-- Navigation -->
<br>
   
				<?php
		
			$sql = "select * from `overtime` inner join staff on staff.staffid = `overtime`.staffid where status = 'pending' AND hodstatus='approved' AND hrstatus='approved'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  
<div class="clearfix"></div>
		  		<h2 class="text-center">Overtime</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff No</th>
						<th>Name</th>
						<th>Nature</th>
						<th>Date of Assignment</th>
						<th>Date Expected to Work</th>
						<th>Time</th>
						<th>Supervisor</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$no = $school['staffid'];
						$nm = $school['name'];
						$overtimeid = $school['overtimeid'];
						$name = $school['nature'];
						$code = $school['froms'];
						$type = $school['tos'];
						$title = $school['expected'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$no;?></td>
						<td><?=$nm;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$status;?></td>
						<td><a href="overtime.php?approve=<?=$overtimeid;?>" class="btn btn-primary">Approve</a> | <a href="overtime.php?reject=<?=$overtimeid;?>" class="btn btn-warning">Reject</a></td>
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

include 'includes/footer.php';
?>
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ]
    } );
} );
	</script>
	
