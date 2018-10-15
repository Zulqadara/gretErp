<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM stages where stagesid = '$edit_id'");
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
				$valQ = $db->query("SELECT * FROM stages WHERE name='$name'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Stage Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO stages (name)
			VALUES ('$name')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE stages SET name='$name'
				WHERE stagesid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: stages.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Stage</h3><hr>
				<form action="stages.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Stage Info</legend>
					<div class="form-group">
						<label for="name">Stage Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>					
					<a href="stages.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Stage" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from stages";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="stages.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Stage</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Stage</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Stage ID:</th>
						<th>Stage Name</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['stagesid'];
						$name = $school['name'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><a href="stages.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
