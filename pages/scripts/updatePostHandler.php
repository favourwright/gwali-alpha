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
		
	# user wants to 
	if($task=="update_post"){
		$updatePost = new stdClass();
		$updatePost->response = NULL;
		$updatePost->message = new stdClass();
		# this is a reserved area but it doesn't hurt to perform these little checks
		$updatePost->userId = $_SESSION['gwalian_login_session'];
		$updatePost->cat = stripChars($_POST['formData']['category']);
		$updatePost->_cc = stripChars($_POST['formData']['courseCode']);
		$updatePost->title = stripChars($_POST['formData']['postTitle']);
		$updatePost->link = stripChars($_POST['formData']['fileLink']);
		$updatePost->fileSize = stripChars($_POST['formData']['fileSize']);
		$updatePost->writter = stripChars($_POST['formData']['writter']);
		$updatePost->entryId = $_POST['entryId'];
		# get the courseId
		if($records->checkRecord_loose("course", "courseCode", "'$updatePost->_cc'")==true){
			$rs = $records->getRecord_loose("course", "courseCode", "'$updatePost->_cc'", "courseId");
			$updatePost->courseId = $rs->courseId;
		} else { $updatePost->message->_cc = 404; $updatePost->response = "error"; }
		# for display on html
		$updatePost->cc = str_replace("_", " ", $updatePost->_cc);

		# check if there was error before inserting
		if($updatePost->response==NULL){
			# update data in db...
			$updatePost->sql = $Sql = "UPDATE entry SET type='{$updatePost->cat}', title='{$updatePost->title}', courseId={$updatePost->courseId}, file=JSON_SET(`file`, '$.link', '{$updatePost->link}', '$.size', '{$updatePost->fileSize}', '$.writter', '{$updatePost->writter}') WHERE entryId={$updatePost->entryId}";
			$Query = mysqli_query($dbconnect, $Sql);
			if($Query){
				$updatePost->response = 200;
			} else { $updatePost->message->sql = "update error"; $updatePost->response = "error"; }
		}
		echo json_encode($updatePost);
	}
}