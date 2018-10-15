<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	$schoolQ = $db->query("SELECT * FROM schools");
	$school = ((isset($_POST['school']) && $_POST['school'] !='')?ss($_POST['school']):'');
		
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$studentR = $db->query("SELECT * FROM gown where studentid = '$edit_id' and status = '0'");
			$student = mysqli_fetch_assoc($studentR);
			$rdate = ((isset($_POST['rdate']) && $_POST['rdate'] !='')?ss($_POST['rdate']):$student['rdate']);

		}
		
		if($_POST){
			
			$item = implode(',', $_POST['items']);
			//var_dump($item);
			$insertSql = "INSERT INTO gown (studentid, items, rdate) VALUES ('$edit_id','$item','$rdate')";
				$res2 = $db->query("SELECT * FROM gown where studentid = '$edit_id' and `status` = '0'");
					$num2=mysqli_num_rows($res2);							
						if($num2){
							$insertSql = "UPDATE gown SET items ='$item', rdate ='$rdate' where studentid = '$edit_id' and `status` = '0'";
						}
				$db->query($insertSql);
				header('Location: gown.php');
					
		}
?> 
  <body>
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }

    });
});

</script>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?' ':' ') ;?> Gown Collection</h3><hr>
				<form action="gown.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
					
					<div class="form-group mx-sm-3  mb-2">
					<label for="items">Item*:</label><br>
					<?php 
						$query2 = $db->query("select * from gownitems");
							while($school = mysqli_fetch_assoc($query2)) : 
								$name = $school['name'];
					?>
						<input
						<?php 
							$res = $db->query("SELECT * FROM gown where studentid = '$edit_id' and status = '0'");
							$num=mysqli_num_rows($res);
							$s = mysqli_fetch_assoc($res);
							$item = explode(",", $s['items']);
							
							if($num){
								foreach($item as $items){
									if($name == $items){
									echo "onclick=\"return false;\" checked";
									}
								}
							}
						?>
						
						type = "checkbox" name= "items[]" value ="<?=$name;?>"/> <?=$name;?> <br>
						<?php endwhile;?>
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="rdate">Date of Return*:</label>
					<input type="date" required name="rdate" value="<?=$rdate;?>" class="form-control" />
					</div>
					
					<a href="gown.php" class="btn btn-default">Cancel</a>
					<input type="submit" id="checkBtn" name="submt" value="Give Gown" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select *,  CONCAT(referencename, '/', referencemonth, '/', referenceyear, '/', referencenumber) AS ref 
			from student inner join activestudent on activestudent.studentid = student.studentid
			WHERE student.verify='1'
			ORDER BY studentnumber";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Gown Collection</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Student ID:</th>
						<th>Reference ID:</th>
						<th>Student Number:</th>
						<th>Name</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Country</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['studentid'];
						$ref = $student['ref'];
						$studentref = $student['studentnumber'];
						$name = $student['name'];
						$gender = $student['gender'];
						$dob = $student['dob'];
						$email = $student['email'];
						$phone = $student['phone'];
						$country = $student['country'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$ref;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
						<td><?=$dob;?></td>
						<td><?=$email;?></td>
						<td><?=$phone;?></td>
						<td><?=$country;?></td>
						<td><a href="gown.php?edit=<?=$studentid;?>" class="btn btn-primary">Proceed</a></td>
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
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            }
        ]
    } );
} );
	</script>
	
