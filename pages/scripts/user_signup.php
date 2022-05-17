<?php
# proceed only if this was a post request
if($_POST['task']=="signup"){
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
	
	# set these variables for check
	$unsafe = new stdClass();
	$unsafe->email = $_POST['form_data']['email'];
	$unsafe->pass1 = $_POST['form_data']['password'];
	$unsafe->pass2 = $_POST['form_data']['confirmPass'];
	$unsafe->regNumber = $_POST['form_data']['regNumber'];
	$unsafe->faculty = $_POST['form_data']['faculty'];
	$unsafe->department = $_POST['form_data']['department'];
	$unsafe->level = $_POST['form_data']['level'];
	$unsafe->firstname = $_POST['form_data']['firstName'];
	$unsafe->lastname = $_POST['form_data']['lastName'];
	$unsafe->nickname = $_POST['form_data']['nickname'];
	$unsafe->gender = $_POST['form_data']['gender'];
	$unsafe->num1 = $_POST['form_data']['num1'];
	$unsafe->num2 = $_POST['form_data']['num2'];
	$unsafe->terms = $_POST['form_data']['terms'];

	# send to quarantine :)
	$safe = $student->dataVerification($unsafe);
	# set these variables
	$safe->uId;
	$safe->signupDate;
	$safe->email;
	$safe->password;
	$safe->regNumber;
	$safe->faculty;
	$safe->department;
	$safe->level;
	$safe->firstname;
	$safe->lastname;
	$safe->nickname;
	$safe->gender;
	$safe->num1;
	$safe->num2;
	$safe->terms;
	$safe->message;
	$safe->response = NULL;
	if(!empty($_COOKIE['smart_history'])){ $safe->history = $_COOKIE['smart_history']; } else { $safe->history = NULL; }
	
	# here, I'm casting the object in message to $message( which is an array )
	# so that I can check if there was an error with the signup data as there is
	# currently no simple function of checking if an object is empty
	$message = (array)$safe->message;
	# !$message returns true if the array is empty since array() == false;
	if(!$message==true){} else { $safe->response = "data error"; }
	
	# if there was no errors, proceed with inserting the new user into the database
	if(!$safe->response && $safe->terms=="on"){
		$safe->response = $student->createNewUser($safe);
		# if the user was sucessfully added to the database...
		# autoatically log the user in by setting this login session
		if($safe->response == 200){ $_SESSION['gwalian_login_session'] = $safe->uId; }
	}
	echo json_encode($safe);
}