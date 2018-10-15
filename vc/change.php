<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';

$cpass = ((isset($_POST['cpass']))?ss($_POST['cpass']):'');
$npass = ((isset($_POST['npass']))?ss($_POST['npass']):'');
$ccpass = ((isset($_POST['ccpass']))?ss($_POST['ccpass']):'');

if($_POST){
		
	$r = $db->query("SELECT * FROM staff WHERE staffid='$staffid' and spasss='$cpass' LIMIT 1");
    $existCount = mysqli_num_rows($r);
	if($existCount < 1){
		$errors[] = 'Your current password is incorrect';
	}
			//form validation
			if(empty($_POST['cpass']) || empty($_POST['npass']) || empty($_POST['ccpass'])){
				$errors[] = 'You must fill out fields';
			}
			
			//New password matches confirm
			if($npass != $ccpass){
				$errors[] = 'The passwords do not match';
			}

			//Check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				//Change password
				$db->query("UPDATE staff SET spasss = '$ccpass' where staffid='$staffid'");
				$_SESSION['success_flash']= 'Your password has been updated' ;
				header ('Location: index.php');

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

       
        <div class="col-md-12">
<h2 class="text-center">Change Password</h2><hr>
			<form enctype="multipart/form-data" method="post" action="change.php">
			<div class="form-group ">
			<label for="cpass">Enter Current Password</label>
			<div class="">
			<input class="form-control" id="cpass" name="cpass" type="password" required />
			</div>
			</div>
			<div class="form-group ">
			<label for="npass">New Password</label>
			<div class="">
			<input class="form-control" id="npass" name="npass" type="password" required />
			</div>
			</div>
			<div class="form-group ">
			<label for="ccpass">Confirm Password</label>
			<div class="">
			<input class="form-control" id="ccpass" name="ccpass" type="password" required />
			</div>
			</div>

			<a href="javascript:history.go(-1)" class="btn btn-default">Back</a>
			<button class="btn btn-success" type="submit">Save changes</button>

			</form>
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
