<?php
class Comment extends Records {
	public $user;
	function getUserInfo($input=0){
		$this->user = $input;
	}

	# function that fetches all comments
	public function getAllComment($entryId=0){
		if(!empty($entryId)){
			$comment = NULL;
			$sql = "SELECT * FROM comment WHERE entryId={$entryId} ORDER BY commentDate ASC";
			$query = mysqli_query($this->dbconnect(), $sql);
			if($rs = mysqli_fetch_object($query)){
				# variable to house all comments
				$comment = array();
				do{
					$details = new stdClass();
					$details->commenterId = NULL;
					$details->commenterCookieId = NULL;
					$details->commenterImg = "avatar.png";
					$details->commenter = json_decode($rs->uId);
					if(!empty($details->commenter->id)){ $details->commenterId = $details->commenter->id; }
					if(!empty($details->commenter->cookieId)){ $details->commenterCookieId = $details->commenter->cookieId; }
					# check if this commenter is a signup user, if true, get details
					if($this->checkRecord("user", "uId", $details->commenterId)==true){
						$userRs = $this->getRecord("user", "uId", $details->commenterId, "name, thumb");
						$details->commenterName = ucfirst(json_decode($userRs->name)->firstname);
						$init_char = strtolower(substr($details->commenterName,0,1));
						if(!empty($userRs->thumb)){ $details->commenterImg = "resized_".$userRs->thumb; }
						# use a designed typograph of the first later of their name
						else{ $details->commenterImg = "initials/{$init_char}.svg"; }
						
						# perform another check to know if user is an admin
						if($this->checkRecord("g_admin", "uId", $details->commenterId)==true){
							# user is in the general admin table
							$g_admin = $this->getRecord("g_admin", "uId", $details->commenterId);
							# check if this admin has been authenticated
							if($g_admin->auth==1){ $details->g_admin = $details->commenterId; }
						}
						if($this->checkRecord("s_admin", "uId", $details->commenterId)==true){
							# user is in the super admin table
							$s_admin = $this->getRecord("s_admin", "uId", $details->commenterId);
							if($s_admin->auth==1){ $details->s_admin = $details->commenterId; }
						}
					} else { $details->commenterName = "Gwalian"; }
					$details->commentId = $rs->commentId;
					
					$css = ' unselectable';
					$delCommentBtn = NULL;
					# comparing current user with commenter to know if its same person
					if($this->user->uId!=0 && $this->user->uId==$details->commenterId || $this->user->uCookieId!=0 && $this->user->uCookieId==$details->commenterCookieId){
						$details->commenterName = "You"; $css = " me";
						# make the delete comment button available to only the commenter
						$delCommentBtn = "<div class='delOverlay'> <div class='delCommentBtn'> <i class='icon-trash-can2'></i> </div> </div>";
					}					
					$details->entryId = $rs->entryId;
					$details->commentDate = $this->elaborateDateParser($rs->commentDate);
					$details->comment = $rs->comment;
					# detect hyper-links
					$details->comment = $this->linkify($details->comment);
					
					$details->_file = $rs->file;
					$admin = NULL;
					# only display this verified badge for admins
					if(!empty($details->s_admin) || !empty($details->g_admin)){ $admin = "<div class='badge'><img src='".REL_DIR."images/verified_white.svg'></div>"; }
					
					$html = "
						<div data-commentId='{$details->commentId}' class='each{$css}'>
							<div class='commenter'>
								<div class='img'>
									<img src='".REL_DIR."images/user/{$details->commenterImg}'>
									<i class='abs'></i>
								</div>
								{$admin}
							</div>
							<div class='comment'>
								<strong>{$details->comment}</strong>
								{$delCommentBtn}
							</div>
							<div class='commentDate unselectable'>{$details->commentDate} &#8226; {$details->commenterName}</div>
						</div>
						";
					$comment[] = $html;
				} while($rs = mysqli_fetch_object($query));
				return $comment;
			}
		}
	}
}