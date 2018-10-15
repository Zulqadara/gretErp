<?php
	require_once '../core.php';
	include 'includes/header.php';
	include 'includes/navigation.php';
	$errors = array();
	
	$edit_id = (int)$_GET['add'];
	if(isset($_GET['delete'])){
		$edit_id = (int)$_GET['add'];
		$id = (int)$_GET['delete'];
		
		$query = "UPDATE studentunits as s
		inner join studentprogramme on studentprogramme.studentprogrammeid = s.studentprogrammeid
		SET s.status = '0'
		WHERE s.unitid = '$id' AND studentprogramme.studentid='$edit_id'";
		$db->query($query);
		header("Location: unitallocation.php?add=$edit_id");
	}
	$schoolQ = $db->query("SELECT * FROM schools");
	$stageQ = $db->query("SELECT * FROM stages");
	$yearQ = $db->query("SELECT * FROM yearsofstudy");
	
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
	$programs = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	
	$res = $db->query("SELECT * FROM studentprogramme 
	inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
	WHERE studentid='$edit_id'");
	$num=mysqli_num_rows($res);
	if($num){
		$r=mysqli_fetch_assoc($res);
		$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):$r['stage']);
		$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):$r['year']);
		
	}
	
	
	if(isset($_POST['sub'])){
		
		$programs = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
		$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
		$bill = ((isset($_POST['bill']) && $_POST['bill'] !='')?($_POST['bill']):'');
		$tut = ((isset($_POST['tut']) && $_POST['tut'] !='')?($_POST['tut']):'');
		$unit = ((isset($_POST['unit']) && $_POST['unit'] !='')?($_POST['unit']):'');
		$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
		$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
		
		
		$div = 0;
		$divq =  $db->query("SELECT * FROM programs p inner join ptype pt on p.ptypeid = pt.ptypeid 
		WHERE p.programsid='$programs' AND pt.name ='Foundation' OR pt.name='Bridging/Short Courses'");
		
		$divr = mysqli_num_rows($divq);
		if($divr){
			$div = 5;	
			}else{
			$div = 6;
		}
		
		$check = $db->query("SELECT * FROM studentprogramme 
		WHERE programmeid='$programs' AND school ='$school' AND  studentid ='$edit_id' AND  year ='$year' AND  stage ='$stage'");
		
		$num=mysqli_num_rows($check);
		
		if($num){
			
			$res = mysqli_fetch_assoc($check);
			$unitid = $res['studentprogrammeid'];
			
			for ($i = 0; $i <count($unit);$i++){
				if(!empty($unit)){
					$query = "INSERT INTO studentunits (unitid, studentprogrammeid) VALUES ('".$unit[$i]."', '$unitid')";
					$db->query($query);
				}
			}
			//echo count($unit);
			$bills = "SELECT studentfeesid FROM studentfees WHERE studentprogrammeid = '$unitid'";
			$billsQ = $db->query($bills);
			$billidr=mysqli_fetch_assoc($billsQ);
			$billid = $billidr['studentfeesid'];
			
			
			$b1 = 0;
			$b2 = 0;
			
			
			for ($i = 0; $i <count($tut);$i++){	
				if(!empty($tut)){
					$gettotalq = $db->query("SELECT total FROM coursefees where feestypeid = '".$tut[$i]."' and programmeid='$programs'");
					$gettotalr=mysqli_fetch_assoc($gettotalq);
					$gettotal = $gettotalr['total'];
					$unitcount = count($unit);
					$unittotal = ($gettotal / $div) *  $unitcount;
					$b1+=$unittotal;
					$unittotal = round($unittotal, 2);
					$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('$billid','".$tut[$i]."', '$unittotal')";
					$db->query($query);
					//	$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('1','".$bill[$i]."', '$unittotal')";
					//$db->query($query);
				}
			}
			
			
			
			for ($i = 0; $i <count($bill);$i++){	
				if(!empty($bill)){
					$gettotalq = $db->query("SELECT total FROM coursefees where feestypeid = '".$bill[$i]."' and programmeid='$programs'");
					$gettotalr=mysqli_fetch_assoc($gettotalq);
					$gettotal = $gettotalr['total'];
					$b2+=$gettotal;
					$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('$billid','".$bill[$i]."', '$gettotal')";
					$db->query($query);
					
					
					//	$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('1','".$bill[$i]."', '$unittotal')";
					//$db->query($query);
				}
			}
			
			$tota = $b1+$b2;
			$bills = "UPDATE studentfees set tamount=tamount+'$tota' where studentfeesid='$billid'";
			$db->query($bills);
			
			}else{
			
			$units = "INSERT INTO studentprogramme 
			(programmeid, school, studentid, year, stage) VALUES ('$programs', '$school', '$edit_id', '$year', '$stage')";
			$db->query($units);
			$unitid = $db->insert_id;
			for ($i = 0; $i <count($unit);$i++){
				if(!empty($unit)){
					$query = "INSERT INTO studentunits (unitid, studentprogrammeid) VALUES ('".$unit[$i]."', '$unitid')";
					$db->query($query);
				}
			}
			//echo count($unit);
			$bills = "INSERT INTO studentfees (studentprogrammeid) VALUES ('$unitid')";
			$db->query($bills);
			$billid = $db->insert_id;
			
			$b1 = 0;
			$b2 = 0;
			
			
			for ($i = 0; $i <count($tut);$i++){	
				if(!empty($tut)){
					$gettotalq = $db->query("SELECT total FROM coursefees where feestypeid = '".$tut[$i]."' and programmeid='$programs'");
					$gettotalr=mysqli_fetch_assoc($gettotalq);
					$gettotal = $gettotalr['total'];
					$unitcount = count($unit);
					$unittotal = ($gettotal / $div) *  $unitcount;
					$unittotal = round($unittotal, 2);
					$b1+=$unittotal;
					$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('$billid','".$tut[$i]."', '$unittotal')";
					$db->query($query);
					//	$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('1','".$bill[$i]."', '$unittotal')";
					//$db->query($query);
				}
			}
			
			
			
			for ($i = 0; $i <count($bill);$i++){	
				if(!empty($bill)){
					$gettotalq = $db->query("SELECT total FROM coursefees where feestypeid = '".$bill[$i]."' and programmeid='$programs'");
					$gettotalr=mysqli_fetch_assoc($gettotalq);
					$gettotal = $gettotalr['total'];
					$b2+=$gettotal;
					$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('$billid','".$bill[$i]."', '$gettotal')";
					$db->query($query);
					
					
					//	$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('1','".$bill[$i]."', '$unittotal')";
					//$db->query($query);
				}
			}
			
			$tota = $b1+$b2;
			
			if(isset($_POST['bc'])){
				$bc = ((isset($_POST['bc']) && $_POST['bc'] !='')?($_POST['bc']):'');
				$bc1 = ((isset($_POST['bc1']) && $_POST['bc1'] !='')?($_POST['bc1']):'');
				$query = "INSERT INTO studentinvoice (studentfeesid, feesid, amount) VALUES ('$billid','$bc1', '$bc')";
				$db->query($query);
				$tota += $bc;
			}
			
			$bills = "UPDATE studentfees set tamount=tamount+'$tota' where studentfeesid='$billid'";
			$db->query($bills);
		}
		echo ("<SCRIPT>
		window.open('unitallocp.php?add=$edit_id&unit=$unitid');
		window.open('billp.php?add=$edit_id&unit=$unitid');
		window.location.href='studentcourses.php';
		</SCRIPT>");
		
		//header('Location: studentcourses.php');
	}
?> 
<body>
    <!-- Navigation -->
	<br>
    <div class="container">
		
		<div class="row">
			
			
			<div class="col-md-12" align="">
				<h3 class="text-center">Student Invoice (Unit Allocation)</h3><hr>
				<form action="unitallocation.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
					
					<div class="form-group">
						<label for="school">School*:</label>
						<select class="form-control" id="school" name="school" required>
							<option value=""<?=(($school == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
							<option value="<?= $p['schoolid']; ?>"<?=(($school == $p['schoolid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="program">Programme*:</label>
						<select class="form-control" id="program" name="program" required>
						</select>
					</div>
					<?php if(!isset($_POST['cf'])): ?>
					<a href="studentcourses.php" class="btn btn-default">Cancel</a>
					<?php endif; ?>
					<button name="cf" class="btn btn-primary"><?=((isset($_POST['cf']))?'Refresh':'Next');?></button>
					<?php
						if(isset($_POST['cf'])) :
						$program = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
						//echo $program;
						
						$query = $db->query("select * from feestypes inner join coursefees on coursefees.feestypeid = feestypes.feestypesid 
						where programmeid='$program' and name not like '%Tuition%' and name not like 'Balance carried forward'");
						$queryA = $db->query("select * from feestypes inner join coursefees on coursefees.feestypeid = feestypes.feestypesid 
						where programmeid='$program' and name like '%Tuition%'");
						$queryB = $db->query("select * from feestypes
						where name like 'Balance carried forward'");
						$cnameq = $db->query("select stypes.name as coursesname from student
						inner join stypes on stypes.stypeid = student.`mode`
						where stypes.name='Distance Learning' and student.studentid='$edit_id'");
						$cnamer=mysqli_num_rows($cnameq);
						if($cnamer){
							$query2 = $db->query("select * from courses 
							inner join odlunits on odlunits.unitid = courses.coursesid
							where programsid='$program'");
							}else{
							$query2 = $db->query("select * from courses where programsid='$program'");
						}
						
					?>
					<br>
					<legend>Billing Applicable</legend>
					<hr>
					
					
					<div class="form-group">
						
						<?php
							$bc = mysqli_fetch_assoc($queryB);
							$bcid = $bc['feestypesid'];
							$bcname = $bc['name'];
							
						?>
						<div class="form-group row">
							<label for="inputPassword" class="col-sm-2 col-form-label"><?=$bcname;?>:</label>
							<div class="col-sm-2">
								<input 
								<?php 
									$res = $db->query("SELECT * FROM studentinvoice 
									inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
									inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
									inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
									WHERE studentprogramme.studentid='$edit_id' and studentinvoice.feesid='$bcid'");
									$num=mysqli_fetch_assoc($res);
									$a='0';
									if($num){
										echo "disabled";
										$a = $num['amount'];
										
									}
								?>
								
								type = "number" min="0" class="form-control" name= "bc" value ="<?=$a?>" placeholder="<?=$a;?>"> <br>
								
							</div>
						</div>
						
						<input
						<?php
							while($school = mysqli_fetch_assoc($queryA)) : 
							$id = $school['feestypesid'];
							$name = $school['name'];
						?>

						<input
						<?php 
							$res = $db->query("SELECT * FROM studentinvoice 
							inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
							inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
							inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
							WHERE studentprogramme.studentid='$edit_id' and studentinvoice.feesid='$id'");
							$num=mysqli_num_rows($res);
							if($num){
								echo "disabled";
							}
						?>
						type = "checkbox" name= "tut[]" value ="<?=$id;?>"> <?=$name;?>
						<?php 
							$res = $db->query("SELECT * FROM studentinvoice 
							inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
							inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
							inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
							WHERE studentprogramme.studentid='$edit_id' and studentinvoice.feesid='$id'");
							$num=mysqli_fetch_assoc($res);
							if($num):
						?>
						<span class="">(Already Allocated: <b>KSh.<?=$num['amount'];?></b>)</span>
						<?php endif;?><br/>
						<?php endwhile;?>
						
						<?php
							while($school = mysqli_fetch_assoc($query)) : 
							$id = $school['feestypesid'];
							$name = $school['name'];
						?>
						<input
						<?php 
							$res = $db->query("SELECT * FROM studentinvoice 
							inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
							inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
							inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
							WHERE studentprogramme.studentid='$edit_id' and studentinvoice.feesid='$id'");
							$num=mysqli_num_rows($res);
							if($num){
								echo "disabled";
							}
						?>
						type = "checkbox" name= "bill[]" value ="<?=$id;?>"> <?=$name;?>
						<?php 
							$res = $db->query("SELECT * FROM studentinvoice 
							inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
							inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
							inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
							WHERE studentprogramme.studentid='$edit_id' and studentinvoice.feesid='$id'");
							$num=mysqli_fetch_assoc($res);
							if($num):
						?>
						<span class="">(Already Allocated: <b>KSh.<?=$num['amount'];?></b>)</span>
						<?php endif;?><br/>
						<?php endwhile;?>
					</div>
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
											$res = $db->query("SELECT * FROM studentprogramme 
											inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
											WHERE studentid='$edit_id' and unitid='$id' and status='1'");
											$num=mysqli_num_rows($res);
											if($num){
												echo "disabled";
											}
										?>
										
										type = "checkbox" name= "unit[]" value ="<?=$id;?>"> <?=$name;?> <?php 
											$res = $db->query("SELECT * FROM studentunits 
											inner join studentprogramme on studentprogramme.studentprogrammeid = studentunits.studentprogrammeid
											WHERE studentid='$edit_id' and unitid='$id' and status='1'");
											$num=mysqli_num_rows($res);
											if($num):
										?>
										<a href="unitallocation.php?add=<?=$edit_id;?>&delete=<?=$id;?>" class="btn btn-sm btn-danger">Unallocate Unit</a>
									<?php endif;?><br/>
									</td>
									<td></td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
					<div class="form-group">
						<label for="year">Year*:</label>
						<select class="form-control" id="year" name="year" required>
							<option value=""<?=(($year == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($yearQ)) : ?>
							<option value="<?= $p['yearsid']; ?>"<?=(($year == $p['yearsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="stage">Stage*:</label>
						<select class="form-control" id="stage" name="stage" required>
							<option value=""<?=(($stage == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($stageQ)) : ?>
							<option value="<?= $p['stagesid']; ?>"<?=(($stage == $p['stagesid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<a href="studentcourses.php" class="btn btn-default">Cancel</a>
					<input type="submit" name="sub" value="Submit" class="btn btn-success" />
					<input type = "hidden" name= "bc1" value ="<?=$bcid;?>" placeholder="<?=$bcname;?>"> 
					
					<?php endif; ?>
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

