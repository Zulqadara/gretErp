<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

	$edit_id = (int)$_GET['add'];
	
	if(isset($_GET['delete'])){
		$edit_id = (int)$_GET['add'];
		$id = (int)$_GET['delete'];
		$query = "DELETE FROM lecturerunit WHERE unitid = '$id' AND lecturerid='$edit_id'";
		$db->query($query);
		header("Location: unitallocation.php?add=$edit_id");
	}
	if(isset($_POST['sub'])){
		
		$unit = ((isset($_POST['unit']) && $_POST['unit'] !='')?($_POST['unit']):'');
		for ($i = 0; $i <count($unit);$i++){
			if(!empty($unit)){
				$res = $db->query("SELECT * FROM lecturerunit WHERE lecturerid='$edit_id' and unitid='".$unit[$i]."'");
				$num=mysqli_num_rows($res);
				if($num){
					$query = "UPDATE lecturerunit SET unitid = ".$unit[$i]." where lecturerid='$edit_id' AND unitid='".$unit[$i]."'";
					$db->query($query);
				}
				else{
				$query = "INSERT INTO lecturerunit (unitid, lecturerid) VALUES ('".$unit[$i]."', '$edit_id')";
				$db->query($query);
				}
			}
		}

		header('Location: lunits.php');
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">
        <div class="col-md-12" align="">
			<h3 class="text-center">Allocate Unit</h3><hr>
				<form action="unitallocation.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				<?php
						$query2 = $db->query("select * from courses");
						?>
						<br>
						<legend>Units</legend>
						<hr>
						<div class="form-group">
						<table id="table_id" class="display responsive" width="100%">
							<thead>
								<tr>
									<th></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php while($school = mysqli_fetch_assoc($query2)) : 
								$id = $school['coursesid'];
								$name = $school['name'];
								$code = $school['code'];
								?>
								<tr>
									<td><input 
						
						<?php 
							$res = $db->query("SELECT * FROM lecturerunit WHERE lecturerid='$edit_id' and unitid='$id'");
							$num=mysqli_num_rows($res);
							if($num){
								echo "disabled";
							}
						?>
						type="checkbox" name="unit[]" value="<?=$id;?>"> <?=$name;?>
						<?php 
							$res = $db->query("SELECT * FROM lecturerunit WHERE lecturerid='$edit_id' and unitid='$id'");
							$num=mysqli_num_rows($res);
							if($num):
						?>
							<a href="unitallocation.php?add=<?=$edit_id;?>&delete=<?=$id;?>" class="btn btn-sm btn-danger">Unallocate Unit</a>
						<?php endif; ?>
						<br><br>
									</td>
									<td></td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
						</div>
						<a href="lunits.php" class="btn btn-default">Cancel</a>
						<input type="submit" name="sub" value="Submit" class="btn btn-success" />
					</form>
				</div>
			</div>
		</div>
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
$(document).ready(function() {
    $('#table_id').DataTable( {
		 "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ],
		paging: false
    } );
} );
	</script>
	
