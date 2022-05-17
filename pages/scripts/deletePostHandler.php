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
	# get the current user if it exit
	$currentUser = NULL;
	if(!empty($_SESSION['gwalian_login_session'])){ $currentUser = $_SESSION['gwalian_login_session']; }

	# user wants to delete entry
	if($task=="delete_post"){
		$entry = new stdClass();
		$entry->response = NULL;
		$entry->message = new stdClass();
		$entry->entryId = $_POST['entryId'];
		
		# check the record existence
		$count = $records->slim_count_sql("entryId", "entry", "entryId", $entry->entryId);
		if($count==1){
			# firstly, check if a file was uploaded along with this post then delete
			
			
			
			# delete the record with that entryId
			$Sql = "DELETE FROM entry WHERE entryId={$entry->entryId}";
			if($Query = mysqli_query($dbconnect, $Sql)){
				$entry->response = 200;
			} else { $entry->message->entryDelete = 'failed'; $entry->response = "error"; }
			
			# if anyone has commented on this post before, delete all its comments
			$count = $records->slim_count_sql("commentId", "comment", "entryId", $entry->entryId);
			if($count>=1){
				# firstly, check if a file was uploaded along with these comments then delete
			
			
			
				# delete all comments with that entryId
				$Sql = "DELETE FROM comment WHERE entryId={$entry->entryId}";
				if($Query = mysqli_query($dbconnect, $Sql)){
					$entry->response = 200;
				} else { $entry->message->commentDelete = 'failed'; $entry->response = "error"; }
			}
			
			# if anyone has viewed this post before, delete all its view records
			$count = $records->slim_count_sql("viewId", "views", "entryId", $entry->entryId);
			if($count>=1){
				# delete all views with that entryId
				$Sql = "DELETE FROM views WHERE entryId={$entry->entryId}";
				if($Query = mysqli_query($dbconnect, $Sql)){
					$entry->response = 200;
				} else { $entry->message->viewDelete = 'failed'; $entry->response = "error"; }
			}
		} else { $entry->message->dbIdCompare = 404; $entry->response = "error"; }
		echo json_encode($entry);
	}
}