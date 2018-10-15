<?php
$db = mysqli_connect('localhost','root','','gretsaerp');
if (mysqli_connect_errno()){
	echo 'Database Connection Failed With Following Errors: '.mysqli_connect_error();
	die();
	}

define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/gretsaerp/');
	
require_once BASEURL.'helpers/helpers.php';
session_start(); 

if(isset($_SESSION['success_flash'])){
	echo '<div class="alert alert-success" id="message"><p class="text-success text-center">'.$_SESSION['success_flash'].'</p></div>'; 
	unset($_SESSION['success_flash']);
}
?>