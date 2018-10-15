<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$date = date("Y-m-d");



?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
			<div class="col-md-12" align="">
				<h3 class="text-center">Lecturer Attendance - <?=$date;?></h3><hr>

				<?php
					$sql = "select * from staff WHERE jtitle='Lecturer' OR jtitle='lecturer'
					ORDER BY name ";
					$sresults = $db->query($sql);
				?>
				
				<table class="table table-bordered table-striped">
					<thead>
					<tr>

						<th>Staff No:</th>
						<th>Name</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['staffid'];
						$name = $student['name'];
						
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$name;?></td>
						<td><a href="attendance2.php?add=<?=$studentid;?>" class="btn btn-primary">Proceed</a></td>
					</tr>
					<?php 
					endwhile; ?>
				</tbody>
				</table>
				<a href="index.php" class="btn btn-default">Cancel</a>
				
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
	
