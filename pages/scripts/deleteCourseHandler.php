<?php
# proceed only if this was a post request
if(!empty($_POST['task'])){
	$task = $_POST['task'];
	# I need to set a session; without session start I literally can't
	session_start();
	date_default_timezone_set("Africa/Lagos");
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
	
	# adding new course code
	if($task=="delete_course" && !empty($currentUser)){
		$course = new stdClass();
		$course->cc = stripChars($_POST['courseCode']);
		$course->response = NULL;
		$course->message = new stdClass();
		
		# get posts under this courseId
		
		
		
		# firstly, check if a file was uploaded along with this post then delete
		
		
		
//		# delete the record with that entryId
//		$Sql = "DELETE FROM entry WHERE entryId={$entry->entryId}";
//		if($Query = mysqli_query($dbconnect, $Sql)){
//			$course->response = 200;
//		} else { $course->message->entryDelete = 'failed'; $course->response = "error"; }
//		
//		# if anyone has commented on this post before, delete all its comments
//		$count = $records->slim_count_sql("commentId", "comment", "entryId", $entry->entryId);
//		if($count>=1){
//			# firstly, check if a file was uploaded along with these comments then delete
//		
//		
//		
//			# delete all comments with that entryId
//			$Sql = "DELETE FROM comment WHERE entryId={$entry->entryId}";
//			if($Query = mysqli_query($dbconnect, $Sql)){
//				$course->response = 200;
//			} else { $course->message->commentDelete = 'failed'; $course->response = "error"; }
//		}
//		
//		# if anyone has viewed this post before, delete all its view records
//		$count = $records->slim_count_sql("viewId", "views", "entryId", $entry->entryId);
//		if($count>=1){
//			# delete all views with that entryId
//			$Sql = "DELETE FROM views WHERE entryId={$entry->entryId}";
//			if($Query = mysqli_query($dbconnect, $Sql)){
//				$course->response = 200;
//			} else { $course->message->viewDelete = 'failed'; $course->response = "error"; }
//		}
		
		# the course code is the last thing I want deleted
		$Sql = "DELETE FROM course WHERE courseCode='{$course->cc}'";
		if($Query = mysqli_query($dbconnect, $Sql)){
			$course->response = 200;
		} else { $course->message->courseCode = 'failed'; $course->response = "error"; }
		
		echo json_encode($course);
	}
}