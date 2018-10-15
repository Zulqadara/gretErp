<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

$edit_id = (int)$_GET['add'];


if(isset($_GET['room']) && isset($_GET['add'])){
	$room = (int)$_GET['room'];
	$student = (int)$_GET['add'];
	$sql = "INSERT INTO studentroom (studentid, roomid) VALUES ('$student', '$room')";
	$sresults = $db->query($sql);
	$sql2 = "UPDATE room set available=available - 1 where roomid = '$room'";
	$sresults2 = $db->query($sql2);
	header("Location: student.php");
	
}
	
?> 
<body>
	<?php
			$sql = "select * from room where available > 0";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Student Room Allocation</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Room ID:</th>
						<th>Room No:</th>
						<th>Floor</th>
						<th>Wing</th>
						<th>Capacity</th>
						<th>Available</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['roomid'];
						$studentref = $student['roomno'];
						$name = $student['floor'];
						$gender = $student['wing'];
						$dob = $student['capacity'];
						$email = $student['available'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><a href="roomallocation.php?add=<?=$edit_id;?>&room=<?=$studentid;?>" class="btn btn-success">Allocate</a></td>
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
	jQuery('document').ready(function(){
		get_child_options('<?=$programs;?>');
	});
</script>
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
	
