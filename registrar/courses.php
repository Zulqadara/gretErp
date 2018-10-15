<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$typeQ = $db->query("SELECT * FROM ctype");
	$schoolQ = $db->query("SELECT * FROM programs");
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$code = ((isset($_POST['code']) && $_POST['code'] !='')?ss($_POST['code']):'');
	$pprogram = ((isset($_POST['pprogram']) && $_POST['pprogram'] !='')?ss($_POST['pprogram']):'');
	$ctype = ((isset($_POST['ctype']) && $_POST['ctype'] !='')?ss($_POST['ctype']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT *, courses.name as n FROM courses inner join programs on programs.programsid = courses.programsid 
			inner join ctype on ctype.ctypeid = courses.ctypeid
			where courses.coursesid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['n']);
			$code = ((isset($_POST['code']) && $_POST['code'] !='')?ss($_POST['code']):$r['code']);
			$pprogram = ((isset($_POST['pprogram']) && $_POST['pprogram'] !='')?ss($_POST['pprogram']):$r['programsid']);
			$ctype = ((isset($_POST['ctype']) && $_POST['ctype'] !='')?ss($_POST['ctype']):$r['ctypeid']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'ctype', 'pprogram');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
		
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM courses WHERE code='$code' and programsid='$pprogram'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Course Code Already Exists.';
				}
				}
				
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO courses (name, programsid, ctypeid, code)
			VALUES ('$name', '$pprogram', '$ctype', '$code')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE courses SET name='$name', ctypeid='$ctype', programsid='$pprogram', code='$code'
				WHERE coursesid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: courses.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Course</h3><hr>
				<form action="courses.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Course Info</legend>
					<div class="form-group">
						<label for="name">Course Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="code">Course Code*:</label>
						<input type="text" class="form-control" name="code" id="code" value="<?=$code; ?>" required/>
					</div>
					<div class="form-group">
						<label for="pprogram">Course Programme*:</label>
						<select class="form-control" id="pprogram" name="pprogram">
							<option value=""<?=(($pprogram == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($schoolQ)) : ?>
								<option value="<?= $p['programsid']; ?>"<?=(($pprogram == $p['programsid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="ctype">Course Type*:</label>
						<select class="form-control" id="ctype" name="ctype">
							<option value=""<?=(($ctype == '')?' selected':'');?>></option>
							<?php while($p=mysqli_fetch_assoc($typeQ)) : ?>
								<option value="<?= $p['ctypeid']; ?>"<?=(($ctype == $p['ctypeid'])?' selected':'');?>><?= $p['name'];?></option>
							<?php endwhile; ?>
						</select>
					</div>
					<a href="courses.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Course" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "SELECT *, courses.name as n,  programs.name as s,  ctype.name as p FROM courses inner join programs on programs.programsid = courses.programsid 
			inner join ctype on ctype.ctypeid = courses.ctypeid";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="courses.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Course</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Course</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Course ID:</th>
						<th>Course Name</th>
						<th>Course Programme</th>
						<th>Course Type</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$programsid = $school['coursesid'];
						$name = $school['n'];
						$pprogram = $school['s'];
						$ctype = $school['p'];
					?>
					<tr>
						<td><?=$programsid;?></td>
						<td><?=$name;?></td>
						<td><?=$pprogram;?></td>
						<td><?=$ctype;?></td>
						<td><a href="courses.php?edit=<?=$programsid;?>" class="btn btn-primary">Edit</a></td>
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
	
