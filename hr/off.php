<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['approve'])){
	$edit_id = (int)$_GET['approve'];
	$db->query("UPDATE `offday` SET hrstatus='approved' WHERE offdayid='$edit_id'");	
	header('Location: off.php');
}
if(isset($_GET['reject'])){
	$edit_id = (int)$_GET['reject'];
	$db->query("UPDATE `offday` SET hrstatus='rejected' WHERE offdayid='$edit_id'");	
	header('Location: off.php');
}
?> 
  <body>

    <!-- Navigation -->
<br>
    
				<?php
	
			$sql = "select * from `offday` inner join staff on staff.staffid = `offday`.staffid where status='pending' AND hodstatus='approved' AND hrstatus='pending'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  
<div class="clearfix"></div>
		  		<h2 class="text-center">Off Day Application</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff No</th>
						<th>Name</th>
						<th>Day and Date Worked</th>
						<th>Nature</th>
						<th>Number of Days</th>
						<th>Days and Dates</th>
						<th>Supervisor</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$no = $school['staffid'];
						$nm = $school['name'];
						$offid = $school['offdayid'];
						$day = $school['day'];
						$name = $school['nature'];
						$code = $school['days'];
						
						$title = $school['dates'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$no;?></td>
						<td><?=$nm;?></td>
						<td><?=$day;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$status;?></td>
					<td><a href="off.php?approve=<?=$offid;?>" class="btn btn-primary">Approve</a> | <a href="off.php?reject=<?=$offid;?>" class="btn btn-warning">Reject</a></td>
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
	
