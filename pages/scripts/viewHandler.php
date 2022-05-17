<?php
$data = new stdClass();
$data->post = $_POST;
$data->entryId = NULL;
$data->viewerId = NULL;
$data->viewerCookieId = NULL;
$data->response = NULL;
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
	$records = new Records;
	$data->viewerId = $data->post["essential"]["uId"];
	$data->viewerCookieId = $data->post["essential"]["uCookieId"];
	$data->entryId = $data->post["essential"]["entryId"];

	# fulfil the necessary procedures for new view insertion
	if($data->post['task']=="new_view"){
		$data->status = NULL;
		# if user signed-in use the userId else use the cookieId in fingerprint query
		if(!empty($data->viewerId)){ $fingerP = "JSON_EXTRACT(`fingerprint`, '$.uId') = '{$data->viewerId}'"; }
		else { $fingerP = "JSON_EXTRACT(`fingerprint`, '$.cookieId') = '{$data->viewerCookieId}'"; }
		$date = "JSON_EXTRACT(`fingerprint`, '$.datetime') DESC";
		echo $getSql = "SELECT * FROM views WHERE entryId={$data->entryId} AND {$fingerP} ORDER BY {$date}";
		if($getQuery = mysqli_query($dbconnect, $getSql)){
			if($getRs = mysqli_fetch_object($getQuery)){
				# user has viewed this post before.
				# without looping through the only result here would be the last one
				$fingerprint = json_decode($getRs->fingerprint);
				$datetime = $fingerprint->datetime;
				$numDays = $records->getDateDays($datetime);
				# if user viewed like a day ago, set the status to be true
				if($numDays >= 1){ $data->status = true; }
			# if the user has not viewed this post before
			} else { $data->status = true; }
		}
		
		if($data->status == true){
			$viewId = rand(100000, 1000000);
			$uploadDate = date("Y-m-d H:i:s");
			# let PHP generate the json that'll be inserted into the database
			$fingerprintQ = "JSON_OBJECT('uId', '{$data->viewerId}', 'cookieId', '{$data->viewerCookieId}', 'datetime', '{$uploadDate}')";
			$sql = "INSERT INTO views VALUES ({$viewId}, {$data->entryId}, {$fingerprintQ})";
			if($query = mysqli_query($dbconnect, $sql)){ $data->response = "done"; }
		}
		echo json_encode($data);
	}
}