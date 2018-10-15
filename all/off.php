<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$supervisorQ = $db->query("SELECT staffid, name, department, roles FROM staff WHERE roles LIKE '%HOD%'");
	
	$nature = ((isset($_POST['nature']) && $_POST['nature'] !='')?ss($_POST['nature']):'');
	$day = ((isset($_POST['day']) && $_POST['day'] !='')?ss($_POST['day']):'');
	$days = ((isset($_POST['days']) && $_POST['days'] !='')?ss($_POST['days']):'');
	$dates = ((isset($_POST['dates']) && $_POST['dates'] !='')?ss($_POST['dates']):'');
	$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):'');
	$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM `offday` where offdayid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$nature = ((isset($_POST['nature']) && $_POST['nature'] !='')?ss($_POST['nature']):$r['nature']);
			$day = ((isset($_POST['day']) && $_POST['day'] !='')?ss($_POST['day']):$r['day']);
			$days = ((isset($_POST['days']) && $_POST['days'] !='')?ss($_POST['days']):$r['days']);
			$dates = ((isset($_POST['dates']) && $_POST['dates'] !='')?ss($_POST['dates']):$r['dates']);
			$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):$r['supervisorid']);
			$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):$r['confirm']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array( 'nature', 'day', 'days', 'dates', 'supervisor');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO `offday` ( staffid, day,  nature, days, dates, supervisorid, confirm)
			VALUES ( '$staffid', '$day', '$nature', '$days', '$dates', '$supervisor', '$confirm')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE `offday` SET nature='$nature', day='$day', days='$days', dates='$dates', supervisorid='$supervisor', confirm='$confirm'
				WHERE offdayid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: off.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Off Day Application</h3><hr>
				<form action="off.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Off Day Application Info</legend>
				<div class="form-group">
						<label for="day">Day and Date Worked*:</label>
						<input type="text" class="form-control" name="day" id="day" value="<?=$day; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="nature">Nature of Off Day Application*:</label><br>
						<input type="text" class="form-control" name="nature" id="nature" value="<?=$nature; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="days">Number of Days*:</label>
						<input type="text" class="form-control" name="days" id="days" value="<?=$days; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="dates">Days and Dates*:</label><br>
						<input type="text" class="form-control" name="dates" id="dates" value="<?=$dates; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="supervisor">Supervisor*:</label><br>
						<select class="form-control" id="supervisor" name="supervisor" required>
						<option value=""<?=(($supervisor == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($supervisorQ)) : ?>
							<option value="<?= $p['staffid']; ?>"<?=(($supervisor == $p['staffid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
						</select>
					</div>		
					<div class="form-group">
						<input required type="checkbox" required name="confirm" value="yes"> Confirm information<br>
					</div>					
					<a href="off.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Apply ') ;?> Off Day Application" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from `offday` where staffid='$staffid'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="off.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Apply Off Day Application</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Off Day Application</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Day and Date Worked</th>
						<th>Nature</th>
						<th>Number of Days</th>
						<th>Days and Dates</th>
						<th>Supervisor</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$offid = $school['offdayid'];
						$day = $school['day'];
						$name = $school['nature'];
						$code = $school['days'];
						
						$title = $school['dates'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$day;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$status;?></td>
						<td><a href="off.php?edit=<?=$offid;?>" class="btn btn-primary">Edit</a></td>
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
	
