<?php
	require_once '../core.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
	$errors = array();
	
	if(isset($_GET['approve'])){
		$edit_id = (int)$_GET['approve'];
		
		$lresults = $db->query("SELECT *,  DATEDIFF(tos, froms) as dif from `leave` 
		inner join staff on staff.staffid = `leave`.staffid
		where leaveid = '$edit_id'");	
		$leaver = mysqli_fetch_assoc($lresults);
		$nature = $leaver['nature'];
		if($nature=='Annual Leave'){
			$dif = $leaver['dif'];
			$leave = $leaver['aleaves'];
			$netleave = $leaver['anetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET anetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE `leave` SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Sick Leave'){
			$dif = $leaver['dif'];
			$leave = $leaver['sleaves'];
			$netleave = $leaver['snetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET anetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE `leave` SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Maternity Leave'){
			$dif = $leaver['dif'];
			$leave = $leaver['mleaves'];
			$netleave = $leaver['mnetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET mnetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE `leave` SET status='approved' WHERE leaveid='$edit_id'");	
		}
		elseif($nature=='Paternity Leave'){
			$dif = $leaver['dif'];
			$leave = $leaver['pleaves'];
			$netleave = $leaver['pnetleaves'];
			$staff = $leaver['staffid'];
			$newnet = $netleave - $dif;
			
			$db->query("UPDATE `staff` SET pnetleaves='$newnet' WHERE staffid='$staff'");		
			$db->query("UPDATE `leave` SET status='approved' WHERE leaveid='$edit_id'");	
		}
		
		header('Location: leave.php');
	}
	if(isset($_GET['reject'])){
		$edit_id = (int)$_GET['reject'];
		$db->query("UPDATE `leave` SET status='rejected' WHERE leaveid='$edit_id'");	
		header('Location: leave.php');
	}
?> 
<body>
	
    <!-- Navigation -->
	<br>
	
	<?php
		
		$sql = "select * from `leave` inner join staff on staff.staffid = `leave`.staffid where status='pending' AND hodstatus='approved' AND hrstatus='approved'";
		$sresults = $db->query($sql);
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12" align="">
				<br>
				<div class="clearfix"></div>
				<h2 class="text-center">Leave</h2><hr>
				
				<table id="table_id" class="display responsive" width="100%">
					<thead>
						<tr>
							<th>Staff No.</th>
							<th>Staff Name</th>
							<th>Nature</th>
							<th>From Date</th>
							<th>To Date</th>
							<th>Expected Date of Return</th>
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
							$title = $school['expected'];
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
							<td><a href="leave.php?approve=<?=$leaveid;?>" class="btn btn-primary">Approve</a> | <a href="leave.php?reject=<?=$leaveid;?>" class="btn btn-warning">Reject</a></td>
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

