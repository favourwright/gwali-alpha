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
	
	$currentUser = NULL;
	if(!empty($_SESSION['gwalian_login_session'])){ $currentUser = $_SESSION['gwalian_login_session']; }
	
	# user wants to 
	if($task=="add new post"){
		if($rs = $records->getCourseCodes()){
			$count = count($rs->ccOriginalArr)-1;
			$_courseCodes = $rs->ccOriginalArr;
			$courseCodes = $rs->ccChangedArr;
			$ccOptions = NULL;
			for($i=0;$i<$count;$i++){
				# the only reason I use break here is because of the manipulation I did which
				# creates an extra array elememt that is empty
				if($i==$count){ break; }
				$ccOption = "<option value='{$_courseCodes[$i]}'>{$courseCodes[$i]}</option>";
				$ccOptions .= $ccOption;
			}
		}
		
		$html = "
		<div class='str_col_12'>
			<div id='mainForm' class='str_col_12'>
				<form name='newEntry' method='post' enctype='multipart/form-data'>
                    <label class='select'><span>Category</span>
                    <select name='category' required>
                        <option value=''>-select-</option>
                        <option value='note'>note</option>
                        <option value='assignment'>assignment</option>
                    </select>
                    </label>
					
                    <label class='select'><span>Course</span>
                    <select name='courseCode' required>
                        <option value=''>-select-</option>
                        {$ccOptions}
                    </select>
                    </label>
					
					<label><span>Title for this post</span>
						<textarea name='postTitle' maxlength='190' required></textarea>
					</label>
					
                    <label><span>Download link</span>
					<input name='fileLink' type='text' required>
                    </label>
					
                    <label><span>File size(kb)</span>
					<input name='fileSize' type='number' required>
                    </label>
					
                    <label><span>Writter</span>
					<input name='writter' type='text'>
                    </label>

					<label hidden><span>Select post file</span>
						<input name='fileToUpload' type='file'></textarea>
					</label>
					
					<button name='submit'>Create post</button>
					<span class='post-status'></span>
				</form>
			</div>
		</div>";
		echo $html;
	}
	
	# user wants to modify entry post
	if($task=="manage posts"){
		$all = NULL;
		$sql = "SELECT * FROM entry ORDER BY uploadDate DESC";
		if($query = mysqli_query($dbconnect, $sql)){
			if($rs = mysqli_fetch_object($query)){
				do {
				# perform the loop of each entry here
				$entryId = $rs->entryId;
				$courseId = $rs->courseId;
				$_cc = $records->getCourseCode($courseId)->_cc;
				$cc = $records->getCourseCode($courseId)->cc;
				$type = $rs->type;
				$uploadDate = $records->elaborateDateParser($rs->uploadDate);
				$title = ucfirst($rs->title);
				
				$each = "
					<div data-entryId='{$entryId}' class='str_col_12 each unselectable'>
						<div class='title'>{$title}</div>
						<div class='itags'>
							<div class='type'><i class='icon-document'></i> {$type}</div>
							<div class='courseCode'><i class='icon-layers'></i> {$cc}</div>
							<div class='dated'><i class='icon-time1'></i> {$uploadDate}</div>
						</div>
						<button><i class='icon-trash-can2'></i></button>
					</div>
				";
				$all .= $each;
				} while($rs = mysqli_fetch_object($query));
			}
		}
		
		# put the looped values into this html div
		$html = "
		<div class='str_col_12 postWrap'>
			{$all}
		</div>";
		echo $html;
	}
	
	# if user doubleclicks on entry... we're editing
	if($task=="edit posts"){
		if($rs = $records->getCourseCodes()){
			$count = count($rs->ccOriginalArr)-1;
			$_courseCodes = $rs->ccOriginalArr;
			$courseCodes = $rs->ccChangedArr;
			$ccOptions = NULL;
			for($i=0;$i<$count;$i++){
				# the only reason I use break here is because of the manipulation I did which
				# creates an extra array elememt that is empty
				if($i==$count){ break; }
				$ccOption = "<option value='{$_courseCodes[$i]}'>{$courseCodes[$i]}</option>";
				$ccOptions .= $ccOption;
			}
		}

		# get this record $table, $idName, $recordId, $targetColumn=0
		$entryId = $_POST['entryId'];
		$entry = $records->getRecord("entry", "entryId", $entryId);
		$cat = $entry->type;
		$ccs = $records->getCourseCode($entry->courseId);
		$cc = $records->getCourseCode($entry->courseId)->cc;
		$_cc = $records->getCourseCode($entry->courseId)->_cc;
		$title = $entry->title;
		$file = json_decode($entry->file);
		$link = $file->link;
		$fileSize = NULL;
		if(!empty($file->size)){ $fileSize = $file->size; }
		$writter = NULL;
		if(!empty($file->writter)){ $writter = $file->writter; }
		
		
		$html = "
		<div class='postEditWrap'>
			<div class='editForm str_col_12'>
				<form data-formEntryId='{$entryId}' method='post'>
                    <label class='select'><span>Category</span>
                    <select name='category' required>
                        <option value='{$cat}'>-{$cat}-</option>
                        <option value='note'>note</option>
                        <option value='assignment'>assignment</option>
                    </select>
                    </label>
					
                    <label class='select'><span>Course</span>
                    <select name='courseCode' required>
                        <option value='{$_cc}'>-{$cc}-</option>
                        {$ccOptions}
                    </select>
                    </label>
					
					<label><span>Title for this post</span>
						<textarea name='postTitle' maxlength='190' required>{$title}</textarea>
					</label>
					
                    <label><span>Download link</span>
					<input name='fileLink' type='text' value='{$link}' required>
                    </label>
					
                    <label><span>File size(kb)</span>
					<input name='fileSize' type='number' value='{$fileSize}' required>
                    </label>
					
                    <label><span>Writter</span>
					<input name='writter' type='text' value='{$writter}'>
                    </label>

					<label hidden><span>Select post file</span>
						<input name='fileToUpload' type='file'>
					</label>
					
					<button name='submit'>UPDATE</button>
					<span class='update-status'></span>
				</form>
				
				<div class='closeBtn'><i class='icon-cancel'></i></div>
			</div>
		</div>";
		echo $html;
	}
	
	# when user wants to create new supported course
	if($task=="add new course"){
		$html = "
		<div class='newCourseCode str_col_12'>
			<div class='info str_col_12 unselectable'>Should be in the format <span class='text_green bold_text'>course_code</span> (with an underscore) not <span>course code</span>, <span>course-code</span> or <span>coursecode</span></div>
			<form method='post'>
				<label><span>course code</span>
				<input name='courseCode' type='text' required>
				</label>
				
				<button name='submit'>Add course</button>
				<span class='status'></span>
			</form>
		</div>";
		echo $html;
	}
	
	# when user wants to manage supported courses
	if($task=="manage existing courses"){
		if($rs = $records->getCourseCodes()){
			$count = count($rs->ccOriginalArr)-1;
			$_courseCodes = $rs->ccOriginalArr;
			$courseCodes = $rs->ccChangedArr;
			$all = NULL;
			for($i=0;$i<$count;$i++){
				# the only reason I use break here is because of the manipulation I did which
				# creates an extra array elememt that is empty
				if($i==$count){ break; }
				$each = "
				<div data-cc='{$_courseCodes[$i]}' class='each flex'>
					{$courseCodes[$i]}
					<div class='btn flex'><i class='icon-minus'></i></div>
				</div>";
				$all .= $each;
			}
		}
		$html = "
		<div class='allCourses unselectable'>
			{$all}
		</div>";
		echo $html;
	}
	
	# managing contact us messages
	if($task=="contact us messages"){
		$all = NULL;
		$sql = "SELECT * FROM contact_us ORDER BY messageDate DESC";
		if($query = mysqli_query($dbconnect, $sql)){
			if($rs = mysqli_fetch_object($query)){
				do {
				# perform the loop of each entry here
				$messageId = $rs->messageId;
				$resolved = $rs->resolved;
				$res_css = "false";
				$res_btn = "<button class='resBtn'>Resolve</button>";
				$del_btn = NULL;
				if($resolved==1){
					# if the post has been resolved dont display the btn
					$res_css = "true"; $res_btn = NULL;
					$del_btn = "<button class='delBtn'><i class='icon-trash-can2'></i></button>";
				}
				$messageDate = $records->elaborateDateParser($rs->messageDate);
				$sender = json_decode($rs->sender);
				$uId = $sender->uId;
				$cookieId = $sender->uCookieId;
				$name = ucfirst($sender->name);
				$email = $sender->email;
				$registered = $sender->registered;
				$reg_css = "false";
				if($registered==1){$reg_css = "true"; }
				$data = json_decode($rs->data);
				$message = nl2br($data->message);
				$purpose = ucfirst($data->purpose);
				$date = $records->elaborateDateParser($rs->messageDate);
				
				$each = "
					<div data-messageId='{$messageId}' class='str_col_12 each'>
						<div class='info'>
							<div class='tags'>
								<span>Reason for contact - </span>
								<span>{$purpose}</span>
								&#8226;
							</div>
							<div class='tags'>
								<span class='{$reg_css}'>Registered</span>
								&#8226;
							</div>
							<div class='tags'>
								<span>Name - </span>
								<span>{$name}</span>
								&#8226;
							</div>
							<div class='tags'>
								<span>Email - </span>
								<span>{$email}</span>
								&#8226;
							</div>
							<div class='tags'>
								<span class='{$res_css}'>Resolved</span>
								&#8226;
							</div>
							<div class='tags'>
								<span>{$date}</span>
							</div>
						</div>
						
						<div class='message'>{$message}</div>
						<div class='action'>
							{$del_btn}
							{$res_btn}
						</div>
					</div>
				";
				$all .= $each;
				} while($rs = mysqli_fetch_object($query));
			}
		}
		
		# put the looped values into this html div
		$html = "
		<div class='str_col_12 contactUsMessages'>
			{$all}
		</div>";
		echo $html;
	}
	
	# for the password reset
	if($task=="password recovery requests"){
		$all = NULL;
		$sql = "SELECT * FROM pass_reset ORDER BY requestDate DESC";
		if($query = mysqli_query($dbconnect, $sql)){
			if($rs = mysqli_fetch_object($query)){
				do{
				$token = $rs->token;
				$requester = $student->studentIdentifier($rs->uId);
				$firstname = ucfirst($requester->userDetails->firstname);
				$email = $requester->userDetails->mail;
				$name = ucwords("{$firstname} {$requester->userDetails->lastname}");
				$ico_done = "<img src='images/check.png' />";
				# if the email has been sent
				$issent = $rs->resolved; if($issent){ $issent = $ico_done; } else { $issent=NULL; }
				# if the link has been used
				$isused = $rs->linkUsed; if($isused){ $isused = $ico_done; } else { $isused=NULL; }
				
				# if email has been sent and user has visited link and used it
				$isdone = NULL;
				if($rs->resolved && $rs->linkUsed && $rs->linkVisited){ $isdone = " fin"; }
				
				# action buttons
				$mail_btn = NULL;
				if(!$rs->resolved){ $mail_btn = "<button id='issent'>Mail sent</button>"; }
				$del_btn = NULL;
				if($rs->linkUsed){ $del_btn = "<button id='delete'>Delete</button>"; }
				
				$each = "
				<div class='each' data-accordion  data-targetUId='{$rs->uId}'>
					<div class='head' data-acc-toggler>
						<div class='name'>{$name}</div>
						<div class='status{$isdone}'>
							<div class='wrap flex'>
								<!--Indicates if email has been sent by admin-->
								<div class='indicator' title='Indicates if email has been sent'>{$issent}</div>
								<!--Indicates link has been used-->
								<div class='indicator' title='Indicates link has been used'>{$isused}</div>
							</div>
						</div>
					</div>
					
					<div class='container' data-acc-target>
						<div class='subject'><span>Password Reset Request</span></div>
						<div class='message'>
							{$firstname}, We received an account recovery request on Gwalinotes for your account associated with {$email}.<br />
							If you initiated this request, reset your password by clicking the link below
							www.gwalinotes.com/settings&token={$token}
						</div>
						{$mail_btn}{$del_btn}
						<span class='status'></span>
					</div>
				</div>";
				
				$all.=$each;
				} while($rs = mysqli_fetch_object($query));
			}
		}
		
		# varialble to pack the iterate		
		$html = "
		<div class='str_col_12 resetRequests no_outline'>
			{$all}
			<script src='scripts/accordion.js'></script>
		</div>";
		echo $html;
	}
}