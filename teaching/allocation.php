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
$flag=0;
$update=0;
if(isset($_POST['submit'])){
	$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$day = ((isset($_POST['day']) && $_POST['day'] !='')?ss($_POST['day']):'');
	$res = $db->query("SELECT * FROM lroomalloc where semester='$semester' and day='$day' and year(dt)='$date'");
	$num=mysqli_num_rows($res);
	if($num){
		foreach($_POST['roomid'] as $id=>$unit){
			
			$roomid = $_POST['roomid'][$id];
			$unit = ((!isset($_POST['unit'][$id]))?'':''.$_POST['unit'][$id].'');
			$unit2 = ((!isset($_POST['unit2'][$id]))?'':''.$_POST['unit2'][$id].'');
			$unit3 = ((!isset($_POST['unit3'][$id]))?'':''.$_POST['unit3'][$id].'');
			$unit4 = ((!isset($_POST['unit4'][$id]))?'':''.$_POST['unit4'][$id].'');


			//cahneg date to sem and year and actual year
			$result = $db->query("UPDATE lroomalloc SET unitid='$unit', unitid2='$unit2', unitid3='$unit3', unitid4='$unit4' where roomid='$roomid' and semester='$semester' and year(dt)='$date'");
			//header("Location: index.php");
			if($result){
				$update=1;
			}
		}
	}else{
		foreach($_POST['unit'] as $id=>$unit){
			
			$roomid = $_POST['roomid'][$id];
			$unit = $_POST['unit'][$id];
			$unit2 = $_POST['unit2'][$id];
			$unit3 = $_POST['unit3'][$id];
			$unit4 = $_POST['unit4'][$id];
			
			//cahneg date to sem and year and actual year
			$result = $db->query("INSERT INTO lroomalloc (roomid, unitid, unitid2, unitid3, unitid4, semester, day) 
				VALUES ('$roomid','$unit','$unit2','$unit3','$unit4','$semester','$day')")or die(mysqli_error($db));
			if($result){
				$flag=1;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">


  <body>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       <?php if($flag): ?>
			<div class="alert alert-success">
				Room Allocated
			</div>
			<?php endif; ?>
			<?php if($update): ?>
			<div class="alert alert-warning">
				Room Allocation Updated
			</div>
			<?php endif; ?>
        <div class="col-md-12">
				<div class="col-md-12">       
					<h2 class="text-center">Lecturer Room Allocation</h2><hr>
					<form action="allocation.php" method="post">
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
				<form action="allocation.php" method="post">
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
						<label> <?=(($uniti == '')?'':''.$uniti.'');?><br><label/>
						<input type="hidden" name="roomid[]" value="<?=$roomid1;?>"/>
						  <select data-placeholder="Choose a Course" name="unit[<?=$counter;?>]" class="form-control chosen-select">					
<option value="" disabled></option>
	<option value="<?=(($uniti == '')?'':''.$uniti.'');?>"><?=(($uniti == '')?'':''.$uniti.'');?></option>

							<?php foreach($ps as $p): ?>
								<option value="<?= $p['code']; ?>"<?=(($unit == $p['code'])?' selected':'');?>><?= $p['code'];?></option>
							<?php endforeach; ?>
						  </select>
						</td>
						<td>
						<label> <?=(($uniti2 == '')?'':''.$uniti2.'');?><br><label/>
						  <select data-placeholder="Choose a Course" name="unit2[<?=$counter;?>]" class="form-control chosen-select">
						  <option value="" disabled></option>
								<option value="<?=(($uniti2 == '')?'':''.$uniti2.'');?>"><?=(($uniti2 == '')?'':''.$uniti2.'');?></option>
							<?php foreach($ps as $p): ?>
								<option value="<?= $p['code']; ?>"<?=(($unit == $p['code'])?' selected':'');?>><?= $p['code'];?></option>
							<?php endforeach; ?>
						  </select>
						</td>
						<td>
						<label> <?=(($uniti3 == '')?'':''.$uniti3.'');?><br><label/>
						  <select data-placeholder="Choose a Course" name="unit3[<?=$counter;?>]" class="form-control chosen-select">
						<option value="" disabled></option>
	<option value="<?=(($uniti3 == '')?'':''.$uniti3.'');?>"><?=(($uniti3 == '')?'':''.$uniti3.'');?></option>
							<?php foreach($ps as $p): ?>
								<option value="<?= $p['code']; ?>"<?=(($unit == $p['code'])?' selected':'');?>><?= $p['code'];?></option>
							<?php endforeach; ?>
						  </select>
						</td>
						<td>
						<label> <?=(($uniti4 == '')?'':''.$uniti4.'');?><br><label/>
						  <select data-placeholder="Choose a Course" name="unit4[<?=$counter;?>]" class="form-control chosen-select">
						<option value="" disabled></option>
	<option value="<?=(($uniti4 == '')?'':''.$uniti4.'');?>"><?=(($uniti4 == '')?'':''.$uniti4.'');?></option>
							<?php foreach($ps as $p): ?>
								<option value="<?= $p['code']; ?>"<?=(($unit == $p['code'])?' selected':'');?>><?= $p['code'];?></option>
							<?php endforeach; ?>
						  </select>
						</td>
					</tr>
					<?php 
					$counter++;
					endwhile; ?>
				</tbody>
				</table>
				<input type="hidden" name="semester" value="<?=$semester;?>"/>
				<input type="hidden" name="day" value="<?=$day;?>"/>
				<a class="btn btn-default" href="index.php">Back</a>
				<input type="submit" name="submit" value="Submit" class="btn btn-success" />
				</form>
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
