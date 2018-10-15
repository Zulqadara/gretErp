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
		  		<h2 class="text-center">Expenses</h2><hr>
			<form class="form-inline" action="expenser.php" method="post">
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
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');		
			$sresults = $db->query("select expense.name as e, expensecode.name as ex, petty.amount as amount, petty.dt as date from expense
			inner join expensecode on expensecode.expensecodeid = expense.expensecodeid
			inner join petty on petty.expenseid = expense.expenseid
			WHERE date(petty.dt) BETWEEN '$tos' AND '$froms' and expense.status='approved';");				
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Expense Code:</th>
						<th>Expense:</th>
						<th>Amount:</th>
						<th>Date:</th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($student = mysqli_fetch_assoc($sresults)) : 
						
						$name = $student['ex'];
						$dob = $student['e'];
						$paid = $student['amount'];
						$email = $student['date'];
						
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$dob;?></td>
						<td><?=$paid;?></td>
						<td><?=$email;?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
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
	
