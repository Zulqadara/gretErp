<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM feestypes where feestypesid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM feestypes WHERE name='$name'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Fees Type Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO feestypes (name)
			VALUES ('$name')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE feestypes SET name='$name'	WHERE feestypesid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: feestypes.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Fees Types</h3><hr>
				<form action="feestypes.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Fees Type Info</legend>
					<div class="form-group">
						<label for="name">Fees Type Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>					
					<a href="feestypes.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Fees Type" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from feestypes";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="feestypes.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Fees Type</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Fees Types</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Fees Type ID:</th>
						<th>Fees Type Name</th>
						
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['feestypesid'];
						$name = $school['name'];
						
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						
						<td><a href="feestypes.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
