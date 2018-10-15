<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$roomno = ((isset($_POST['roomno']) && $_POST['roomno'] !='')?ss($_POST['roomno']):'');
	$floor = ((isset($_POST['floor']) && $_POST['floor'] !='')?ss($_POST['floor']):'');
	$wing = ((isset($_POST['wing']) && $_POST['wing'] !='')?ss($_POST['wing']):'');
	$capacity = ((isset($_POST['capacity']) && $_POST['capacity'] !='')?ss($_POST['capacity']):'');
	
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM room where roomid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$roomno = ((isset($_POST['roomno']) && $_POST['roomno'] !='')?ss($_POST['roomno']):$r['roomno']);
			$floor = ((isset($_POST['floor']) && $_POST['floor'] !='')?ss($_POST['floor']):$r['floor']);
			$wing = ((isset($_POST['wing']) && $_POST['wing'] !='')?ss($_POST['wing']):$r['wing']);
			$capacity = ((isset($_POST['capacity']) && $_POST['capacity'] !='')?ss($_POST['capacity']):$r['capacity']);
			$available = ((isset($_POST['available']) && $_POST['available'] !='')?ss($_POST['available']):$r['available']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('roomno', 'floor' , 'wing', 'capacity');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				/*if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM room WHERE roomno='$roomno'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Code Already Exists.';
				}
				}*/
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO room (roomno, floor, wing, capacity, available)
			VALUES ('$roomno', '$floor', '$wing', '$capacity', '$capacity')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE room SET roomno='$roomno', floor='$floor', wing='$wing', capacity='$capacity', available='$available'
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
						<input type="number" min="0" class="form-control" name="roomno" id="roomno" value="<?=$roomno; ?>" required/>
					</div>
					<div class="form-group">
						<label for="floor">Room Floor*:</label>
						<input type="number" min="0" class="form-control" name="floor" id="floor" value="<?=$floor; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="wing">Room Wing*:</label><br>
						<input type="text" class="form-control" name="wing" id="wing" value="<?=$wing; ?>"  required/>
					</div>	
					<div class="form-group">
						<label for="capacity">Room Capacity*:</label><br>
						<input type="number" min="0" class="form-control" name="capacity" id="capacity" value="<?=$capacity; ?>"  required/>
					</div>
					<?php if(isset($_GET['edit'])): ?>
					<div class="form-group">
						<label for="available">Available*:</label><br>
						<input type="number" min="0" class="form-control" name="available" id="available" value="<?=$available; ?>"  required/>
					</div>
					<?php endif; ?>
					<a href="room.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Room" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from room";
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
						<th>Room Floor</th>
						<th>Room Wing</th>
						<th>Room Capacity</th>
						<th>Available</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$roomid = $school['roomid'];
						$name = $school['roomno'];
						$code = $school['floor'];
						$type = $school['wing'];
						$title = $school['capacity'];
						$available = $school['available'];
					?>
					<tr>
					
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$available;?></td>
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
	
