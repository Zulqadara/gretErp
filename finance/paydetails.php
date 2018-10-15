<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();

if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM paydetails where paydetailsid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):$r['type']);
		}
		
		if($_POST){
		
		$errors = array();
			
		$required = array('name', 'type');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
						if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM paydetails WHERE name='$name'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Payment Details Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO paydetails (name, type)
			VALUES ('$name', '$type')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE paydetails SET name='$name', type='$type'
				WHERE paydetailsid='$edit_id'";
			}
			$db->query($insertSql);	
			header('Location: paydetails.php');
		}
	}
?> 
  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Payment Details</h3><hr>
				<form action="paydetails.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Payment Details Info</legend>
					<div class="form-group">
						<label for="name">Payment Details Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>					
					<div class="form-group">
						<label for="type">Payment Details Type*:</label>
					<select class="form-control" id="type" name="type" required>
						<option value=""<?=(($type == '')?' selected':'');?>></option>
							<option value="Gross">Gross</option>
							<option value="Deduction">Deduction</option>
					</select>
					</div>
					<a href="paydetails.php" class="btn btn-default">Cancel</a>
					<input type="submit" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Payment Details" class="btn btn-success" />
				</form>
				</div>
			</div>
		</div>
				<?php
		}else{
			$sql = "select * from paydetails";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <a href="paydetails.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Payment Details</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Payment Details</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Payment Details ID:</th>
						<th>Payment Details Name</th>
						<th>Payment Details Type</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$schoolid = $school['paydetailsid'];
						$name = $school['name'];
						$type = $school['type'];
					?>
					<tr>
						<td><?=$schoolid;?></td>
						<td><?=$name;?></td>
						<td><?=$type;?></td>
						<td><a href="paydetails.php?edit=<?=$schoolid;?>" class="btn btn-primary">Edit</a></td>
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
	
