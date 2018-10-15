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
				<a href="attendance.php" class="btn btn-primary">Class Attendance</a><hr>
            </div>
			   <div class="card-body">
				<a href="exam.php" class="btn btn-primary">Exam Marks Entry</a><hr>
            </div>	
			<div class="card-body">
				<a href="reports.php" class="btn btn-primary">Students List</a><hr>
            </div>
			<div class="card-body">
				<a href="areports.php" class="btn btn-primary">Students Attendance Report</a><hr>
            </div>	
						   <div class="card-body">
				<a href="exammarks.php" class="btn btn-primary">Exam Marks</a><hr>
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
