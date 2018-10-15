<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$roomno = ((isset($_POST['roomno']) && $_POST['roomno'] !='')?ss($_POST['roomno']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	$capacity = ((isset($_POST['capacity']) && $_POST['capacity'] !='')?ss($_POST['capacity']):'');
	
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM lroom where roomid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$roomno = ((isset($_POST['roomno']) && $_POST['roomno'] !='')?ss($_POST['roomno']):$r['roomno']);
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):$r['type']);
			$capacity = ((isset($_POST['capacity']) && $_POST['capacity'] !='')?ss($_POST['capacity']):$r['capacity']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('roomno',  'type', 'capacity');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM lroom WHERE roomno='$roomno'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Room Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO lroom (roomno, type, capacity)
			VALUES ('$roomno', '$type', '$capacity')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE lroom SET roomno='$roomno', type='$type', capacity='$capacity'
				WHERE roomid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: room.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Rooms</h3><hr>
				<form action="room.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Room Info</legend>
					<div class="form-group">
						<label for="roomno">Room No*:</label>
						<input type="text" class="form-control" name="roomno" id="roomno" value="<?=$roomno; ?>" required/>
					</div>
					<div class="form-group">
						<label for="type">Room Type*:</label><br>
						<input type="text" class="form-control" name="type" id="type" value="<?=$type; ?>"  required/>
					</div>	
					<div class="form-group">
						<label for="capacity">Room Capacity*:</label><br>
						<input type="number" min="0" class="form-control" name="capacity" id="capacity" value="<?=$capacity; ?>"  required/>
					</div>
					<a href="room.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Room" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from lroom";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="room.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Room</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Rooms</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						
						<th>Room No</th>
						<th>Room Type</th>
						<th>Room Capacity</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$roomid = $school['roomid'];
						$name = $school['roomno'];
						$code = $school['type'];
						
						$title = $school['capacity'];
						
					?>
					<tr>
					
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						
						<td><?=$title;?></td>
						
						<td><a href="room.php?edit=<?=$roomid;?>" class="btn btn-primary">Edit</a></td>
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
	
