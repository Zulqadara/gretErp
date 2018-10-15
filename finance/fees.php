<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';

$edit_id = (int)$_GET['add'];

	$semesterQ = $db->query("SELECT * FROM semesters");
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
	$yearQ = $db->query("SELECT * FROM yearsofstudy");
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	$stageQ = $db->query("SELECT * FROM stages");
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
	
	
$sql = "select * from studentprogramme
inner join studentfees on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
where studentid = '$edit_id' ORDER BY tamount DESC";
$results = $db->query($sql);
	
	if(isset($_POST['pay'])){
		$date = date("Y-m-d");
		$iid = ((isset($_POST['iid']) && $_POST['iid'] !='')?ss($_POST['iid']):'');
		$amount = ((isset($_POST['amount']) && $_POST['amount'] !='')?ss($_POST['amount']):'');
		$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
		$details = ((isset($_POST['details']) && $_POST['details'] !='')?ss($_POST['details']):'');
		$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
		$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
		$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
		//$db->query("UPDATE studentinvoice SET paid=paid + '$amount' where studentinvoiceid = '$iid'");
		$db->query("UPDATE studentfees SET tpaid=tpaid + '$amount' where studentfeesid = '$iid'");
		$db->query("INSERT INTO studentinvoicedetails 
		(studentinvoiceid, paymentform, pdetails, paid, datepaid, semester, year, stage, staffid)
		values ('$iid', '$type','$details','$amount','$date', '$semester', '$year', '$stage', '$staffid')");
		$billid = $db->insert_id;
		//header("Location: fees.php?add=$edit_id");
				echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.open('receipt.php?add=$edit_id&bill=$billid');
		</SCRIPT>");
	}
	
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">
		<div class="row">
			<div class="col-md-12" align="">
			<h3 class="text-center">Fees</h3><hr>
			<form action="fees.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
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
					<label for="year">Year of Study*:</label>
					<select class="form-control" id="year" name="year" required>
						<option value=""<?=(($year == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($yearQ)) : ?>
							<option value="<?= $p['yearsid']; ?>"<?=(($year == $p['yearsid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="stage">Stage*:</label>
					<select class="form-control" id="stage" name="stage" required>
						<option value=""<?=(($stage == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($stageQ)) : ?>
							<option value="<?= $p['stagesid']; ?>"<?=(($stage == $p['stagesid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<?php if(!isset($_POST['cf'])): ?>
						<a href="studentfees.php" class="btn btn-default">Cancel</a>
					<?php endif; ?>
					<button name="cf" class="btn btn-primary"><?=((isset($_POST['cf']))?'Refresh':'Next');?></button>
					<br>
					<?php
						if(isset($_POST['cf'])) :
						$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
						$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
						$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
						?>
				<br>
				<div class="table-responsive">
				  <table class="table">
					<thead>
						
						<th>Amount</th>
						<th>Paid</th>
						<th>Balance</th>
						<th>Invoice Date</th>
						<th></th>
					</thead>
					<tbody>
						<?php while($result = mysqli_fetch_assoc($results)) : ?>
						<tr>
							
							<td><?=$result['tamount'];?></td>
							<td><?=$result['tpaid'];?></td>
							<td><u><b><i><?=$result['tamount'] - $result['tpaid'] ;?></i></b></u></td>
							<td><?=$result['dt'];?></td>
							<td><button type="button" class="btn btn-primary" onCLick="detailsmodal(<?=$result['studentfeesid'];?>)">Accept Payment</button></td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				  </table>
				</div>
					<?php endif; ?>
			</form>
			</div>
		</div>
	</div>
<br>		
<?php
include 'includes/footer.php';
?>
		<script>
		function detailsmodal(id){
	//"id":id = i want id from function bracket from above and it should be equal to id in quotes like below under
	var id = id;
	var program = "<?php echo $edit_id; ?>";
	var semester = "<?php echo $semester; ?>";
	var year = "<?php echo $year; ?>";
	var stage = "<?php echo $stage; ?>";
	
	jQuery.ajax({
		url : '/gretsaerp/finance/detailsmodal.php',
		method : "post",
		data : {id:id,program:program, semester:semester, year:year, stage:stage},
		success : function(data){
			jQuery('body').prepend(data);
			jQuery('#details-modal').modal('toggle');
		},
		error : function(){
			alert("Something went wrong");
		}
	});
}
	</script>
	
