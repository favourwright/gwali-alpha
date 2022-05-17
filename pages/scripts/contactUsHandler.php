<?php
# proceed only if this was a post request
if(!empty($_POST['task'])){
	$task = $_POST['task'];
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
	
	# when user wants to manage supported courses
	if($task=="contact_us"){
		$contactData = new stdClass();
		$contactData->response = 200;
		$contactData->errMessage = new stdClass();
		
		$contactData->name = stripChars($_POST['formData']['name']);
		$contactData->email = $_POST['formData']['email'];
		$contactData->purpose = stripChars($_POST['formData']['purpose']);
		$contactData->message = stripChars($_POST['formData']['message']);
		
		# check email
		$contactData->email = strtolower(mysqli_real_escape_string($dbconnect, $contactData->email));
		if(!filter_var($contactData->email, FILTER_VALIDATE_EMAIL)){ $contactData->response = "error"; $contactData->errMessage->email = 'invalid email format'; }
		$contactData->contactUsId = rand(1000000, 10000000);
		$sentDate = date("Y-m-d H:i:s");
		$user = $student->studentIdentifier();
		$contactData->uId = NULL;
		$contactData->uCookieId = NULL;
		if($user->uId){ $contactData->uId = $user->uId; }
		else { $contactData->uCookieId = $user->uCookieId; }
		
		# using the email provided, check if user is regsitered
		# the function used here is the same I use while loggin-in a user
		# [404 error means that email is not registered]
		# [incorrect means password is incorrect]
		$contactData->registered = NULL;
		$contactData->ver = $student->checkLoginDetails($contactData->email, "");
		if($contactData->ver->response=='incorrect'){ $contactData->registered = true; }
		$sender = "JSON_OBJECT('uId','{$contactData->uId}', 'uCookieId','{$contactData->uCookieId}', 'name','{$contactData->name}', 'email','{$contactData->email}', 'registered','{$contactData->registered}')";
		$data = "JSON_OBJECT('purpose','{$contactData->purpose}', 'message','{$contactData->message}')";
		
		if($contactData->response == 200){
			$sql = "INSERT INTO contact_us(messageId, messageDate, resolved, sender, data) VALUES({$contactData->contactUsId}, '{$sentDate}', 0, {$sender}, {$data})";
			if(mysqli_query($dbconnect, $sql)){ $contactData->response = 200; }
			else { $contactData->response = "error"; $contactData->errMessage->sql = "server error; couldn't send message"; }
		}
		echo json_encode($contactData);
	}
}