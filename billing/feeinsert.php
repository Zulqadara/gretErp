<?php
 require_once '../core.php';

	$program = ((isset($_POST['program']) && $_POST['program'] !='')?ss($_POST['program']):'');
	$id = ((isset($_POST['id']) && $_POST['id'] !='')?ss($_POST['id']):'');
	$total = ((isset($_POST['price']) && $_POST['price'] !='')?ss($_POST['price']):'');
	
	$query = $db->query("select * from feestypes left join coursefees on coursefees.feestypeid = feestypes.feestypesid 
							where programmeid='$program' and feestypeid='$id'");
			$count = mysqli_num_rows($query);
			if($count >= 1){
				$editSql = "UPDATE coursefees set programmeid = '$program', feestypeid = '$id', total = '$total' 
				where programmeid='$program' and feestypeid='$id'";
				$db->query($editSql);
				echo 'Price Updated';
			}else{
				$insertSql = "INSERT INTO coursefees (programmeid, feestypeid, total)
					VALUES ('$program', '$id', '$total')";
				$db->query($insertSql);	
				echo 'Price Inserted';
			}
?>