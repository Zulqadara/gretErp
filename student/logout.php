<?php
session_start();
unset($_SESSION['studentid']);
header ('Location: login.php');
?>