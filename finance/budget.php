<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$semesterQ = $db->query("SELECT * FROM semesters");
	$expenseQ = $db->query("SELECT * FROM expensecode");
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$expense = ((isset($_POST['expense']) && $_POST['expense'] !='')?ss($_POST['expense']):'');
	
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM budget where budgetid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['amount']);
			$expense = ((isset($_POST['expense']) && $_POST['expense'] !='')?ss($_POST['expense']):$r['expensecodeid']);
		
			$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):$r['semester']);
	
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'semester', 'expense');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		if(!isset($_GET['edit'])){
			$valQ = $db->query("SELECT * FROM budget WHERE name='$name' AND semester='$semester'");
			$valC = mysqli_num_rows($valQ);
				
			if($valC != 0){
				$errors[] = 'That Expense Type Already Exists.';
			}
		}

		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO budget (amount, semester, expensecodeid)
			VALUES ('$name', '$semester', '$expense')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE budget SET amount='$name', semester='$semester', expensecodeid='$expense'
				WHERE budgetid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: budget.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Allocate ') ;?> Budget</h3><hr>
				<form action="budget.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Budget Info</legend>
				<div class="form-group">
						<label for="semester">Semester*:</label>
						<select class="form-control" id="semester" name="semester" required>
							<option value=""<?=(($semester == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
								<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
				</div>				
				<div class="form-group">
						<label for="expense">Expense Name*:</label>
						<select class="form-control" id="expense" name="expense" required>
							<option value=""<?=(($expense == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($expenseQ)) : ?>
								<option value="<?= $p['expensecodeid']; ?>"<?=(($expense == $p['expensecodeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
				</div>
				<div class="form-group">
					<label for="name">Amount*:</label>
					<input type="number" min="0" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
				</div>	
					<a href="budget.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Allocate ') ;?> Budget" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *, expensecode.name as c, budget.amount as a,
			semesters.name as s from expensecode 
			inner join budget on budget.expensecodeid = expensecode.expensecodeid
			inner join semesters on budget.semester = semesters.semesterid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="budget.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Allocate Budget</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Budget Allocation</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Expense Type</th>
						<th>Budget Allocated</th>
						<th>Semester</th>
						<th>Date</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['budgetid'];
						$name = $school['c'];
						$a = $school['a'];
						$semester = $school['s'];
						$date = $school['dt'];
						
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$a;?></td>
						<td><?=$semester;?></td>
						<td><?=$date;?></td>
						<td><a href="budget.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
}
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
	
