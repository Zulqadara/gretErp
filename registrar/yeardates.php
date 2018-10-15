<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$start = ((isset($_POST['start']) && $_POST['start'] !='')?ss($_POST['start']):'');
	$end = ((isset($_POST['end']) && $_POST['end'] !='')?ss($_POST['end']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM yeardates where yeardatesid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$start = ((isset($_POST['start']) && $_POST['start'] !='')?ss($_POST['start']):$r['start']);
			$end = ((isset($_POST['end']) && $_POST['end'] !='')?ss($_POST['end']):$r['end']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('start', 'end');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM yeardates WHERE start='$start' and code='$end'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Year Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO yeardates (start, end)
			VALUES ('$start', '$end')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE yeardates SET start='$start', end='$end'
				WHERE yeardatesid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: yeardates.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Year Dates</h3><hr>
				<form action="yeardates.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Year Info</legend>
					<div class="form-group">
						<label for="start">Year Start*:</label>
						<input type="text" class="form-control" name="start" id="start" value="<?=$start; ?>" required/>
					</div>
					<div class="form-group">
						<label for="end">Year End*:</label>
						<input type="text" class="form-control" name="end" id="end" value="<?=$end; ?>"  required/>
					</div>				
					<a href="yeardates.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Dates" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from yeardates";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="yeardates.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Dates</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Year Dates</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Year Start:</th>
						<th>Year End</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$id = $school['yeardatesid'];
						$schoolid = $school['start'];
						$name = $school['end'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><a href="yeardates.php?edit=<?=$id;?>" class="btn btn-primary">Edit</a></td>
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
	
