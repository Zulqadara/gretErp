<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';

if(isset($_GET['add'])){
	$edit_id = (int)$_GET['add'];
	$sql = "INSERT INTO odlunits (unitid) VALUES ('$edit_id')";
	$sresults = $db->query($sql);
	header("Location: lunits2.php");
}
if(isset($_GET['del'])){
	$edit_id = (int)$_GET['del'];
	$sql = "DELETE FROM odlunits WHERE unitid ='$edit_id'";
	$sresults = $db->query($sql);
	header("Location: lunits2.php");
}
?> 
  <body>
	<?php
			$sql = "select *, courses.name as cname, schools.name as sname, programs.name as pname, courses.code as ccode 
			from courses inner join programs on courses.programsid = programs.programsid
			INNER JOIN schools on programs.schoolid = schools.schoolid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">ODL Modules Units Allocation</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Unit:</th>
						<th>Unit Code:</th>
						<th>Programme</th>
						<th>School</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['coursesid'];
						$studentref = $student['cname'];
						$name1 = $student['ccode'];
						$name = $student['pname'];
						$gender = $student['sname'];
						
						
						
						
					?>
					<tr>
						<td><?=$studentref;?></td>
						<td><?=$name1;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<?php 
							$res = $db->query("SELECT * FROM odlunits WHERE unitid='$studentid'");
							$num=mysqli_num_rows($res);
							if($num): ?>
						<td><a href="lunits2.php?del=<?=$studentid;?>" class="btn btn-danger">Unallocate</a></td>
						<?php else : ?>
						<td><a href="lunits2.php?add=<?=$studentid;?>" class="btn btn-primary">Allocate</a></td>
						<?php endif; ?>
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
		 "order": [[ 1, "desc" ]]
    } );
} );
	</script>
	
