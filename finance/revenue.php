<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
	$date = date("Y-m-d");
	$semesterQ = $db->query("SELECT * FROM semesters");	
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Statement of Revenue Allocation</h2><hr>
			<form class="form-inline" action="revenue.php" method="post">
				<div class="form-group mb-2">
						<label for="semester">Semester*:</label>
						<select class="form-control" id="semester" name="semester" required>
							<option value=""<?=(($semester == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
								<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
				</div>
			   <div class="form-group mb-2">
			   <button name="search" class="btn btn-success">Proceed</button>
			   </div> 
		   </form>
		      <?php
		   if(isset($_POST['search'])):
			$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
			$sresults = $db->query("select *
from budget bud
left outer join 
(
select sum(pet.amount) as pam ,  pet.pettyid, 
pet.semesterid, pet.dt, pet.expenseid, ex.`status`, exc.expensecodeid, exc.name
from petty as pet
inner join expense as ex 
on ex.expenseid = pet.expenseid
inner join expensecode exc 
on ex.expensecodeid = exc.expensecodeid
group by exc.expensecodeid
) as t
on bud.expensecodeid = t.expensecodeid
where year(bud.dt) = '$date' and year(t.dt) = '$date'
 and bud.semester='$semester' and t.semesterid='$semester' 
 and t.`status`='approved'




");	
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>				
						<th>Expense Type Name</th>
						<th>Amount Allocated</th>
						<th>Amount Spent</th>	
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						
						$name = $school['name'];
						$am = $school['amount'];
						$sam = $school['pam'];
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$am;?></td>
						<td><?=$sam;?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
			<form method="post" action="revenuep.php" target="_blank">
				<input type="hidden" name="semester" value="<?=$semester;?>" />
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
	
