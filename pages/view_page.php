<?php
# import the comment class
include MODELS_DIR ."comment.php";
$comment = new Comment;
# login check; $userIdentity variable is declared on the index page
$comment->getUserInfo($userIdentity);
# import the essentials class
$data = $records->getViewDetail($_GET);
# display this page only if the record exists
if($type = $data->response=="done"){
	$entryId = $data->data->entryId;
	$type = $data->type;
	$title = $data->data->title;
	$cc = $data->courseCode;
	$uploader = $data->uploader;
	$writterBit = NULL;
	if(!empty($data->file->writter)){ $writterBit = "<span class='writter'> <span class='hide_small'>&#8226; </span> written by <strong data-modal-1-trigger='writter'>{$data->file->writter}</strong></span> "; }
	#index.php?page=user_profile&uId={$uploader->uId}
	if(!empty($uploader->uId)){ $uploader = "<strong data-modal-1-trigger='uploader'>{$uploader->name}</strong>"; }
	$uploadDate = strtolower($data->uploadDate);
	// I need this variable
	$currentUserAvatar = "avatar.png";
	if(!empty($userIdentity->userDetails->thumb)){ $currentUserAvatar = "resized_".$userIdentity->userDetails->thumb; }
	elseif(!empty($userIdentity->userDetails->firstname)){
		$init_char = strtolower(substr($userIdentity->userDetails->firstname,0,1));
		$currentUserAvatar = "initials/{$init_char}.svg";
	}

	
?><div class="viewPage str_col_12">
	<div class="landing str_col_12">
    	<div class="title">
        	<div class="tag"><?php echo ucfirst($type); ?> topic | title</div>
        	<?php echo ucfirst($title); ?>
        </div>
        <div class="itags">
        	<?php echo "This {$cc} {$type} was uploaded {$uploadDate} by {$uploader} {$writterBit}"; ?>
        </div>
    </div>
    <div class="pageContent str_col_12">
    	<div class="fileWrap str_col_12">
        	<div class="link">
            	<i class="icon-adobeacrobatreader"></i>
                <span class="size"><?php echo $data->file->size; ?></span>
                <a href="<?php echo $data->file->link; ?>" title="<?php echo $data->file->name.".".$data->file->type; ?>" alt="<?php echo $data->file->name.".".$data->file->type; ?>" target="_blank" download></a>
            </div>
        </div>
    </div>
    
    <div class="commentSection">
        <div id="commentBoxWrap" class="str_col_12">
            <div class="artDivide">
                <div class="line"></div>
            </div>
            <div class="commentContainer no_outline str_col_12" data-entryId="<?php echo $entryId; ?>">
                <form method="post" id="commentForm">
                    <textarea data-user='<?php echo '{"uId":"'.$userIdentity->uId.'", "uCookieId":"'.$userIdentity->uCookieId.'", "thumb":"'.$currentUserAvatar.'"}'; ?>' type="text" placeholder="start typing to comment..."></textarea>
                    <button name="submit" id="submit"><img src="<?php echo REL_DIR; ?>images/send_ico.svg" /></button>
                </form>
            </div>
        </div>
    	
        <div class="commentsWrap str_col_12">
        	<span class="unselectable">&#8226; <strong></strong></span>
            <div class="comments str_col_12" data-essentials='<?php echo '{"entryId":"'.$entryId.'", "uId":"'.$userIdentity->uId.'", "uCookieId":"'.$userIdentity->uCookieId.'", "thumb":"'.$currentUserAvatar.'"}'; ?>'>
				<?php
				$comments = $comment->getAllComment($entryId);
				if(!empty($comments)){
					# loop over each returned comment
					foreach($comments as $comment){ echo $comment; }
					$noComment = NULL;
				} else { $noComment = ' style="display:block;"'; }
                ?>
                <div<?php echo $noComment; ?> class="noComments str_col_12"><?php echo "Be the first to comment on this {$type}"; ?></div>
            </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo REL_DIR; ?>scripts/comment.js"></script>
<script src="<?php echo REL_DIR; ?>scripts/views.js"></script>
<script src="<?php echo REL_DIR; ?>scripts/modal-1.js"></script>
<?php } else
	{ echo "oops, that wasn't supposed to happen"; }
?>