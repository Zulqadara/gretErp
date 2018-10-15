<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$courseQ = $db->query("SELECT * FROM courses");
	$stageQ = $db->query("SELECT * FROM stages");
	$yearQ = $db->query("SELECT * FROM yearsofstudy");
	$course = ((isset($_POST['course']) && $_POST['course'] !='')?ss($_POST['course']):'');
	$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):'');
	$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT *, stages.name as s, yearsofstudy.name as p, courses.name as n 
			FROM callocation inner join courses on courses.coursesid = callocation.coursesid 
			inner join yearsofstudy on yearsofstudy.yearsid = callocation.yearsid
			INNER JOIN stages on stages.stagesid = callocation.stagesid
			where callocation.callocationid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$course = ((isset($_POST['course']) && $_POST['course'] !='')?ss($_POST['course']):$r['coursesid']);
			$stage = ((isset($_POST['stage']) && $_POST['stage'] !='')?ss($_POST['stage']):$r['stagesid']);
			$year = ((isset($_POST['year']) && $_POST['year'] !='')?ss($_POST['year']):$r['yearsid']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('course', 'stage', 'year');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
			if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM callocation INNER JOIN courses on callocation.coursesid = courses.coursesid WHERE courses.coursesid='$course'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Course Has Already Been Allocated.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO callocation (coursesid, stagesid, yearsid)
			VALUES ('$course', '$stage', '$year')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE callocation SET coursesid='$course', stagesid='$stage', yearsid='$year'
				WHERE callocationid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: callocation.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':' ') ;?> Course Allocation</h3><hr>
				<form action="callocation.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Course Allocation</legend>
					<div class="form-group">
						<label for="course">Course*:</label>
						<select class="form-control" id="course" name="course">
							<option value=""<?=(($course == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($courseQ)) : ?>
								<option value="<?= $p['coursesid']; ?>"<?=(($course == $p['coursesid'])?' selected':'');?>><?= $p['name'];?>(<?= $p['code'];?> )</option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="year">Year*:</label>
						<select class="form-control" id="year" name="year">
							<option value=""<?=(($year == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($yearQ)) : ?>
								<option value="<?= $p['yearsid']; ?>"<?=(($year == $p['yearsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="stage">Stage*:</label>
						<select class="form-control" id="stage" name="stage">
							<option value=""<?=(($stage == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($stageQ)) : ?>
								<option value="<?= $p['stagesid']; ?>"<?=(($stage == $p['stagesid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>

					<a href="callocation.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Allocate ') ;?> Course" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "SELECT *, courses.name as n, stages.name as s, yearsofstudy.name as p FROM callocation inner join courses on courses.coursesid = callocation.coursesid 
			inner join yearsofstudy on yearsofstudy.yearsid = callocation.yearsid
			INNER JOIN stages on stages.stagesid = callocation.stagesid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="callocation.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Allocate Course</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Course</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>ID:</th>
						<th>Course Name</th>
						<th>Year</th>
						<th>Stage</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$programsid = $school['callocationid'];
						$name = $school['n'];
						$code = $school['code'];
						$pprogram = $school['s'];
						$ctype = $school['p'];
					?>
					<tr>
						<td><?=$programsid;?></td>
						<td><?=$name;?> (<?=$code;?>)</td>
						<td><?=$ctype;?></td>
						<td><?=$pprogram;?></td>
						<td><a href="callocation.php?edit=<?=$programsid;?>" class="btn btn-primary">Edit</a></td>
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
	
