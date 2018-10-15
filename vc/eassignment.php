<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['approve'])){
	$edit_id = (int)$_GET['approve'];
	$db->query("UPDATE `eassignment` SET status='approved' WHERE eassignmentid='$edit_id'");	
	header('Location: eassignment.php');
}
if(isset($_GET['reject'])){
	$edit_id = (int)$_GET['reject'];
	$db->query("UPDATE `eassignment` SET status='rejected' WHERE eassignmentid='$edit_id'");	
	header('Location: eassignment.php');
}
?> 
  <body>

    <!-- Navigation -->
<br>
    
				<?php
	
			$sql = "select * from `eassignment` 
			inner join staff on staff.staffid = `eassignment`.staffid
			where status='pending' AND hodstatus='approved' AND hrstatus='approved'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  
<div class="clearfix"></div>
		  		<h2 class="text-center">External Assignment</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff No.</th>
						<th>Staff Name</th>
						<th>Nature</th>
						<th>Date of Assignment</th>
						<th>Date Expected to Work</th>
						<th>Supervisor</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) :
						
						$no = $school['staffid'];					
						$nm = $school['name'];
						$eassignmentid = $school['eassignmentid'];
						$name = $school['nature'];
						$code = $school['froms'];
						
						$title = $school['expected'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$no;?></td>
						<td><?=$nm;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$status;?></td>
					<td><a href="eassignment.php?approve=<?=$eassignmentid;?>" class="btn btn-primary">Approve</a> | <a href="eassignment.php?reject=<?=$eassignmentid;?>" class="btn btn-warning">Reject</a></td>
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
	
