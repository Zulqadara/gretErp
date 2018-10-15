<?php
require_once '../core.php';

if(isset($_POST["id"])){
	$id = $_POST['id'];
	$id = (int)$id;
	$program = $_POST['program'];
	$program = (int)$program;
	$semester = $_POST['semester'];
	$semester = (int)$semester;
	$year = $_POST['year'];
	$year = (int)$year;
	$stage = $_POST['stage'];
	$stage = (int)$stage;
}else{
    $id = NULL;
}


//$sql = "SELECT * FROM studentinvoice inner join feestypes on feestypes.feestypesid = studentinvoice.feesid  WHERE studentinvoiceid='$id'";
$sql = "SELECT * FROM studentfees WHERE studentfeesid='$id'";
$results = $db ->query($sql);
$result = mysqli_fetch_assoc($results);
?>

<!-- Details Modal -->
<?php 
//better way to echo an entire page
ob_start();
?>
<!-- jQuery.NumPad -->
	<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" >
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" onclick="closeModal()" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
					<span id="modal_errors" class="bg-danger"></span>
						<div class="col-sm-12">
							<h4>Amount Due: <?=$result['tamount'] - $result['tpaid'];?>/=</h4>
							<hr>
							
							<form action="fees.php?add=<?=$program;?>" method="post">
							<input type="hidden" name="iid" id="iid" value="<?=$id ;?>"/>								
							<input type="hidden" name="semester" id="semester" value="<?=$semester ;?>"/>								
							<input type="hidden" name="year" id="year" value="<?=$year ;?>"/>								
							<input type="hidden" name="stage" id="stage" value="<?=$stage ;?>"/>								
								<div class="form-group">
									<label for="type">Payment Type*:</label><br>
									<?php
										$payQ = "SELECT * FROM paymentforms";
										$payR = $db ->query($payQ);
										while($pay = mysqli_fetch_assoc($payR)) : 
									?>
									<input type="radio" name="type" value="<?=$pay['paymentformsid'];?>" required> <?=$pay['name'];?><br>
									<?php endwhile; ?>
								</div>
								<div class="form-group">
									<label for="details"> Payment Details (Mpesa code, etc)</label>
									<input type="text" name="details" id="details" class="form-control" required />
								</div>
								<div class="form-group">
									<label for="amount"> Amount Paid:</label>
									<input type="number" min="0" name="amount" id="amount" class="form-control" required />
								</div>
								<button class="btn btn-warning" type="submit" name="pay"> Accept Payment</button>
								<a class="btn btn-primary" onclick="closeModal()">Close</a>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				
				
							
			</div>
		  </div>
		</div>
	</div>
<script>
	function closeModal(){
		jQuery('#details-modal').modal('hide');
		setTimeout(function(){
			jQuery('#details-modal').remove();
		},500);
		jQuery('.modal-backdrop').remove();
	}
</script>
<?php 
//cleans the buffer memory
echo ob_get_clean(); ?>