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
			$Q = $db->query("SELECT * FROM expense where expenseid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
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

		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO expense (name, semester, expensecodeid)
			VALUES ('$name', '$semester', '$expense')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE expense SET name='$name', semester='$semester', expensecodeid='$expense'
				WHERE expenseid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: expense.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Expense</h3><hr>
				<form action="expense.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Expense Info</legend>
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
					<label for="name">Expense Description*:</label>
					<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
				</div>	
					<a href="expense.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Expense" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *, expense.name as i, expensecode.name as c,
			semesters.name as s from expense 
			inner join semesters on expense.semester = semesters.semesterid
			inner join expensecode on expensecode.expensecodeid = expense.expensecodeid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="expense.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Expense</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Expense</h2><hr>

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
						$schoolid = $school['expenseid'];
						$desc = $school['i'];
						$name = $school['c'];
						$semester = $school['s'];
						$date = $school['dt'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><?=$desc;?></td>
						<td><?=$semester;?></td>
						<td><?=$date;?></td>
						<td><?=$status;?></td>
						<td><a href="expense.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
