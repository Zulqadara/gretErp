<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['student']) && isset($_GET{'room'})){
	$student = (int)$_GET['student'];
	$room = (int)$_GET['room'];
	$sql = "DELETE FROM studentroom WHERE studentid ='$student' AND roomid = '$room'";
	$sresults = $db->query($sql);
	$sql2 = "UPDATE room set available=available + 1 where roomid = '$room'";
	$sresults2 = $db->query($sql2);
	header("Location: student2.php");
}

?> 
<body>
	<?php
			$sql = "select *, room.roomid as r, CONCAT(student.referencename, '/', student.referencemonth, '/', student.referenceyear, '/', student.referencenumber) AS ref 
			from student inner join studentroom on studentroom.studentid = student.studentid
			inner join room on studentroom.roomid = room.roomid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Student Room Unallocation</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						
						<th>Reference ID:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Room No</th>
						<th>Floor</th>
						<th>Wing</th>
						<th>Capacity</th>
						<th>Available</th>
						<th>Date and Time of Insertion</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$studentref = $student['ref'];
						$name = $student['name'];
						$name2 = $student['gender'];
						$gender = $student['roomno'];
						$dob = $student['floor'];
						$email = $student['wing'];
						$phone = $student['capacity'];
						$phone2 = $student['available'];
						$country = $student['dt'];
						$roomid = $student['r'];
					?>
					<tr>
						
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$name2;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$phone2;?></td>
						<td><?=$country;?></td>
						<td><a href="student2.php?student=<?=$studentid;?>&room=<?=$roomid;?>" class="btn btn-danger">Unallocate</a></td>
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
	
