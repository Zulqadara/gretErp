<?php
session_start();
unset($_SESSION['staffuser']);
//session_destroy();
header ('Location: ../login.php');
?>