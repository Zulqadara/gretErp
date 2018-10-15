<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

	$semesterQ = $db->query("SELECT * FROM semesters");
	$year=date("Y");
	
	$expense = ((isset($_POST['expense']) && $_POST['expense'] !='')?ss($_POST['expense']):'');
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	$amount = ((isset($_POST['amount']) && $_POST['amount'] !='')?ss($_POST['amount']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	$details = ((isset($_POST['details']) && $_POST['details'] !='')?ss($_POST['details']):'');
	
	if(isset($_POST['sub'])){
		
	$expense = ((isset($_POST['expense']) && $_POST['expense'] !='')?ss($_POST['expense']):'');
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	$amount = ((isset($_POST['amount']) && $_POST['amount'] !='')?ss($_POST['amount']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	$details = ((isset($_POST['details']) && $_POST['details'] !='')?ss($_POST['details']):'');
	
		$db->query("INSERT INTO petty (name, amount, expenseid, semesterid, paymentformid, details) VALUES ('$name', '$amount', '$expense', '$semester', '$type', '$details')");
		header('Location: index.php');
			
		
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center">Petty Cash Payments</h3><hr>
				<form action="petty.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
						<label for="semester">Semester*:</label>
						<select class="form-control" id="semester" name="semester" required>
							<option value=""<?=(($semester == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
								<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<?php if(!isset($_POST['cf'])): ?>
						<a href="studentcourses.php" class="btn btn-default">Cancel</a>
					<?php endif; ?>
					<button name="cf" class="btn btn-primary"><?=((isset($_POST['cf']))?'Refresh':'Next');?></button>
				<?php
						if(isset($_POST['cf'])) :
							$program = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
							//echo $program;

						$expenseQ = $db->query("select * from expense where semester='$semester' and year(dt) = '$year'");
						
						?>
						<br>
						
						<hr>
						<div class="form-group">
						<label for="name">Payment Receiver Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>"required />
					</div>
					<div class="form-group">
				<label for="expense">Purpose of Payment*:</label>
					<select class="form-control" id="expense" name="expense" required>
						<option value=""<?=(($expense == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($expenseQ)) : ?>
							<option value="<?= $p['expenseid']; ?>"<?=(($expense == $p['expenseid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
						<label for="amount">Payment Amount*:</label>
						<input type="number" min="0" class="form-control" name="amount" id="amount" value="<?=$amount; ?>" required/>
					</div>					
					<div class="form-group">
						<label for="type">Payment Type*:</label><br>
						<?php
							$payQ = "SELECT * FROM paymentforms";
							$payR = $db ->query($payQ);
							while($pay = mysqli_fetch_assoc($payR)) : 
						?>
						<input required type="radio" name="type" value="<?=$pay['paymentformsid'];?>"> <?=$pay['name'];?><br>
						<?php endwhile; ?>
					</div>
					<div class="form-group">
						<label for="details"> Payment Details (Mpesa code, etc)</label>
						<input type="text" name="details" id="details" class="form-control" required/>
					</div>
						<a href="index.php" class="btn btn-default">Cancel</a>
						<input type="submit" name="sub" value="Submit" class="btn btn-success" />
				
						
					<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
		<br>	
</body>		
<?php
include 'includes/footer.php';
?>
	<script>
	jQuery('document').ready(function(){
		get_child_options('<?=$programs;?>');
	});
</script>
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
		 "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
    } );
} );
	</script>
	
