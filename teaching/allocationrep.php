<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';
$semesterQ = $db->query("SELECT * FROM semesters");
$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$unitQ = $db->query("SELECT * FROM courses");
$unit = ((isset($_POST['unit']) && $_POST['unit'] !='')?($_POST['unit']):'');
$day = ((isset($_POST['day']) && $_POST['day'] !='')?ss($_POST['day']):'');
$ps = array();
while($p=mysqli_fetch_assoc($unitQ)){ 
    $ps[] = $p;
}
$date = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">


  <body>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">
        <div class="col-md-12">
				<div class="col-md-12">       
					<h2 class="text-center">Lecturer Room Allocation Report</h2><hr>
					<form action="allocationrep.php" method="post">
								   				<div class="form-group mb-2">
					<label for="semester">Semester*:</label>
					<select class="form-control" id="semester" name="semester" required>
						<option value=""<?=(($semester == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
							<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group mb-2">
					<label for="day">Day*:</label>
				<select name="day" class="form-control" required>
					<option value="<?=(($day == '')?'':''.$day.'');?>"><?=(($day == '')?'':''.$day.'');?></option>
					<option value="Monday">Monday</option>
					<option value="Tuesday">Tuesday</option>
					<option value="Wednesday">Wednesday</option>
					<option value="Thursday">Thursday</option>
					<option value="Friday">Friday</option>
					<option value="Saturday">Saturday</option>
				</select>
				</div>
				<div class="form-group mb-2">
			   <button name="sub" class="btn btn-warning mb-2">Proceed</button>
			   </div>
				</form>
						   <?php
						   if(isset($_POST['sub'])):
						   $semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$day = ((isset($_POST['day']) && $_POST['day'] !='')?ss($_POST['day']):'');
				$qu = $db->query("select *, lroom.roomid as rid from lroom 
left join lroomalloc on lroom.roomid = lroomalloc.roomid
and lroomalloc.semester='$semester' and lroomalloc.day='$day' and year(lroomalloc.dt) = '$date'")or die(mysqli_error($db));			
				
        ?>
			
				<table class="table table-bordered table-striped">
					<thead>
					<tr>

						<th>Room No.:</th>
						<th>8-11</th>
						<th>11-1</th>
						<th>2-5</th>
						<th>5.30-8.30</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						$counter=0;
						while($student = mysqli_fetch_assoc($qu)) : 
						$roomid = $student['roomno'];
						$roomid1 = $student['rid'];
						$uniti = $student['unitid'];
						$uniti2 = $student['unitid2'];
						$uniti3 = $student['unitid3'];
						$uniti4 = $student['unitid4'];
					?>
					<tr>
						<td><?=$roomid;?></td>
						<td>
						<input type="hidden" name="roomid[]" value="<?=$roomid1;?>"/>

							
							<input type="text" readonly class="form-control" id="uniti" name="uniti" value="<?=$uniti;?>"/>
							
						</td>
<td>

							
							<input type="text" readonly class="form-control" id="uniti2" name="uniti2" value="<?=$uniti2;?>"/>
							
						</td>
<td>

							
							<input type="text" readonly class="form-control" id="uniti3" name="uniti3" value="<?=$uniti3;?>"/>
							
						</td>
<td>

							
							<input type="text" readonly class="form-control" id="uniti4" name="uniti4" value="<?=$uniti4;?>"/>
							
						</td>
					</tr>
					<?php 
					$counter++;
					endwhile; ?>
				</tbody>
				</table>
				<input type="hidden" name="semester" value="<?=$semester;?>"/>
				<input type="hidden" name="day" value="<?=$day;?>"/>
											<form method="post" action="allocationrepp.php" target="_blank">
								<input type="hidden" name="semester" value="<?=$semester;?>" />
				
				<input type="hidden" name="day" value="<?=$day;?>" />

				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
				<a class="btn btn-default" href="index.php">Back</a>
				<?php endif; ?>
				</div>
				<br>
				<br>		  
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   <br>
  </body>
<?php
include 'includes/footer.php';
?>
</html>
