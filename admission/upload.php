<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add'])){
	
	$edit_id = (int)$_GET['add'];	
		
		if($_FILES){
		
		$filename=$_FILES['doc']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$errors = array();
			
		$allowed = array('zip');
		$tmpLoc = array();
		$uploadPath = array();

		if(!in_array($ext, $allowed)){
					$errors[] = 'The file extension must be a ZIP';
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			

				$ffile = fopen($_FILES['doc']['tmp_name'],"rb");
				$contents = fread($ffile,$_FILES['doc']['size']);
				$fileupload = mysqli_escape_string($db, $contents);
				$insertSql = "UPDATE student SET
				docname = '" . $filename . "',
				docs = '" . $fileupload . "' WHERE `studentid` ='" .$edit_id. "'";
				
				$db->query($insertSql);
			//	header('Location: upload.php');
		}
	}

?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> upload</h3><hr>
				<form action="upload.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				
					<div class="form-group">
						<label for="doc">Upload Documents (zip)*:</label>
						<input type="file" name="doc" class="form-control" id="doc" accept=".zip" />
					</div>
					<a href="upload.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?' ':'upload ') ;?> Student" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(student.referencename, '/', student.referencemonth, '/', student.referenceyear, '/', student.referencenumber) AS ref 
			from student inner join studentreg on studentreg.studentid = student.studentid 
			WHERE studentreg.registrationstatus = 'new' AND docs IS NULL ORDER BY student.referencenumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">New Student Document Upload</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Reference ID:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Phone</th>
						<th>County</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$studentref = $student['ref'];
						$name = $student['name'];
						$gender = $student['gender'];
						$dob = $student['dob'];
						$email = $student['email'];
						$phone = $student['phone'];
						$country = $student['country'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="upload.php?add=<?=$studentid;?>" class="btn btn-primary">Upload</a></td>
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
		 "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ]
    } );
} );
	</script>
	
