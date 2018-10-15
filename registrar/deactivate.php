<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['edit'])){
	
		$edit_id = (int)$_GET['edit'];	
				$insertSql = "UPDATE student SET status='0'
				WHERE studentid='$edit_id'";
				$db->query($insertSql);
	
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Student Deactivated')
			window.location.href='deactivate.php';
			</SCRIPT>");
		}
?> 
  <body>

    <!-- Navigation -->
<br>
				<?php
		
			$sql = "select *
			from student
			WHERE status='1' and
			EXISTS (SELECT *
                   FROM   studentreg od
                   WHERE  student.studentid = od.studentid)  
				   ORDER BY referencenumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Deactivate Student</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Student Number:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Phone</th>
						<th>County</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
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
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="deactivate.php?edit=<?=$studentid;?>" class="btn btn-danger">Deactivate</a></td>
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
                "visible": false,
                "searchable": false
            }
        ]
    } );
} );
	</script>
	
