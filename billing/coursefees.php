<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

	$schoolQ = $db->query("SELECT * FROM schools");
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
	$programs = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');

?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"> Allocate Fees to Programme</h3><hr>
				<form action="coursefees.php" method="post" enctype="multipart/form-data">
				<legend>Programme Info</legend>
				<div class="form-group">
					<label for="school">School*:</label>
					<select class="form-control" id="school" name="school" required>
						<option value=""<?=(($school == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
							<option value="<?= $p['schoolid']; ?>"<?=(($school == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="program">Programme*:</label>
					<select class="form-control" id="program" name="program" required>
					</select>
				</div>
				<?php
						if(isset($_POST['cf'])) :
							$program = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
							//echo $program;

						$query = $db->query("select * from feestypes left join coursefees on coursefees.feestypeid = feestypes.feestypesid 
							where programmeid='$program'");
						$count = mysqli_num_rows($query);
						if($count < 1){
							$sql = "select * from feestypes left join coursefees on coursefees.feestypeid = feestypes.feestypesid and programmeid='$program'";
							
						}else{
							$sql = "select * from feestypes left join coursefees on coursefees.feestypeid = feestypes.feestypesid 
								and programmeid='$program' ";	
								
						}
						$sresults = $db->query($sql);?>
						<hr>
						<?php
						while($school = mysqli_fetch_assoc($sresults)) : 
						$id = $school['feestypesid'];
						$name = $school['name'];
						$amount = $school['total'];
						
					?>
					
					<h5><?=$name;?>: (<?=$amount;?>)
					<button type="button" class="btn btn-primary" onCLick="detailsmodal(<?= $id; ?>)">Update</button>
					</h5>
					
					<?php endwhile;?>
						<hr>
					<?php endif; ?>
					
					<a href="coursefees.php" class="btn btn-default">Cancel</a>
					<input type="submit" name="cf" value="<?=((isset($_POST['cf']))?'Refresh':'Next');?>" class="btn btn-success" />
					
				</form>
				
				</div>
			</div>
		</div>


    <!-- /.container -->

    <!-- Footer -->
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
		function detailsmodal(id){
	//"id":id = i want id from function bracket from above and it should be equal to id in quotes like below under
	var id = id;
	var program = jQuery('#program').val();
	jQuery.ajax({
		url : '/gretsaerp/billing/detailsmodal.php',
		method : "post",
		data : {id:id,program:program},
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
	
