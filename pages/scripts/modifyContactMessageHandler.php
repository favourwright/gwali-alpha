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
		
	# user wants to mark a message as resolved
	if($task=="resolve"){
		$contactMessage = new stdClass();
		$contactMessage->response = NULL;
		$contactMessage->message = new stdClass();
		$contactMessage->messageId = $_POST['messageId'];
		
		# using the message id fetch the message
		if($records->checkRecord("contact_us", "messageId", "$contactMessage->messageId")==true){
			# update the resolved state in db...
			$Sql = "UPDATE contact_us SET resolved=1 WHERE messageId={$contactMessage->messageId}";
			$Query = mysqli_query($dbconnect, $Sql);
			if($Query){ $contactMessage->response = 200; }
			else { $contactMessage->message->sql = "update error"; $contactMessage->response = "error"; }
		} else { $contactMessage->message->error = 404; $contactMessage->response = "error"; }
		
		echo json_encode($contactMessage);
	}
	
	
	# user wants to delete a message
	if($task=="delete"){
		$contactMessage = new stdClass();
		$contactMessage->response = NULL;
		$contactMessage->message = new stdClass();
		$contactMessage->messageId = $_POST['messageId'];
		
		# using the message id fetch the message
		if($records->checkRecord("contact_us", "messageId", "$contactMessage->messageId")==true){
			# update the resolved state in db...
			$Sql = "DELETE FROM contact_us WHERE messageId={$contactMessage->messageId}";
			$Query = mysqli_query($dbconnect, $Sql);
			if($Query){ $contactMessage->response = 200; }
			else { $contactMessage->message->sql = "delete error"; $contactMessage->response = "error"; }
		} else { $contactMessage->message->error = 404; $contactMessage->response = "error"; }
		
		echo json_encode($contactMessage);
	}
}