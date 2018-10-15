<?php
function display_errors($errors){
	$display = '<ul class="bg-danger">';
	foreach($errors as $error){
		$display .= '<li class="">'.$error.'</li>' ;
	}
	$display .= '</ul>';
	return $display;
}

function ss($dirty){
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function money($number){
	return '$'.number_format($number,2);
	//return '$'.number_format((float)$number,2); TRY THIS IF THE ABOVE FAILS
}

function login($user_id){
	$_SESSION['ECOMuser'] = $user_id;
	global $db;
	$date = date("Y-m-d H:i:s");
	$db->query("UPDATE users SET last_login='$date' where id='$user_id'");
	$_SESSION['success_flash'] = 'You are now logged in';
	header ('Location: index.php');
}

function is_logged_in(){
	if(isset($_SESSION['ECOMuser']) && $_SESSION['ECOMuser'] > 0){
		return true;
	}
	return false;
}

function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You must be logged in to access that page';
	header('Location: '.$url);
}

function has_permission($permission = 'admin'){
	global $user_data; //global fetches value from init
	$permissions = explode(',', $user_data['permissions']); 
	if(in_array($permission, $permissions, true)){
		return true;
	}
	return false;
}

function permission_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'You do not have permission to acces that page';
	header('Location: '.$url);
}

function pretty_date($date){
	return date("M d, Y, h:i A", strtotime($date));
}

function get_category($child_ID){
	global $db;
	$id = ss($child_ID);
	$sql = "SELECT s.schoolid as sid, s.name as sname, p.programsid as pid, p.name as pname
			FROM programs p
			INNER JOIN school s
			ON s.schoolid = p.schoolid
			WHERE programs.programsid = '$id'";
	$query = $db->query($sql);
	$programs = mysqli_fetch_assoc($query);
	return $program;
}
function get_category1($child_ID){
	global $db;
	$id = ss($child_ID);
	$sql = "SELECT p.programsid as pid, p.name as pname, c.coursesid as cid, c.name as cname
			FROM courses c
			INNER JOIN programs p
			ON c.programsid = c.programsid
			WHERE c.programsid = '$id'";
	$query = $db->query($sql);
	$units = mysqli_fetch_assoc($query);
	return $unit;
}

?>