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
	if($task=="load_more"){
		$count = $_POST['total_count'];
		$offset = $_POST['displayed'];
		$filter = NULL;
		
		# only fetch more records if $offset is < $count ie
		if($count > $offset){
			# get the filter variable
			$filter = $_POST['filter'];
			$cond = NULL;
			if(!empty($filter)){
				# check if it exist
				if($records->checkRecord_loose("course", "courseCode", "'{$filter}'")==true){
					$filter_rs = $records->getRecord_loose("course", "courseCode", "'{$filter}'", "courseId");
					$filter = $filter_rs->courseId;
					
					# at this point, check if the course code is an "entry"
					if($records->checkRecord("entry", "courseId", $filter)){
						$cond = "AND courseId=$filter";
					}
				}
			}
			
			#I'll be loading extra 10 posts
			$addition = 10;
			if($count < $offset+$addition){ $addition = $count-$offset; }
			# variable that all the available records will be packed into
			$limit = $offset+$addition;
			$entries = NULL;
			# for now...
			$sql = "SELECT * FROM entry WHERE live=1 $cond ORDER BY uploadDate DESC LIMIT {$offset},{$addition}";
			if($query = mysqli_query($dbconnect, $sql)){
				if($rs = mysqli_fetch_object($query)){
					do {
						$post = new stdClass();
						$post->id = $rs->entryId;
						$post->type = $rs->type;
						$post->uploadDate = $rs->uploadDate;
						$post->uploader = $rs->uploaderId;
						$post->courseId = $rs->courseId;
						$post->title = ucfirst($rs->title);
						# if the character length for title is too long... trim it
						if(strlen($post->title)>52){ $post->title = substr($post->title,0,52)."..."; }
						$post->_file = $rs->file;
						$post->cc = NULL;
						$post->uploadDate = $records->elaborateDateParser($post->uploadDate);
						$post->views = NULL;
						$post->avatar = "avatar.png";
						
						# getting course code
						if($records->checkRecord("course", "courseId", $post->courseId)==true){
							$cc = $records->getRecord("course", "courseId", $post->courseId, "courseCode");
							$post->cc = strtoupper(str_replace("_", " ", $cc->courseCode));
						}
						# getting uploader image
						if($records->checkRecord("user", "uId", $post->uploader)==true){
							$user = $records->getRecord("user", "uId", $post->uploader, "thumb");
							if(!empty($user->thumb)){ $post->avatar = "resized_{$user->thumb}"; }
						}
						
						# getting number of views
						$post->views = $records->getViewers("views", "entryId", $post->id);
						$viewSuffix = "views";
						if($post->views==1){$viewSuffix = "view";}
							
						# this is done here because of seo
						#$viewLink = REL_DIR."?page=view_page&{$records->type}Id={$records->id}";
						#preview/([a-zA-Z]+)/([0-9]+)
						$viewLink = REL_DIR."preview/{$post->type}/{$post->id}";
						
						$data = "
							<div class='each'>
								<div class='survey'></div>
								<div class='main'>
									<div class='avatar'>
										<div class='img'>
											<img src='".REL_DIR."images/user/{$post->avatar}' />
										</div>
									</div>
									<div class='title'>{$post->title}</div>
									<div class='views'><i class='icon-eye'></i> {$post->views} {$viewSuffix}</div>
									<div class='itags'>
										<div class='type'><i class='icon-document'></i> {$post->type}</div>
										<div class='courseCode'><i class='icon-layers'></i> {$post->cc}</div>
										<div class='dated'><i class='icon-time1'></i> {$post->uploadDate}</div>
									</div>
								<a href='{$viewLink}'></a>
								</div>
							</div> ";
						# pack each entry into the array
						$entries .= $data;
					} while($rs = mysqli_fetch_object($query));
				}
			}

			# session that makes the homepage reload remember how many records to load
			$_SESSION['auto_loadMore'] = $limit;
			
			$output = new stdClass();
			$output->data = $entries;
			$output->total = $count;
			$output->displayed = $limit;
			echo json_encode($output);
		}
	}
}