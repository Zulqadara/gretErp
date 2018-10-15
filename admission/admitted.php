<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');
$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');
?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Registered Students</h2><hr>
			<form class="form-inline" action="admitted.php" method="post">
				<div class="form-group mb-2">
			   <label for="tos">To Date*:</label>
					<input type="date" class="form-control" id="tos" name="tos" value="<?=$tos;?>" required/>
			   </div>
			   <div class="form-group mb-2">
			   <label for="froms">From Date*:</label>
					<input type="date" class="form-control" id="froms" name="froms" value="<?=$froms;?>" required />
			   </div>
			   <div class="form-group mb-2">
			   <button name="search" class="btn btn-success">Search</button>
			   </div> 
		   </form>
		      <?php
		   if(isset($_POST['search'])):
			$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');		
			$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');		
			$sresults = $db->query("select *,  CONCAT(referencename, '/', referencemonth, '/',
			referenceyear, '/', referencenumber) AS ref, registrationstatus as status, studycenter as center from student as st
			INNER JOIN studentreg as rej on rej.studentid = st.studentid
			WHERE date(st.datetime) BETWEEN '$tos' AND '$froms'
			ORDER BY referencenumber;");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Reference ID:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Phone</th>
						<th>County</th>
						<th>Status</th>
						<th>Study Center</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$count=1;
					while($student = mysqli_fetch_assoc($sresults)) : 
						$studentref = $student['ref'];
						$name = $student['name'];
						$gender = $student['gender'];
						$dob = $student['dob'];
						$email = $student['email'];
						$phone = $student['phone'];
						$country = $student['country'];
						$status = $student['status'];
						$center = $student['center'];
					?>
					<tr>
						<td><?=$count;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><?=$status;?></td>
						<td><?=$center;?></td>
					</tr>
					<?php
						$count++;
						endwhile; ?>
				</tbody>
			</table>
			<form method="post" action="admittedp.php" target="_blank">
				<input type="hidden" name="tos" value="<?=$tos;?>" />
				<input type="hidden" name="froms" value="<?=$froms;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
			<?php endif; ?>
        </div>
	<a class="btn btn-default btn-lg" href="index.php">Back</a>
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
	
