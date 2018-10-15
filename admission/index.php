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
				<a href="applicants.php" class="btn btn-primary">Applicants</a><hr>
            </div>
			 <div class="card-body">
				<a href="register.php" class="btn btn-primary">Admit Students</a><hr>
            </div>
			   <div class="card-body">
				<a href="upload.php" class="btn btn-primary">Upload New Student Documents</a><hr>
            </div>	
 <div class="card-body">
				<a href="admitted.php" class="btn btn-primary">Admitted Students Report</a><hr>
            </div>	
 <div class="card-body">
				<a href="applied.php" class="btn btn-primary">Applied Students Report</a><hr>
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
