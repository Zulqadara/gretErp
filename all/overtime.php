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
	$expected = ((isset($_POST['expected']) && $_POST['expected'] !='')?ss($_POST['expected']):'');
	$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):'');
	$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM `overtime` where overtimeid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$nature = ((isset($_POST['nature']) && $_POST['nature'] !='')?ss($_POST['nature']):$r['nature']);
			$from = ((isset($_POST['from']) && $_POST['from'] !='')?ss($_POST['from']):$r['froms']);
			$to = ((isset($_POST['to']) && $_POST['to'] !='')?ss($_POST['to']):$r['tos']);
			$expected = ((isset($_POST['expected']) && $_POST['expected'] !='')?ss($_POST['expected']):$r['expected']);
			$supervisor = ((isset($_POST['supervisor']) && $_POST['supervisor'] !='')?ss($_POST['supervisor']):$r['supervisorid']);
			$confirm = ((isset($_POST['confirm']) && $_POST['confirm'] !='')?ss($_POST['confirm']):$r['confirm']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array( 'nature', 'from', 'to', 'expected', 'supervisor');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO `overtime` ( staffid, nature, froms, tos, expected, supervisorid, confirm)
			VALUES ( '$staffid', '$nature', '$from', '$to', '$expected', '$supervisor', '$confirm')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE `overtime` SET nature='$nature', froms='$from', tos='$to', expected='$expected', supervisorid='$supervisor', confirm='$confirm'
				WHERE overtimeid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: overtime.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Overtime</h3><hr>
				<form action="overtime.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Overtime Info</legend>
					<div class="form-group">
						<label for="nature">Nature of Overtime*:</label><br>
						<input type="text" class="form-control" name="nature" id="nature" value="<?=$nature; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="from">Date of Assignment*:</label>
						<input type="date" class="form-control" name="from" id="from" value="<?=$from; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="to">Date Expected to Work*:</label><br>
						<input type="date" class="form-control" name="to" id="to" value="<?=$to; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="expected"><b>Hours</b> to work*:</label><br>
						<input type="number" min="0" class="form-control" name="expected" id="expected" value="<?=$expected; ?>"  required/>
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
					<a href="overtime.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Apply ') ;?> Overtime" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from `overtime` where staffid='$staffid'";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="overtime.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Apply Overtime</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Overtime</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Nature</th>
						<th>Date of Assignment</th>
						<th>Date Expected to Work</th>
						<th>Time</th>
						<th>Supervisor</th>
						<th>Status</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$overtimeid = $school['overtimeid'];
						$name = $school['nature'];
						$code = $school['froms'];
						$type = $school['tos'];
						$title = $school['expected'];
						$hname = $school['supervisorid'];
						$status = $school['status'];
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><?=$status;?></td>
						<td><a href="overtime.php?edit=<?=$overtimeid;?>" class="btn btn-primary">Edit</a></td>
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
	
