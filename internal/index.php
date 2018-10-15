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
				<a href="report.php" class="btn btn-primary">Lecturer Attendance</a><hr>
            </div>			
			<div class="card-body">
				<a href="stdatt.php" class="btn btn-primary">Student Attendance</a><hr>
            </div>	
						<div class="card-body">
				<a href="invoices.php" class="btn btn-primary">Invoices</a><hr>
            </div>	
						<div class="card-body">
				<a href="fees.php" class="btn btn-primary">Fees per Payable Item</a><hr>
            </div>	
			<div class="card-body">
				<a href="feesbalance.php" class="btn btn-primary">Fees Balance per Payable Item</a><hr>
            </div>	
			<div class="card-body">
				<a href="stdsem.php" class="btn btn-primary">Student per Semester Report</a><hr>
            </div>
			<div class="card-body">
				<a href="stdsemc.php" class="btn btn-primary">Students per Course</a><hr>
            </div>	
						<div class="card-body">
				<a href="nofees.php" class="btn btn-primary">Students with No Fees Balance</a><hr>
            </div>
			<div class="card-body">
				<a href="yesfees.php" class="btn btn-primary">Students with Fees Balance</a><hr>
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
