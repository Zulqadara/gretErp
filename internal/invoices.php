<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$tos = ((isset($_POST['tos']) && $_POST['tos'] !='')?ss($_POST['tos']):'');
$froms = ((isset($_POST['froms']) && $_POST['froms'] !='')?ss($_POST['froms']):'');

?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Invoices</h2><hr>
			<form class="form-inline" action="invoices.php" method="post">
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
			$sresults = $db->query("select *,student.studentnumber as stnum, fees.name as fname FROM studentinvoice st
			inner join feestypes fees on fees.feestypesid = st.feesid
			inner join studentfees on studentfees.studentfeesid = st.studentfeesid
										inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
										inner join student on studentprogramme.studentid = student.studentid
			WHERE date(st.dt) BETWEEN '$tos' AND '$froms';");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
					<th>#</th>
					<th>Student Number:</th>
						<th>Fees Type:</th>
						<th>Amount:</th>
						<th>Paid</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$count = 1;
					while($student = mysqli_fetch_assoc($sresults)) : 
						$namew = $student['fname'];
						$studentref = $student['amount'];
						$name = $student['paid'];
						$gender = $student['dt'];
					?>
					<tr>
						<td><?=$count;?></td>
						<td><?=$student['stnum'];?></td>
						<td><?=$namew;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
					</tr>
					<?php 
						$count++;
						endwhile; ?>
				</tbody>
			</table>
			<form method="post" action="invoicesp.php" target="_blank">
				<input type="hidden" name="tos" value="<?=$tos;?>" />
				<input type="hidden" name="froms" value="<?=$froms;?>" />
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
	
