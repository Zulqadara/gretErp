<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');
$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');
$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Payment Made per Different Methods</h2><hr>
			<form class="form" action="paymenttype.php" method="post">
				<div class="form-group mb-2">
			   <label for="tos">To Date*:</label>
					<input type="date" class="form-control" id="tos" name="tos" value="<?=$tos;?>" required/>
			   </div>
			   <div class="form-group mb-2">
			   <label for="froms">From Date*:</label>
					<input type="date" class="form-control" id="froms" name="froms" value="<?=$froms;?>" required />
			   </div>
			   <div class="form-group mb-2">
									<label for="type">Payment Type*:</label><br>
									<?php
										$payQ = "SELECT * FROM paymentforms";
										$payR = $db ->query($payQ);
										while($pay = mysqli_fetch_assoc($payR)) : 
									?>
									<input type="radio" name="type" value="<?=$pay['paymentformsid'];?>" required> <?=$pay['name'];?>
									<?php endwhile; ?>
								</div>
			   <div class="form-group mb-2">
			   <button name="search" class="btn btn-success">Search</button>
			   </div> 
		   </form>
		      <?php
		   if(isset($_POST['search'])):
			$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');		
			$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');		
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');		
			$sresults = $db->query("select paymentforms.name as name, pdetails, paid, datepaid, reversed from studentinvoicedetails
	
		inner join paymentforms on paymentforms.paymentformsid = studentinvoicedetails.paymentform
 
WHERE date(timepaid) BETWEEN '$tos' AND '$froms' and studentinvoicedetails.paymentform='$type'");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Payment Form:</th>
						<th>Payment Code:</th>
						<th>Amount Paid:</th>
						<th>Date:</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					$count= 1;
					while($student = mysqli_fetch_assoc($sresults)) : 
						
						$name = $student['name'];
						$gender = $student['pdetails'];
						$dob = $student['paid'];
						$email = $student['datepaid'];
						
						
					?>
					<tr>
						<td><?=$count;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						
					</tr>
					<?php
						$count++;
						endwhile; ?>
				</tbody>
			</table>
										<form method="post" action="paymenttypep.php" target="_blank">
				<input type="hidden" name="tos" value="<?=$tos;?>" />
				<input type="hidden" name="froms" value="<?=$froms;?>" />
				<input type="hidden" name="type" value="<?=$type;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
			<?php endif; ?>
			<br>
			<a class="btn btn-primary btn-lg" href="index.php">Back</a>
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
	
