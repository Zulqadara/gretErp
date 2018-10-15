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
		  		<h2 class="text-center">Fees With Balance per Payable Item</h2><hr>
			<form class="form" action="feesbalance.php" method="post">
				<div class="form-group mb-2">
			   <label for="tos">To Date*:</label>
					<input type="date" class="form-control" id="tos" name="tos" value="<?=$tos;?>" required/>
			   </div>
			   <div class="form-group mb-2">
			   <label for="froms">From Date*:</label>
					<input type="date" class="form-control" id="froms" name="froms" value="<?=$froms;?>" required />
			   </div>
			   <div class="form-group mb-2">
									<label for="type">Fees Type*:</label><br>
									<?php
										$payQ = "SELECT * FROM feestypes";
										$payR = $db ->query($payQ);
										while($pay = mysqli_fetch_assoc($payR)) : 
									?>
									<input type="radio" name="type" value="<?=$pay['feestypesid'];?>" required> <?=$pay['name'];?>
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
			$sresults = $db->query("select student.studentnumber as stnum, feestypes.name as name,  amount, paid, (amount - paid) as balance, studentinvoice.dt as dt1 from studentinvoice
										inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
											inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
										inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
										inner join student on studentprogramme.studentid = student.studentid
										WHERE date(studentinvoice.dt) BETWEEN '$tos' AND '$froms' and studentinvoice.feesid='$type'
										having balance > 0;");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
					<th>#</th>
					<th>Student Number:</th>
						<th>Fees Type:</th>
						<th>Amount:</th>
						<th>Paid:</th>
						<th>Balance:</th>
						<th>Date:</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$count=1;
					while($student = mysqli_fetch_assoc($sresults)) : 
						
						$name = $student['name'];
						$dob = $student['amount'];
						$paid = $student['paid'];
						$email = $student['dt1'];
						
					?>
					<tr>
					<td><?=$count;?></td>
					<td><?=$student['stnum'];?></td>
						<td><?=$name;?></td>
						<td><?=$dob;?></td>
						<td><?=$paid;?></td>
						<td><?=$student['balance'];?></td>
						<td><?=$email;?></td>
					</tr>
					<?php
						$count++;
						endwhile; ?>
				</tbody>
			</table>
			<form method="post" action="feesbalancep.php" target="_blank">
				<input type="hidden" name="tos" value="<?=$tos;?>" />
				<input type="hidden" name="froms" value="<?=$froms;?>" />
				<input type="hidden" name="type" value="<?=$type;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
</form>
			<?php endif; ?>
        </div>
		<a class="btn btn-default btn-lg" href="index.php">Back</a>

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
	
