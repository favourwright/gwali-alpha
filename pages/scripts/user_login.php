<?php
$user = new stdClass();
$user->email = NULL;
$user->pass = NULL;
$user->login_persist = NULL;
$user->response = NULL;
$user->history = NULL;

# proceed only if this was a post request
if($_POST['task']=="login"){
	# I need to set a session; without session start I literally can't
	session_start();
	# this should dynamically add the gwali root folder on only localhost
	$lh_dir = NULL;
	if($_SERVER['SERVER_NAME']=="localhost"){ $lh_dir="gwali/"; }
	$rsc = $_SERVER["REQUEST_SCHEME"]; // http, https, ftp...
	$prot = "$rsc://"; // server protocol used
	$sern = $_SERVER['SERVER_NAME']; // server name
	
	include $_SERVER['DOCUMENT_ROOT']."/{$lh_dir}pages/includes/defines.php";
	require_once MODELS_DIR ."db_connection.php";
	require_once MODELS_DIR ."records.php";
	require_once MODELS_DIR ."student.php";
	$records = new Records;
	$student = new Student;
	$user->email = mysqli_real_escape_string($dbconnect, $_POST['form_data']['email']);
	$user->pass = sha1($_POST['form_data']['password']);
	if(!empty($_POST['form_data']['login_persist'])){ $user->login_persist = $_POST['form_data']['login_persist']; };
	if(!empty($_COOKIE['smart_history'])){ $user->history = $_COOKIE['smart_history']; }
	
	$checkResponseData = $student->checkLoginDetails($user->email, $user->pass);
	# if everything went fine
	if($checkResponseData->response == 200){
		$_SESSION['gwalian_login_session'] = $checkResponseData->data->uId;
		# at this point its necessary for me to check if the user checked the
		# keep-me-logged-in button.
		# if yes then set a cookie to remember the user
		# this cookie expires after one week
		$encodedId = base64_encode($checkResponseData->data->uId);
		if($user->login_persist=="on"){ setcookie("gwalian_persist", $encodedId, time()+(60*60*24*7), "/"); }
		$user->response = "done";
	# if the password was incorrect. don't tell them though, just give 404
	} elseif($checkResponseData->response == "incorrect"){
		$user->response = 404;
	# if the email was incorrect
	} elseif($checkResponseData->response == 404) { $user->response = 404; }
	
	echo json_encode($user);
}