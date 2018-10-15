<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['approve'])){
	$edit_id = (int)$_GET['approve'];
	$db->query("UPDATE `expense` SET status='approved' WHERE expenseid='$edit_id'");	
	header('Location: expense.php');
}
if(isset($_GET['reject'])){
	$edit_id = (int)$_GET['reject'];
	$db->query("UPDATE `expense` SET status='rejected' WHERE expenseid='$edit_id'");	
	header('Location: expense.php');
}
?> 
  <body>

    <!-- Navigation -->
<br>
    
				<?php
	
			$sql = "select *, expense.name as i,  expensecode.name as c,
			semesters.name as s from expense inner join semesters on expense.semester = semesters.semesterid 
			inner join expensecode on expensecode.expensecodeid = expense.expensecodeid
			where status='pending'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  
<div class="clearfix"></div>
		  		<h2 class="text-center">Approve/Reject Expenses</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Expense ID:</th>
						<th>Expense Type</th>
						<th>Expense Description</th>
						<th>Semester</th>
						<th>Date</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$expenseid = $school['expenseid'];
						$desc = $school['i'];
						$name = $school['i'];
						$semester = $school['s'];
						$date = $school['dt'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$expenseid;?></td>
						<td><?=$name;?></td>
						<td><?=$desc;?></td>
						<td><?=$semester;?></td>
						<td><?=$date;?></td>
						<td><?=$status;?></td>
					<td><a href="expense.php?approve=<?=$expenseid;?>" class="btn btn-primary">Approve</a> | <a href="expense.php?reject=<?=$expenseid;?>" class="btn btn-warning">Reject</a></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
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
	
