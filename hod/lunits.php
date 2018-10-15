<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';

?> 
  <body>
	<?php
			$sql = "select * from staff WHERE jtitle='Lecturer' OR jtitle='lecturer'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Lecturer Unit Allocation</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff ID:</th>
						
						<th>Name</th>
						<th>Office Email</th>
						<th>Department</th>
						<th>Contract Type</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['staffid'];
						
						$name1 = $student['name'];
						$name = $student['oemail'];
						$gender = $student['department'];
						$dob = $student['type'];
						
						
						
					?>
					<tr>
						<td><?=$studentid;?></td>
						
						<td><?=$name1;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><a href="unitallocation.php?add=<?=$studentid;?>" class="btn btn-primary">Allocate</a></td>
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
		 "order": [[ 1, "desc" ]],
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
	
