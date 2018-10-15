<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
	$date = date("Y-m-d");
	$semesterQ = $db->query("SELECT * FROM semesters");	
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Students Occupying Rooms</h2><hr>
		      <?php
			$sresults = $db->query("SELECT *, student.studentnumber as name from room
			INNER JOIN studentroom on studentroom.roomid = room.roomid
			INNER JOIN student on student.studentid = studentroom.studentid
			");	
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>				
						<th>#</th>
						<th>Student Number</th>
						<th>Room No</th>
						<th>Floor</th>	
						<th>Wing</th>	
						<th>Capacity</th>	
						<th>Avaialble</th>
						<th>Student Date of Entry</th>	
					</tr>
				</thead>
				<tbody>
					<?php 
					$count=1;
					while($school = mysqli_fetch_assoc($sresults)) : 					
					?>
					<tr>
						<td><?=$count;?></td>
						<td><?=$school['name'];?></td>
						<td><?=$school['roomno'];?></td>
						<td><?=$school['floor'];?></td>
						<td><?=$school['wing'];?></td>
						<td><?=$school['capacity'];?></td>
						<td><?=$school['available'];?></td>
						<td><?=$school['dt'];?></td>
					</tr>
					<?php
						$count++;
						endwhile; ?>
				</tbody>
			</table>
        </div>
		<a class="btn btn-default btn-lg" href="index.php">Back</a>
		<form method="post" action="reportp.php" target="_blank">
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
			
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
	
