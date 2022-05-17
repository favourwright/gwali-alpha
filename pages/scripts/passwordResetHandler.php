<?php
# proceed only if this was a post request
if(!empty($_POST['task'])){
	$task = $_POST['task'];
	# I need to set a session; without session start I literally can't
	date_default_timezone_set("Africa/Lagos");
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
	
	$currentUser = NULL;
	if(!empty($_SESSION['gwalian_login_session'])){ $currentUser = $_SESSION['gwalian_login_session']; }
	
	$recovery = new stdClass();
	$recovery->response = NULL;
	$recovery->message = new stdClass();
	
	# user wants to 
	if($task=="reset_password" && $currentUser==NULL){
		$email = $_POST['email'];
		$recovery->email = $email;
		# check if a user with this email actually exists
		if($records->checkRecord_loose("user", "mail", "'{$email}'")){
			# get some details about user with this email
			$user = $records->getRecord_loose("user", "mail", "'{$email}'", "uId, uPass");
			# check if the request had been sent aleady
			if($records->checkRecord("pass_reset", "uId", "{$user->uId}")==NULL){
				$uploadDate = date("Y-m-d H:i:s");
				# the token is actually a hash of the hashed password and datetime
				$token = sha1($user->uPass.$uploadDate);
				# insert to the reset database
				$Sql = "INSERT INTO pass_reset VALUES ({$user->uId}, '{$token}', '{$uploadDate}', 0, 0, 0)";
				if(mysqli_query($dbconnect, $Sql)){ $recovery->response = 200; }
				else { $recovery->response = "error"; $recovery->message->insert = "Server error"; }
			} else { $recovery->response = "error"; $recovery->message->duplicate = "Request already sent, keep checking your mail"; }
		} else { $recovery->response = "error"; $recovery->message->email = "Perhaps you miss-spelt your email?"; }
		
		echo json_encode($recovery);
	# if user is logged-in, what would they be doing on this page?
	} else { header("location: index.php"); }
}