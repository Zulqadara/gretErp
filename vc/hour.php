<?php
	require_once '../core.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
	$errors = array();
	
	if(isset($_GET['approve'])){
		$edit_id = (int)$_GET['approve'];
		
		$lresults = $db->query("SELECT *,  hours as dif from hoursleave 
		inner join staff on staff.staffid = hoursleave.staffid
		where leaveid = '$edit_id'");	
		$leaver = mysqli_fetch_assoc($lresults);
		$nature = $leaver['nature'];
		if($nature=='Annual Leave'){
			$dif = $leaver['dif'];
			$dif = $dif / 24;
			$leave = $leaver['aleaves'];
			$netleave = $leaver['anetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET anetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE hoursleave SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Sick Leave'){
			$dif = $leaver['dif'];
			$dif = $dif / 24;
			$leave = $leaver['sleaves'];
			$netleave = $leaver['snetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET snetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE hoursleave SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Maternity Leave'){
			$dif = $leaver['dif'];
			$dif = $dif / 24;
			$leave = $leaver['mleaves'];
			$netleave = $leaver['mnetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET mnetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE hoursleave SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Paternity Leave'){
			$dif = $leaver['dif'];
			$dif = $dif / 24;
			$leave = $leaver['pleaves'];
			$netleave = $leaver['pnetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET pnetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE hoursleave SET status='approved' WHERE leaveid='$edit_id'");	
		}
		
		header('Location: hour.php');
	}
	if(isset($_GET['reject'])){
		$edit_id = (int)$_GET['reject'];
		$db->query("UPDATE hoursleave SET status='rejected' WHERE leaveid='$edit_id'");	
		header('Location: hour.php');
	}
?> 
<body>
	
    <!-- Navigation -->
	<br>
	
	<?php
		
		$sql = "select * from hoursleave inner join staff on staff.staffid = hoursleave.staffid where status='pending' AND hodstatus='approved' AND hrstatus='approved'";
		$sresults = $db->query($sql);
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12" align="">
				<br>
				<div class="clearfix"></div>
				<h2 class="text-center">Hour Leave</h2><hr>
				
				<table id="table_id" class="display responsive" width="100%">
					<thead>
						<tr>
							<th>Staff No.</th>
							<th>Staff Name</th>
							<th>Nature</th>
							<th>From Time</th>
							<th>To Time</th>
							<th>Hours</th>
							<th>Supervisor</th>
							<th>Delegation</th>
							<th>Status</th>
							<th></th>
							
						</tr>
					</thead>
					<tbody>
						<?php while($school = mysqli_fetch_assoc($sresults)) : 
							$leaveid = $school['leaveid'];
							$no = $school['staffid'];
							$nm = $school['name'];
							$name = $school['nature'];
							$code = $school['froms'];
							$type = $school['tos'];
							$title = $school['hours'];
							$hname = $school['supervisorid'];
							$status = $school['status'];
							$delegation = $school['delegation'];
						?>
						<tr>
							<td><?=$no;?></td>
							<td><?=$nm;?></td>
							<td><?=$name;?></td>
							<td><?=$code;?></td>
							<td><?=$type;?></td>
							<td><?=$title;?></td>
							<td><?=$hname;?></td>
							<td><?=$delegation;?></td>
							<td><?=$status;?></td>
							<td><a href="hour.php?approve=<?=$leaveid;?>" class="btn btn-primary">Approve</a> | <a href="hour.php?reject=<?=$leaveid;?>" class="btn btn-warning">Reject</a></td>
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

