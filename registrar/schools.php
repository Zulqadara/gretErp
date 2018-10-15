<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$code = ((isset($_POST['code']) && $_POST['code'] !='')?ss($_POST['code']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	$title = ((isset($_POST['title']) && $_POST['title'] !='')?ss($_POST['title']):'');
	$hname = ((isset($_POST['hname']) && $_POST['hname'] !='')?ss($_POST['hname']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM schools where schoolid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			$code = ((isset($_POST['code']) && $_POST['code'] !='')?ss($_POST['code']):$r['code']);
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):$r['type']);
			$title = ((isset($_POST['title']) && $_POST['title'] !='')?ss($_POST['title']):$r['facultyheadtitle']);
			$hname = ((isset($_POST['hname']) && $_POST['hname'] !='')?ss($_POST['hname']):$r['headname']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'code' , 'type', 'title', 'hname');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM schools WHERE code='$code'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Code Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO schools (name, code, type, facultyheadtitle, headname)
			VALUES ('$name', '$code', '$type', '$title', '$hname')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE schools SET name='$name', code='$code', type='$type', facultyheadtitle='$title', headname='$hname'
				WHERE schoolid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: schools.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Schools</h3><hr>
				<form action="schools.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>School Info</legend>
					<div class="form-group">
						<label for="name">School Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="code">School Code*:</label>
						<input type="text" class="form-control" name="code" id="code" value="<?=$code; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="type">School Type*:</label><br>
						<input type="radio" name="type" value="academic" checked> Academic<br>
						<input type="radio" name="type" value="administrative"> Administrative<br>
					</div>
					<div class="form-group">
						<label for="title">School Head Title*:</label><br>
						<input type="radio" name="title" value="dean" checked> Dean<br>
						<input type="radio" name="title" value="director"> Director<br>
					</div>
						<div class="form-group">
						<label for="hname">School Head Name*:</label><br>
						<input type="text" class="form-control" name="hname" id="hname" value="<?=$hname; ?>"  required/>
					</div>					
					<a href="schools.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> School" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from schools";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="schools.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add School</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Schools</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>School ID:</th>
						<th>School Name</th>
						<th>School Code</th>
						<th>School Type</th>
						<th>School Head Title</th>
						<th>School Head Name</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['schoolid'];
						$name = $school['name'];
						$code = $school['code'];
						$type = $school['type'];
						$title = $school['facultyheadtitle'];
						$hname = $school['headname'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$hname;?></td>
						<td><a href="schools.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
