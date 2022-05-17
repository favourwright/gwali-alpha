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
		
	# update notification count
	if($task=="contact_message_notifier"){
		$notifier = new stdClass();
		$notifier->value = 0;
		$notifier->response = NULL;
		$notifier->message = new stdClass();
		
		# SQL
		$Sql = "SELECT * FROM contact_us WHERE resolved=0";
		if($Query = mysqli_query($dbconnect, $Sql)){
			if(mysqli_num_rows($Query)>0){
				$notifier->value = mysqli_num_rows($Query);
				$notifier->response = 200;
			} else{ $notifier->message->error = 404; $notifier->response = "error"; }
		} else{ $notifier->message->sql = "fetch error"; $notifier->response = "error"; }
		
		echo json_encode($notifier);
	}
	
	
	# update password recovery message count
	if($task=="password_recovery_notifier"){
		$notifier = new stdClass();
		$notifier->value = 0;
		$notifier->response = NULL;
		$notifier->message = new stdClass();
		
		# SQL
		$Sql = "SELECT * FROM pass_reset WHERE resolved=0";
		if($Query = mysqli_query($dbconnect, $Sql)){
			if(mysqli_num_rows($Query)>0){
				$notifier->value = mysqli_num_rows($Query);
				$notifier->response = 200;
			} else{ $notifier->message->error = 404; $notifier->response = "error"; }
		} else{ $notifier->message->sql = "fetch error"; $notifier->response = "error"; }
		
		echo json_encode($notifier);
	}
}