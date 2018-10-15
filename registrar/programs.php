<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$typeQ = $db->query("SELECT * FROM ptype");
	$schoolQ = $db->query("SELECT * FROM schools");
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$pschool = ((isset($_POST['pschool']) && $_POST['pschool'] !='')?ss($_POST['pschool']):'');
	$ptype = ((isset($_POST['ptype']) && $_POST['ptype'] !='')?ss($_POST['ptype']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT *, programs.name as n FROM programs inner join schools on schools.schoolid = programs.schoolid 
			inner join ptype on ptype.ptypeid = programs.ptypeid
			where programs.programsid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['n']);
			$pschool = ((isset($_POST['pschool']) && $_POST['pschool'] !='')?ss($_POST['pschool']):$r['schoolid']);
			$ptype = ((isset($_POST['ptype']) && $_POST['ptype'] !='')?ss($_POST['ptype']):$r['ptypeid']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'ptype', 'pschool');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM programs WHERE name='$name'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Programme Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO programs (name, schoolid, ptypeid)
			VALUES ('$name', '$pschool', '$ptype')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE programs SET name='$name', ptypeid='$ptype', schoolid='$pschool'
				WHERE programsid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: programs.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Programme</h3><hr>
				<form action="programs.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Programme Info</legend>
					<div class="form-group">
						<label for="name">Programme Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="pschool">Programme School*:</label>
						<select class="form-control" id="pschool" name="pschool">
							<option value=""<?=(($pschool == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
								<option value="<?= $p['schoolid']; ?>"<?=(($pschool == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="ptype">Programme Type*:</label>
						<select class="form-control" id="ptype" name="ptype">
							<option value=""<?=(($ptype == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($typeQ)) : ?>
								<option value="<?= $p['ptypeid']; ?>"<?=(($ptype == $p['ptypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<a href="programs.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Programme" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "SELECT *, programs.name as n,  schools.name as s,  ptype.name as p FROM programs inner join schools on schools.schoolid = programs.schoolid 
			inner join ptype on ptype.ptypeid = programs.ptypeid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="programs.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Programme</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Programme</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Programme ID:</th>
						<th>Programme Name</th>
						<th>Programme School</th>
						<th>Programme Type</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['programsid'];
						$name = $school['n'];
						$pschool = $school['s'];
						$ptype = $school['p'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><?=$pschool;?></td>
						<td><?=$ptype;?></td>
						<td><a href="programs.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
