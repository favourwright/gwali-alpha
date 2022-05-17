$(document).ready(function() {
	// run these functions once page is ready
	initiateDel();
	hideDel();
	delComment();
	listenForNewComment();
	checkComment();
	// resize textarea function
	resizeTextarea();
});
var REL_DIR = getCookie("REL_DIR");
// check if there are comments, if not
// display a friendly message
function checkComment(){
	var commentBox = $(".comments");
	var comments = $(commentBox).find(".each").length;
	var message = $(".noComments");
	if(comments==0){ $(message).fadeIn(); } else { $(message).hide(); }
	
	// update the comment count
	var strong = $(commentBox).prev().find("strong");
	var countDisp = 'no comments';
	if(comments==1){ countDisp = '1 comment'; }
	else if(comments>1){ countDisp = comments+' comments'; }
	$(strong).html(countDisp);
}
// look out for double clicks on comment
// double click makes the comment deletable
function initiateDel(){
	var comment = $(".comment");
	$(comment).dblclick(function(e) {
		var clicked = e.currentTarget;
		var delOverlay = $(clicked).find(".delOverlay");
		$(delOverlay).addClass("show");
	});
}
// remove the delete button from comment by
// double click
function hideDel(){
	var delOverlay = $(".delOverlay");
	$(delOverlay).dblclick(function(e) {
		var clicked = e.currentTarget;
		$(clicked).removeClass("show");
		// event bubbling is what I stopped here because the bubbling 
		// causes the "double click" on the comment element having the
		// function( initiateDel() ) to re-run. making the "show" class to be added again
		event.stopPropagation();
	});
}
// function in charge of the main deletion of
// comment
function delComment(){
	var btn = $(".delCommentBtn");
	$(btn).click(function(e) {
        var _this = e.target;
		var parent = $(_this).parent().parent().parent().parent();
		var commentId = $(parent).attr("data-commentId");
		var essential = JSON.parse($(parent).parent().attr("data-essentials"));
		var detail = {commentId:commentId, essentials:essential};
		
		// run AJAX function... that finally after it runs successfully
		// detaches the comment
		commentDelete(detail);
    });
}
// watchout for new typed comment on the comment box
function listenForNewComment(){
	var commentForm = $("#commentForm");
	var entryId = $(commentForm).parent().attr("data-entryId");
	var submitBtn = $(commentForm).find("#submit");
	$(commentForm).submit(function(e){
		e.preventDefault();
		var textarea = $(this).find("textarea");
		var comment = $(textarea).val();
		var user = $(textarea).attr("data-user");
		var check = comment.replace(/ /g, '');
		if(check!=""){ newComment(user, entryId, comment, textarea); }
    });
}
// make the comment template handy
function commentTemplate(commentId, tempId, comment, avatar, response){
	if(commentId!="" && commentId!=null){
		var thisComment = $('[data-commentId="'+tempId+'"]');
		// update the comment id
		$(thisComment).attr("data-commentId", commentId);
		var progressBox = $(thisComment).find(".sending");
		if(response=="done"){
			$(progressBox).html("sent");
			// remove the status preview after a sec
			setTimeout(function(){ $(progressBox).detach(); }, 1000);
			return "update success";
		} else if(response=="not sent"){
			$(progressBox).html("<div class='ico'><i class='icon-rotate'></i></div> <div class='text'>retry</div>");
			
			// this is only aesthetics, but, make the button pointer type cursor
			$(progressBox).css("cursor", "pointer");
			// make the progress button which currently is displaying "retry" due to server error
			// a button. now, I'm working with html values. so I need to be careful
			$(progressBox).click(function(e) {
				var	retryBtn = $(this);		
				newCommentRetry(retryBtn);
            });
		}
	} else {
		// generate a "unique" id from 100000 - 1000000
		var commentId = ((Math.random()*100000000)+1000000);
		// do this to convert \n = new line to break tags
		var comment = comment.split("\n").join("<br />");
		var html = '';
			html += "<div data-commentId='"+commentId+"' class='each me'>";
			html += "	<div class='commenter'>";
			html += "		<div class='img'>";
			html += "			<img src='"+REL_DIR+"images/user/"+avatar+"'>";
			html += "		</div>";
			html += "	</div>";
			html += "	<div class='comment'>";
			html += "		<strong>"+comment+"</strong>";
			html += "		<div class='delOverlay'> <div class='delCommentBtn'> <i class='icon-trash-can2'></i> </div> </div>";
			html += "	</div>";
			html += "	<div class='commentDate'>just now &#8226; You</div>";
			html += "	<div class='sending'><img src='"+REL_DIR+"images/loader.gif' /> sending</div>";
			html += "</div>";
		// pack this element into an object plus the generated id
		var temp = {elem:html, commentId:commentId};
		return temp;
	}
}

function newComment(user, entryId, comment, elem){
	// at this point, clearout the content on the textarea box
	// to avoid duplicate entry
	$(elem).val("");
	var commentsContainer = $('.comments');
	// convert to json
	var userInfo = JSON.parse(user);
	var tempContent = commentTemplate("", "", comment, userInfo.thumb);
	var CommentElem = tempContent.elem;
	var tempCommentId = tempContent.commentId;
	// insert the comment right away but with a temporary id untill
	// its inserted into the database the I update the id
	$(commentsContainer).append(CommentElem);
	// run this function to remove the default message: when there's no comment
	checkComment();
	
	// do the ajax call here
	$.post(REL_DIR+"pages/scripts/commentHandler.php",
		{
			task: "post_new_comment",
			user: userInfo,
			entryId: entryId,
			comment: comment
		}
	).done(function(data){
		var jsonData = JSON.parse(data);
		// check if all went well on the insertion
		if(jsonData.response=="done"){
			// run this function to update the commentId
			commentTemplate(jsonData.newCommentId,tempCommentId,"","",jsonData.response);
		} else if(jsonData.response=="not sent") {
			// if the recode couldn't be inserted
			commentTemplate(jsonData.newCommentId,tempCommentId,"","",jsonData.response);
		}
	});
		
	// re-run these else... the function won't work for newly inserted comments
	initiateDel();
	hideDel();
	delComment();
}

// this is the retry function
function newCommentRetry(retryBtn){
	var retryBtn = $(retryBtn);
	var commentBox = $(retryBtn).parent(retryBtn);
	var essentials = JSON.parse($(commentBox).parent().attr("data-essentials"));
	var userInfo = {uId:essentials.uId, uIp:essentials.uIp, thumb:essentials.thumb};
	var entryId = essentials.entryId;
	var comment = $(commentBox).find(".comment").find("strong").html();
	var avatar = $(commentBox).find(".img");
	avatar = $(avatar).find("img").attr("src");
	// this is done only because I'm getting the image name from the html
	var avatarArr = avatar.split("/");
	// get the last array index which is the image name
	var avatar = avatarArr[avatarArr.length-1];
	// container housing all comments
	var commentsContainer = $('.comments');
	// remove the old comment ie "this" comment
	$(commentBox).detach();
	// call this function again
	var tempContent = commentTemplate("", "", comment, avatar);
	var tempCommentId = tempContent.commentId;
	$(commentsContainer).append(tempContent.elem);
	
	// because previously, \n was converted to br tags, this is necessary
	// else there'd be extra characters in the comment
	comment = comment.split("<br>").join("\n");
	comment = comment.split("<br />").join("\n");
	// no need running this function again; checkComment(): which updates the comment
	// count and... because when a user retrys, its that same comment that re-enters
	// the commentContainer. Two comments can never be inserted at "retry".
	// so next up is to do the ajax call again to the same script
	$.post(REL_DIR+"pages/scripts/commentHandler.php",
		{
			task: "post_new_comment_retry",
			user: userInfo,
			entryId: entryId,
			comment: comment,
		}
	).done(function(data){
		var jsonData = JSON.parse(data);
		// check if all went well on the insertion
		if(jsonData.response=="done"){
			// run this function to update the commentId
			commentTemplate(jsonData.newCommentId,tempCommentId,"","",jsonData.response);
		} else if(jsonData.response=="not sent") {
			// if the recode couldn't be inserted
			commentTemplate(jsonData.newCommentId,tempCommentId,"","",jsonData.response);
		}
	});
		
	// re run these else... the function won't work for these re-sent  comments
	initiateDel();
	hideDel();
	delComment();
}
// function that deletes a comment when the user has clicked on the delete icon
function commentDelete(detail){
	var commentId = detail.commentId;
	var user = {uId:detail.essentials.uId, uCookieId:detail.essentials.uCookieId}

	$.post(REL_DIR+"pages/scripts/commentHandler.php",
		{
			task: "comment_delete",
			commentId: commentId,
			user: user
		}
	).done(function(data){
		data = JSON.parse(data);
		if(data.response=="done"){
			// records been deleted so detach this comment
			$("[data-commentId='"+commentId+"']").detach();
		} else if(data.response=="not deleted"){
			// server error leading to non deletion so lets retry; shall we?
		} else if(data.response==404){
			// the comment was not found to begin with. maybe the user is pentesting or
			// the comment has already been deleted, still give retry option
		}
		// run this each time a comment is deleted
		checkComment();
	});
}
function resizeTextarea(){
	var textarea = $('textarea');
	var form = $(textarea).parent().innerHeight();
	// change its height on focus
	$(textarea).focus(function(e) { $(this).css("height", (18*4)+"px"); });
	$(textarea).blur(function(e) {
		var _this = this;
		var content = $(_this).val();
		$(this).css("height", (form)+"px");
	});
}