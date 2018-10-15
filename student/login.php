<?php
require_once '../core.php';
include 'includes/header.php';

if (isset($_SESSION["studentid"])) {
    header("location: index.php"); 
    exit();
}

$id = ((isset($_POST['id']))?ss($_POST['id']):'');
$password = ((isset($_POST['password']))?ss($_POST['password']):'');
	if(isset($_POST['log'])){
		$id = ((isset($_POST['id']))?ss($_POST['id']):'');
		$password = ((isset($_POST['password']))?ss($_POST['password']):'');

		$errors = array();
			//form validation
			if(empty($_POST['id']) || empty($_POST['password'])){
				$errors[] = 'You must proivde id and password';
			}

			//If user exists in DB
			$query = $db->query("SELECT * FROM student WHERE studentnumber='$id' and wpass='$password'");
			$user = mysqli_fetch_assoc($query);
			$userCount = mysqli_num_rows($query);
			if($userCount < 1){
				$errors[] = 'Inncorrect Name/Password!';
			}
			
			//Check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				//Log user in
				session_start();
				$_SESSION["studentid"] = $user["studentid"];
				header ('Location: index.php');
			}
		}
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Gretsa University</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>
<!DOCTYPE html>
<html lang="en">


  <body>

    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-8">

          <h1 class="my-4">Login
          </h1>
		  
          <div class="card mb-4">
            <div class="card-body">
				 <form action="login.php" method="post">
				 <div class="form-group">
						<label for="id"> ID:</label>
						<input type="text" value="<?=$id;?>" name="id" id="id" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="password"> Password:</label>
						<input type="password" value="<?=$password;?>" name="password" id="password" class="form-control" required />
					</div>
						<a href ="../index.php" class="btn btn-primary">Cancel</a>
						<input type="submit" name="log" value="Log In" class="btn btn-success"/>
					</div>
				</form>
            </div>
          </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   
  </body>
<?php
include 'includes/footer.php';
?>
</html>
