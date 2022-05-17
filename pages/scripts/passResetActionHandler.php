<?php
# proceed only if this was a post request
if(!empty($_POST['task'])){
	$task = $_POST['task'];
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
	
	$recovery = new stdClass();
	$recovery->response = NULL;
	$recovery->task = $task;
	$recovery->targetUId = $_POST['targetUId'];
	$recovery->message = new stdClass();
	
	# user wants to acknowledge that the mail's been sent
	if($task=="password_recovery_issent"){
		# check if the target id is in the password reset column
		if($records->checkRecord("pass_reset", "uId", "{$recovery->targetUId}")){
			if($records->slim_update_sql("pass_reset", "resolved=1", "uId", $recovery->targetUId)){ $recovery->response = 200; }
			else { $recovery->message->update_error = true; }
		} else { $recovery->message->entry = 404; }
		
	# user wants to delete a recovery notice or entry
	} elseif($task=="password_recovery_delete"){
		# check if the target id is in the password reset column
		if($records->checkRecord("pass_reset", "uId", "{$recovery->targetUId}")){
			$sql = "DELETE FROM pass_reset WHERE uId={$recovery->targetUId}";
			if(mysqli_query($dbconnect, $sql)){ $recovery->response = 200; }
			else { $recovery->message->delete_error = true; }
		} else { $recovery->message->entry = 404; }
	}
	# return a response
	echo json_encode($recovery);
}