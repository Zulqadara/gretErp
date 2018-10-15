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
				<a href="create.php" class="btn btn-primary">Create Course, Programmes, Semesters, etc</a><hr>
            </div>
			
			<div class="card-body">
				<a href="callocation.php" class="btn btn-primary">Allocate Course elements</a><hr>
            </div>
			<div class="card-body">
				<a href="yeardates.php" class="btn btn-primary">Key In Year Start and End Dates</a><hr>
            </div>
			<div class="card-body">
				<a href="sponsorship.php" class="btn btn-primary">Create Types of Sponsorship</a><hr>
            </div>
			<div class="card-body">
				<a href="students.php" class="btn btn-primary">View All Students</a><hr>
            </div>
			<div class="card-body">
				<a href="verify.php" class="btn btn-primary">Verify Student Details and Generate Student Number</a><hr>
            </div>
						<div class="card-body">
				<a href="register.php" class="btn btn-primary">Student Number Registry for Continuing Students (Students That Already Have A Student Number)</a><hr>
            </div>
<div class="card-body">
				<a href="deactivate.php" class="btn btn-primary">Deactivate Student</a><hr>
            </div>
			<div class="card-body">
				<a href="deactivated.php" class="btn btn-primary">Deactivated Students</a><hr>
            </div>
			<div class="card-body">
				<a href="stdsem.php" class="btn btn-primary">Student per Semester Report</a><hr>
            </div>	
			<div class="card-body">
				<a href="exammarks.php" class="btn btn-primary">Exam Marks per Semester Report</a><hr>
            </div>	
			<div class="card-body">
				<a href="nofees.php" class="btn btn-primary">Students with No Fees Balance</a><hr>
            </div>
			<div class="card-body">
				<a href="yesfees.php" class="btn btn-primary">Students with Fees Balance</a><hr>
            </div>
			<div class="card-body">
				<a href="stdsemc.php" class="btn btn-primary">Students per Course</a><hr>
            </div>	
			<div class="card-body">
				<a href="stdsemc2.php" class="btn btn-primary">Students per Course with No Fee Balance</a><hr>
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
