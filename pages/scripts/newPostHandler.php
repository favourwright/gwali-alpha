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
	if($task=="new_post"){
		$newPost = new stdClass();
		$newPost->response = NULL;
		$newPost->message = new stdClass();
		# this is a reserved area but it doesn't hurt to perform these little checks
		$newPost->userId = $_SESSION['gwalian_login_session'];
		$newPost->cat = stripChars($_POST['formData']['category']);
		$newPost->cc = stripChars($_POST['formData']['courseCode']);
		$newPost->title = stripChars($_POST['formData']['postTitle']);
		# generate a name for the file from the title
		$newPost->fileName = str_replace(" ", "_", $newPost->title);
		$newPost->fileName = str_replace("'", "", $newPost->fileName);
		$newPost->fileName = str_replace('"', "", $newPost->fileName);
		$newPost->fileSize = stripChars($_POST['formData']['fileSize']);
		$newPost->writter = ucwords(strtolower(stripChars($_POST['formData']['writter'])));
		$newPost->file = stripChars($_POST['formData']['fileLink']);
		$newPost->postId = rand(100000, 10000000);
		# get the courseId
		if($records->checkRecord_loose("course", "courseCode", "'$newPost->cc'")==true){
			$rs = $records->getRecord_loose("course", "courseCode", "'$newPost->cc'", "courseId");
			$newPost->courseId = $rs->courseId;
		} else { $newPost->message->cc = 404; $newPost->response = "error"; }
		$uploadDate = date("Y-m-d H:i:s");
		
		# check if there was error before inserting
		if($newPost->response==NULL){
			# insert data to db...
			$newPost->sql = $insertSql = "INSERT INTO entry VALUES ({$newPost->postId}, '{$newPost->cat}', 1, '{$uploadDate}', {$newPost->userId}, {$newPost->courseId}, '{$newPost->title}', JSON_OBJECT('link','{$newPost->file}', 'type','pdf', 'name','{$newPost->fileName}', 'size','{$newPost->fileSize}', 'writter', '{$newPost->writter}'))";
			$insertQuery = mysqli_query($dbconnect, $insertSql);
			if($insertQuery){
				$newPost->response = 200;
			} else { $newPost->message->sql = "insert error"; $newPost->response = "error"; }
		}
		echo json_encode($newPost);
	}
}