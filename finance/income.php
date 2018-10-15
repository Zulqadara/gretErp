<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$semesterQ = $db->query("SELECT * FROM semesters");
	
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$amount = ((isset($_POST['amount']) && $_POST['amount'] !='')?ss($_POST['amount']):'');
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM income where incomeid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			$amount = ((isset($_POST['amount']) && $_POST['amount'] !='')?ss($_POST['amount']):$r['amount']);
			$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):$r['semester']);
	
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'amount', 'semester');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}

		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO income (name, amount, semester)
			VALUES ('$name', '$amount', '$semester')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE income SET name='$name', amount='$amount', semester='$semester'
				WHERE incomeid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: income.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Income</h3><hr>
				<form action="income.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Income Info</legend>
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
						<label for="name">Income Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="amount">Income Amount*:</label>
						<input type="number" min="0" class="form-control" name="amount" id="amount" value="<?=$amount; ?>" required/>
					</div>
					
					<a href="income.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Income" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *, income.name as i, semesters.name as s from income inner join semesters on income.semester = semesters.semesterid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="income.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Income</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Income</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Income ID:</th>
						<th>Income Name</th>
						<th>Income Amount</th>
						<th>Semester</th>
						<th>Date</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['incomeid'];
						$name = $school['i'];
						$amount = $school['amount'];
						$semester = $school['s'];
						$date = $school['dt'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><?=$amount;?></td>
						<td><?=$semester;?></td>
						<td><?=$date;?></td>
						<td><a href="income.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
