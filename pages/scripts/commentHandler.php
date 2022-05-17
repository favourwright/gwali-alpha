<?php
$data = new stdClass();
$data->post = $_POST;
$data->commenterId = NULL;
$data->commenterCookieId = NULL;
$data->userData = new stdClass();
$data->registered = NULL;
$data->response = NULL;
$data->newCommentId = NULL;
if(isset($data->post['task'])){
	# proceed only if this wasn't a get request; only post allowed
	date_default_timezone_set("Africa/Lagos");
	# this should dynamically add the gwali root folder on only localhost
	$lh_dir = NULL;
	if($_SERVER['SERVER_NAME']=="localhost"){ $lh_dir="gwali/"; }
	$rsc = $_SERVER["REQUEST_SCHEME"]; // http, https, ftp...
	$prot = "$rsc://"; // server protocol used
	$sern = $_SERVER['SERVER_NAME']; // server name
	
	include $_SERVER['DOCUMENT_ROOT']."/{$lh_dir}pages/includes/defines.php";

	// import essential classes
	require_once MODELS_DIR ."db_connection.php";
	require_once MODELS_DIR ."records.php";
	require_once MODELS_DIR ."comment.php";
	require_once MODELS_DIR ."student.php";
	$records = new Records;
	$comment = new Comment;
	$student = new Student;
	$data->commenterId = $data->post["user"]["uId"];
	$data->commenterCookieId = $data->post["user"]["uCookieId"];
	# firstly get the user information; if signed up
	$user = $student->studentIdentifier($data->commenterId);
	if(!empty($user->uId)){
		$data->registered = true;
		$data->userData->uId = $user->uId;
	}
	# fulfil the necessary procedures for new comment insertion
	if($data->post['task']=="post_new_comment" || $data->post['task']=="post_new_comment_retry"){
		$data->newCommentId = rand(100000, 10000000);
		$entryId = $data->post['entryId'];
		$userString = '{"id":"'.$data->commenterId.'", "cookieId":"'.$data->commenterCookieId.'"}';
		$uploadDate = date("Y-m-d H:i:s");
		$comment = addslashes(nl2br(stripChars($data->post["comment"])));
		$fileString = '{"filename":"", "type":"", "size":""}';
		
		# insert data to db...
		$insertSql = "INSERT INTO comment VALUES ({$data->newCommentId}, {$entryId}, '{$userString}', '{$uploadDate}', '{$comment}', '{$fileString}')";
		$insertQuery = mysqli_query($dbconnect, $insertSql);
		if($insertQuery){
			$data->response = "done";
		} else { $data->response = "not sent"; }
		echo json_encode($data);
	
	# handle the comment deletion here
	} elseif($data->post['task']=="comment_delete"){
		# do some checking here
		#1 using the comment id fetch the details about this comment
		$commentId = $data->post['commentId'];
		$commenterId = NULL;
		$commenterCookieId = NULL;
		if($records->checkRecord("comment", "commentId", $commentId)==true){
			$commentDetail = $records->getRecord("comment", "commentId", $commentId);
			$commenter = json_decode($commentDetail->uId);
			$commenterId = $commenter->id;
			$commenterCookieId = $commenter->cookieId;
			#2 compare if the person trying to delete this comment is actually the one
			# that posted the comment in the first place
			if($data->commenterId==$commenterId || $data->commenterCookieId==$commenterCookieId){
				# finally delete the comment
				$delSql = "DELETE FROM comment WHERE commentId={$commentId}";
				if($insertQuery = mysqli_query($dbconnect, $delSql)){
					$data->response = "done";
				} else { $data->response = "not deleted"; }
			}
		# if the record wasn't found
		} else { $data->response = 404; }
		echo json_encode($data);
	}
}