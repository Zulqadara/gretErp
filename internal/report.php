<?php
require_once '../core.php';
include 'includes/header.php';
$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');
$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');
?>
<!DOCTYPE html>
<html lang="en">


  <body>
<?php include 'includes/navigation.php';?>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="center">
			<h2 class="text-center">Lecturer Attendance</h2><hr>
			<form class="form-inline" action="report.php" method="post">
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
			$sresults = $db->query("SELECT *, s.name as sname, c.name as cname, DATE(dt) as d
			FROM lecturerattendance as la
			inner join staff as s on la.lecturerid = s.staffid
			inner join courses as c on c.coursesid = la.unitid
			WHERE date(la.date) BETWEEN '$tos' AND '$froms';");			
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						
						<th>Lecturer Name</th>
						<th>Unit</th>
						<th>Status</th>
						<th>Date</th>
						
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						
						$name = $school['sname'];
						$unit = $school['cname'];
						$dt = $school['status'];
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$unit;?></td>
						<td><?=$dt;?></td>
						<td><?=$school['d'];?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
			<?php endif; ?>
			
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   
  </body>
<?php
include 'includes/footer.php';
?>
</html>
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
