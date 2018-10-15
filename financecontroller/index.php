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
				<a href="expense.php" class="btn btn-primary">Approve/Reject Expenses</a><hr>
            </div>
			<div class="card-body">
				<a href="petty.php" class="btn btn-primary">Petty Cash Payments</a><hr>
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
