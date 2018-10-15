<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
		
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$insertSql = "UPDATE studentprogramme set cert = '1' where studentid = '$edit_id'";
			$db->query($insertSql);
			header('Location: certificatecollection.php');

		}

?> 
  <body>

    <!-- Navigation -->
<br>

				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref 
			from student inner join activestudent on activestudent.studentid = student.studentid
			inner join studentprogramme on studentprogramme.studentid = student.studentid
			WHERE student.verify='1' AND studentprogramme.cert='0'
			ORDER BY studentnumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Gown Collection</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Reference ID:</th>
						<th>Student Number:</th>
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
						$ref = $student['ref'];
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
						<td><?=$ref;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="certificatecollection.php?edit=<?=$studentid;?>" class="btn btn-primary">Proceed</a></td>
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
}
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
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            }
        ]
    } );
} );
	</script>
	
