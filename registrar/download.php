<?php

require_once '../core.php';
if (isset($_GET['cid'])){
$targetID = $_GET['cid'];
}


 
$targetID=$_GET['cid'];
$sql = "SELECT * FROM student WHERE studentid=$targetID";
 
 $result = $db->query($sql);
 while($curr_file = mysqli_fetch_array($result))
{
$name = $curr_file['docname'];
$content = $curr_file['docs'];
header("Content-type: application/zip");
header('Content-Disposition: attachment; filename="'.$name.'"');
header("Content-Transfer-Encoding: binary");
header('Accept-Ranges: bytes');
echo $content;
} 

?>