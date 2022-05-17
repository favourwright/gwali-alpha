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
	if($task=="new_course" && !empty($currentUser)){
		$newCourse = new stdClass();
		$newCourse->code = strtolower(stripChars($_POST['formData']['courseCode']));
		$newCourse->response = NULL;
		$newCourse->message = new stdClass();
		
		# perform a little check on the course code
		$formatErr = "please use the afore mentioned format!";
		if(!preg_match("/^[a-zA-Z_0-9]*$/", $newCourse->code)){ $newCourse->message->cc = $formatErr; $newCourse->response = "error"; }
		if($newCourse->response==NULL){
			$courseId = rand(1000000, 10000000);
			$uploadDate = date("Y-m-d H:i:s");
			$Sql = "INSERT INTO course VALUES($courseId, '{$uploadDate}', '{$newCourse->code}')";
			if(mysqli_query($dbconnect, $Sql)){ $newCourse->response = 200; }
			else { $newCourse->response = "error"; $newCourse->message->sql = "server error, unable to insert"; }
		}
		echo json_encode($newCourse);
	}
}