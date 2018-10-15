<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$level = ((isset($_POST['level']) && $_POST['level'] !='')?ss($_POST['level']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM ptype where ptypeid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			$level = ((isset($_POST['level']) && $_POST['level'] !='')?ss($_POST['level']):$r['level']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'level');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM ptype WHERE name='$name' OR level='$level'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Programme Type/Level Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO ptype (name, level)
			VALUES ('$name', '$level')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE ptype SET name='$name', level='$level'
				WHERE ptypeid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: ptype.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Programme Type</h3><hr>
				<form action="ptype.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Programme Type Info</legend>
					<div class="form-group">
						<label for="name">Programme Name Type*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>					
					<div class="form-group">
						<label for="level">Programme Level*:</label>
						<input type="number" min="0" class="form-control" name="level" id="level" value="<?=$level; ?>" required/>
					</div>	
					<a href="ptype.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Programme Type" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from ptype";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="ptype.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Programme Type</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Programme Type</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						
						<th>Programme Type Name</th>
						<th>Programme Type Level</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['ptypeid'];
						$name = $school['name'];
						$level = $school['level'];
					?>
					<tr>
						<td><?=$name;?></td>
						<td><?=$level;?></td>
						<td><a href="ptype.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
