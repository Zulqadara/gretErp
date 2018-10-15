<?php
require_once '../core.php';

if(isset($_POST["id"])){
	$id = $_POST['id'];
	$id = (int)$id;
	$program = $_POST['program'];
	$program = (int)$program;
}else{
    $id = NULL;
}


$sql = "select * from feestypes left join coursefees on coursefees.feestypeid = feestypes.feestypesid WHERE feestypes.feestypesid='$id'";
$q = $db ->query($sql);
$r = mysqli_fetch_assoc($q);

$q2 = $db ->query("select * from programs where programsid='$program'");
$r2 = mysqli_fetch_assoc($q2);

?>

<!-- Details Modal -->
<?php 
//better way to echo an entire page
ob_start();
?>
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
							<h4><?= $r['name']; ?> - <?=$r2['name'];?></h4>
							<hr>
							
							<form action="feeinsert.php" id="myform" method="post">
							<!-- All Inputs Get sent to footer jQuery and Ajax script, which send to add_cart -->
							<input type="hidden" name="program" id="program" value="<?=$program ;?>"/>
							<input type="hidden" name="id" id="id" value="<?=$id ;?>"/>
								<div class="form-group">
									<label for="price"> Amount:</label>
									<input type="number" min="0" step=".01" name="price" id="price" class="form-control" required />
								</div>
								<button class="btn btn-success" id='insert'>Insert</button>
								<a class="btn btn-primary" onclick="closeModal()">Close</a>
							</form>
							<p id='result'></p>
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
		//jQuery( "#h2" ).load(window.location.href + " #h2" );
		
		jQuery('#details-modal').modal('hide');
		setTimeout(function(){
			jQuery('#details-modal').remove();
		},500);
		jQuery('.modal-backdrop').remove();
	}
</script>
<script>
$('#myform').submit(function(){
 return false;
});
 
$('#insert').click(function(){
 $.post( 
 $('#myform').attr('action'),
 $('#myform :input').serializeArray(),
 function(result){
 $('#result').html(result);
 }
 );
});
</script>
<?php 
//cleans the buffer memory
echo ob_get_clean(); ?>