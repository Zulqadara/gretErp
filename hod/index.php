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
				<a href="leave.php" class="btn btn-primary">Leave Application Processing</a><hr>
            </div>
			<div class="card-body">
				<a href="hour.php" class="btn btn-primary">Hour Leave Application Processing</a><hr>
            </div>
 <div class="card-body">
				<a href="overtime.php" class="btn btn-primary">Overtime Request Processing</a><hr>
            </div>
 <div class="card-body">
				<a href="eassignment.php" class="btn btn-primary">External Assignment Processing</a><hr>
            </div>
 <div class="card-body">
				<a href="off.php" class="btn btn-primary">Offday Application Processing</a><hr>
            </div>	
			<div class="card-body">
				<a href="lunits.php" class="btn btn-primary">Lecturers Unit Allocation</a><hr>
            </div>
            <div class="card-body">
				<a href="attendance.php" class="btn btn-primary">Lecturers Attendance</a><hr>
            </div>
			   <div class="card-body">
				<button type="button" class="btn btn-primary">Generate Student Class Attendance Matrix</button><hr>
            </div>
			<div class="card-body">
				<button type="button" class="btn btn-primary">Generate Exam Matrix</button><hr>
            </div>	
<div class="card-body">
				<a href="lecturerrep.php" class="btn btn-primary">Lecturers Report</a><hr>
            </div>		
			<div class="card-body">
				<a href="stdatt.php" class="btn btn-primary">Student Attendance</a><hr>
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
