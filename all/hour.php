<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$supervisorQ = $db->query("SELECT staffid, name, department, roles FROM staff WHERE roles LIKE '%HOD%'");
	
	$nature = ((isset($_POST['nature']) && $_POST['nature'] !='')?ss($_POST['nature']):'');
	$from = ((isset($_POST['from']) && $_POST['from'] !='')?ss($_POST['from']):'');
	$to = ((isset($_POST['to']) && $_POST['to'] !='')?ss($_POST['to']):'');
	$hours = ((isset($_POST['hours']) && $_POST['hours'] !='')?ss($_POST['hours']):'');
	$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):'');
	$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):'');
	$delegation = ((isset($_POST['delegation']) && $_POST['delegation'] !='')?ss($_POST['delegation']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM `hoursleave` where leaveid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$nature = ((isset($_POST['nature']) && $_POST['nature'] !='')?ss($_POST['nature']):$r['nature']);
			$from = ((isset($_POST['from']) && $_POST['from'] !='')?ss($_POST['from']):$r['froms']);
			$to = ((isset($_POST['to']) && $_POST['to'] !='')?ss($_POST['to']):$r['tos']);
			$hours = ((isset($_POST['hours']) && $_POST['hours'] !='')?ss($_POST['hours']):$r['hours']);
			$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):$r['supervisorid']);
			$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):$r['confirm']);
			$delegation = ((isset($_POST['delegation']) && $_POST['delegation'] !='')?ss($_POST['delegation']):$r['delegation']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array( 'nature', 'from', 'to', 'hours', 'supervisor', 'delegation');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO `hoursleave` (staffid, nature, froms, tos, hours, supervisorid, confirm, delegation)
			VALUES ('$staffid', '$nature', '$from', '$to', '$hours', '$supervisor', '$confirm' , '$delegation')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE `hoursleave` SET nature='$nature', froms='$from', tos='$to', hours='$hours',
				supervisorid='$supervisor', confirm='$confirm'. delegation='$delegation'
				WHERE leaveid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: hour.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?>Hour Leave</h3><hr>
				<form action="hour.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Hours Leave Info</legend>
					<div class="form-group">
						<label for="nature">Nature of Leave*:</label><br>
						<select class="form-control" id="nature" name="nature" required>
						<option value=""<?=(($nature == '')?' selected':'');?>></option>
						<option value="Annual Leave">Annual Leave</option>
						<option value="Sick Leave">Sick Leave</option>
						<option value="Maternity Leave">Maternity Leave</option>
						<option value="Paternity Leave">Paternity Leave</option>
						</select>
					</div>
					<div class="form-group">
						<label for="from">From Time*:</label>
						<input type="text" class="form-control" name="from" id="from" value="<?=$from; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="to">To Time*:</label><br>
						<input type="text" class="form-control" name="to" id="to" value="<?=$to; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="hours">Hours*:</label><br>
						<input type="number" step=".01" min="0" class="form-control" name="hours" id="hours" value="<?=$hours; ?>"  required/>
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
						<label for="delegation">Delegation of Duties*:</label>
						<input type="text" class="form-control" name="delegation" id="delegation" value="<?=$delegation; ?>"  required/>
					</div>
					<div class="form-group">
						<input required type="checkbox" required name="confirm" value="yes"> Confirm information<br>
					</div>					
					<a href="hour.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Apply ') ;?> Leave" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from `hoursleave` where staffid='$staffid'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="hour.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Apply Leave</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Hours Leave</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Nature</th>
						<th>From Time</th>
						<th>To Time</th>
						<th>Humber of Hours</th>
						<th>Supervisor</th>
						<th>Delegation</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$leaveid = $school['leaveid'];
						$name = $school['nature'];
						$code = $school['froms'];
						$type = $school['tos'];
						$title = $school['hours'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
						$delegation = $school['delegation'];
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$delegation;?></td>
						<td><?=$status;?></td>
						
						<td><a href="hour.php?edit=<?=$leaveid;?>" class="btn btn-primary">Edit</a></td>
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
	
