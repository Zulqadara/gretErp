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
		  		<h2 class="text-center">Profit and Loss Statement</h2><hr>
			<form class="form-inline" action="pnl.php" method="post">
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
			$sresults = $db->query("SELECT sum(sf.paid) as ftot 
			FROM studentinvoicedetails sf
			WHERE date(sf.datepaid) BETWEEN '$tos' AND '$froms';");	
			$sresults2 = $db->query("SELECT *, sum(gross) as fnet
			FROM payroll as pi
			WHERE date(dt) BETWEEN '$tos' AND '$froms';");		
			$sresults3 = $db->query("SELECT *, sum(amount) as tincome
			FROM income as ic
			WHERE date(dt) BETWEEN '$tos' AND '$froms';");	
			$sresults4 = $db->query("SELECT *, sum(pet.amount) as texpense
			FROM petty as pet inner join expense as exp on exp.expenseid = pet.expenseid
			WHERE date(pet.dt) BETWEEN '$tos' AND '$froms' AND exp.status='approved';");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						
						<th>Name</th>
						<th>Amount</th>
						
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						
						$name = $school['ftot'];
						
					?>
					<tr>
						<td>Total Fees Paid</td>
						<td><?=$name;?></td>
						
					</tr>
					<?php endwhile; ?>
					<?php while($school = mysqli_fetch_assoc($sresults2)) : 
						$name2 = $school['fnet'];
					?>
					<tr>
						<td style="color: red">Gross Salary</td>
						<td style="color: red"><?=$name2;?></td>
						
					</tr>
					<?php endwhile; ?>
					<?php while($school = mysqli_fetch_assoc($sresults3)) : 
						$name3 = $school['tincome'];
					?>
					<tr>
						<td>Income</td>
						<td><?=$name3;?></td>
						
					</tr>
					<?php endwhile; ?>
					<?php while($school = mysqli_fetch_assoc($sresults4)) : 
						$name4 = $school['texpense'];
					?>
					<tr>
						<td style="color: red">Expenses</td>
						<td style="color: red"><?=$name4;?></td>
						
					</tr>
					<?php endwhile; ?>
				</tbody>
				<thead>
					<tr>
						<th>Profit</th>
						<th>Loss</th>		
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$profit = $name + $name3;?></td>
						<td>(<?=$loss = $name2 + $name4;?>)</td>
					</tr>
					<tr>
						<td><b>Balance</b></td>
						<td><b><u><?=$profit - $loss;?></b></u></td>
					</tr>
				</tbody>
			</table>
			<form method="post" action="pnlp.php" target="_blank">
				<input type="hidden" name="tos" value="<?=$tos;?>" />
				<input type="hidden" name="froms" value="<?=$froms;?>" />
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
			<?php endif; ?>
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
	
