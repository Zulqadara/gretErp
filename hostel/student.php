<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();


?> 
<body>
	<?php
			$sql = "select *,  CONCAT(student.referencename, '/', student.referencemonth, '/', student.referenceyear, '/', student.referencenumber) AS ref 
			from student";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	    <a href="student2.php" class="btn btn-warning pull-right" id="add-product-btn">Unallocate Rooms <br>(used only for mistake in room allocation)</a>

<div class="clearfix"></div>
		  		<h2 class="text-center">Student Room Allocation</h2><hr>

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
						<th>Country</th>
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
						<?php 
						//	$res = $db->query("SELECT * FROM studentroom WHERE studentid='$studentid'");
							//$num=mysqli_num_rows($res);
							//if($num): ?>
							<!--<td><a href="roomallocation.php?del=<?=$studentid;?>" class="btn btn-danger">Unallocate</a></td>-->
							<?php// else : ?>
							<td><a href="roomallocation.php?add=<?=$studentid;?>" class="btn btn-primary">Allocate</a></td>
							<?php// endif; ?>
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
	
