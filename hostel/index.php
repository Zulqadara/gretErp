<?php
require_once '../core.php';
include 'includes/header.php';

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

    
		  
          <div class="card mb-4">
            <div class="card-body">
				<a href="room.php" class="btn btn-primary">Room Management</a><hr>
            </div>
			   <div class="card-body">
				<a href="student.php" class="btn btn-primary">Allocate & Manage Student Rooms</a><hr>
            </div>
  <div class="card-body">
				<a href="report.php" class="btn btn-primary">Student Occupied Rooms Reports</a><hr>
            </div>	
			  <div class="card-body">
				<a href="report2.php" class="btn btn-primary">Unoccupied Rooms Reports</a><hr>
            </div>	
          </div>
		  
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
