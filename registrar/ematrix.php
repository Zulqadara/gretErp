<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

$semesterQ = $db->query("SELECT * FROM semesters");
$semester = ((isset($_POST['semester']) && $_POST['semester'] !='')?ss($_POST['semester']):'');
$programmeQ = $db->query("SELECT * FROM programs");
$programme = ((isset($_POST['programme']) && $_POST['programme'] !='')?ss($_POST['programme']):'');
$dt =  date("Year");
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">
      <div class="row">
			<div class="col-md-12" align="">
				<h3 class="text-center"> Exam Matrix</h3><hr>
				<form action="ematrix.php?<?=((isset($_GET['add']))?'add='.$edit_id:'') ;?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="semester">Semester*:</label>
					<select class="form-control" id="semester" name="semester" required>
						<option value=""<?=(($semester == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($semesterQ)) : ?>
							<option value="<?= $p['semesterid']; ?>"<?=(($semester == $p['semesterid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="pregramme">Programme*:</label>
					<select class="form-control" id="programme" name="programme" required>
						<option value=""<?=(($programme == '')?' selected':'');?>></option>
						<?php while($p=mysqli_fetch_assoc($programmeQ)) : ?>
							<option value="<?= $p['programsid']; ?>"<?=(($programme == $p['programsid'])?' selected':'');?>><?= $p['name'];?></option>
						<?php endwhile; ?>
					</select>
				</div>
				</form>
					
			</div>
		</div>
	</div>
    <!-- /.container -->

    <!-- Footer -->
   <br>
  </body>
<?php
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
	
