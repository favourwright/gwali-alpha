$(document).ready(function() {
	notification();
});
var REL_DIR = getCookie("REL_DIR");
// cache the avalable buttons
var buttons = $(".actionBtnGroup").find(".each");
$(buttons).click(function() {
    var targetBtn = this;
	var action = $(targetBtn).attr("data-action");
	detectAction(action);	
});
// detect the action that was selected
function detectAction(action){
	if(action == "new entry"){ newEntry(); }
	if(action == "manage entries"){ manageEntries(); }
	if(action == "new courses"){ newCourses(); }
	if(action == "manage courses"){ manageCourses(); }
	if(action == "contact us"){ contactUs(); }
	if(action == "password recovery"){ passRecovery(); }
}
var spinner = "<div class='loading'><img title='please wait...' src='"+REL_DIR+"images/loader.gif' /></div>";
var statusDone = '<i class="icon-checkmark text_green font_22" title="success!"></i>';
// adding of new post and related
function newEntry(){
	// object having the action name and the html content is created here
	var object = {action:"add new post", content:spinner}
	// before the ajax fetches data... show user that something is going on
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ createNewPost() }, 400);
	});
}
// managing of existing posts
function manageEntries(){
	var object = {action:"manage posts", content:spinner}
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ modifyExistingEntry() }, 400);
	});
}
// adding new supported course code
function newCourses(){
	var content = spinner;
	var object = {action:"add new course", content:spinner}
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ newSupportedCourse() }, 400);
	});
}
// managing existing supported coursecodes
function manageCourses(){
	var object = {action:"manage existing courses", content:spinner}
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ managePostedCourses() }, 400);
	});
}
// manage all the contact us messages sent to us
function contactUs(){
	var object = {action:"contact us messages", content:spinner}
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ resolveContactMsg(); delContactMsg(); }, 400);
	});
}
// manage the password recovery requests sent to us
function passRecovery(){
	var object = {action:"password recovery requests", content:spinner}
	populateActionModal(object);
	
	$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
		{ task:object.action }
	).done(function(data){
		object.content = data;
		populateActionModal(object);
		// I need to wait for a while before callin this function
		// because the html elements gets added after some delay too
		setTimeout(function(){ resetInteraction(); }, 400);
	});
}
// deals with updating the modal with the right data
function populateActionModal(object){
	// show the modal once this function is called
	showModal();
	var modalWrap = $("#actionModalWrap");
	var modalId = $(modalWrap).attr("id");
	var backBtn = $(modalWrap).find(".backBtn");
	// check if what user is clicking on is the wrap
	// (making sure the click wasn't on its children)
	$(document).click(function(e) {
		var target = e.target.getAttribute("id");
        if(target==modalId){ hideModal(); }
    });
	// when the back button is clicked on close the modal too
	$(backBtn).click(function() { hideModal(); });
	var title_div = $(modalWrap).find(".actionName");
	var content_div = $(modalWrap).find(".content");
	// work with the parsed-in object
	var titleName = object.action;
	var content = object.content;
	
	// populate the html
	$(title_div).html(titleName);
	// wait half a sec before populating the content area
	setTimeout(function(){ $(content_div).html(content); }, 300);
	setTimeout(function(){ formHomekeeping(); }, 300);
	
	// update unresolved message notification
	notification();
}
function showModal(){
	$("#actionModalWrap").show("fast");
}
function hideModal(){
	var modalWrap = $("#actionModalWrap");
	$(modalWrap).hide("fast");
	$(modalWrap).find(".content").html("");
}
// function that submits the form for new post creation
function createNewPost(){
	var form = $("form");
	$(form).submit(function(e) {
		e.preventDefault();
		var form = this;
		var btn = $(this).find("[name='submit']")[0];
		var status = $(this).find(".post-status");
		btn.disabled=true;
		$(status).html(spinner);
	
		// get the form data from this externally defined function
		var formData = getFormDataAsOject(form);
		$.post(REL_DIR+"pages/scripts/newPostHandler.php",
			{
				task:"new_post",
				formData:formData			
			}
		).done(function(data){
			console.log(data)
			data = JSON.parse(data);
			if(data.response==200){
				$(status).html(statusDone);
				// hide the modal after some split seconds
				setTimeout(function(){ hideModal(); }, 1000);
			} else if(data.response=="error") {
				$(status).html("<pre>course code error: "+data.message.cc+"</pre>");
				$(status).append("<pre>sql error: "+data.message.sql+"</pre>");
				btn.disabled=false;
			}
		});
	});
}

function modifyExistingEntry(){
	var container = $(".postWrap");
	var entries = $(container).find(".each");
	var buttons = $(entries).find("button");
	
	$(entries).click(function() {
		var entry = this;
        var button = $(entry).find("button");
		
		// remove the active state for the others that are not the current / selected
		// entry / post
		$(entries).each(function() {
            $(this).not(entry).removeClass("active");
            $(this).not(entry).find("button").css("display", "none");
        });
		
		// change the background color of the selected post
		if($(entry).hasClass("active")){ $(entry).removeClass("active"); $(button).css("display", "none"); }
		else { $(entry).addClass("active"); $(button).css("display", "block"); }
    });
	
	// this is incharge of editing this post
	$(entries).dblclick(function(e) {
		var entry = this;
		var entryId = $(entry).attr("data-entryId");
		//console.log(entry);
		$.post(REL_DIR+"pages/scripts/adminDashboardHandler.php",
			{
				task:"edit posts",
				entryId:entryId
			}
		).done(function(data){
			showEditModal(data);
			
			// watch out for form submission
			updateEntry();
		});
    });
	
	// assign the delete event to all the buttons
	$(buttons).click(function(){
		var btn = this;
		var entry = $(btn).parent();
		var entryId = $(entry).attr("data-entryId");
		
		// alert the user for deletion confirmation
		var confirmAction = confirm("Are you sure you want to delete this post?");
		
		if(confirmAction==true){
			// send the ajax call that deletes this record
			$.post(REL_DIR+"pages/scripts/deletePostHandler.php",
				{
					task:"delete_post",
					entryId:entryId		
				}
			).done(function(data){
				// remove the post from DOM with an animation
				$(entry).hide("fast", function(){ $(this).detach(); });
			});
		}
    });
}

// updating of entry from the popup modal
function updateEntry(){
	var editorWrap = $(".postEditWrap");
	var editorWrapClass = $(editorWrap).attr("class");
	var editForm = $(editorWrap).find("form");
	var entryId = $(editForm).attr("data-formEntryId");
	var closeBtn = $(editorWrap).find(".closeBtn");
	
	// get this particular entry being worked on
	var postWrap = $(".postEditWrap").parent();
	var entry = $(postWrap).find("[data-entryId='"+entryId+"']");
	
	// close the form when the background is clicked
	$(editorWrap).click(function(e) {
		var targetClass = e.target.getAttribute("class");
		// close only if target was only the background
        if(targetClass==editorWrapClass){ hideEditModal(); }
    });
	// close the form when the close button is clicked
	$(closeBtn).click(function() { hideEditModal() });
	
	$(editForm).submit(function(e) {
        e.preventDefault();
		var form = this;
		var btn = $(this).find("[name='submit']")[0];
		var status = $(this).find(".update-status");
		btn.disabled=true;
		$(status).html(spinner);
		
		// get the form data from this externally defined function
		var formData = getFormDataAsOject(form);
		$.post(REL_DIR+"pages/scripts/updatePostHandler.php",
			{
				task:"update_post",
				entryId:entryId,			
				formData:formData			
			}
		).done(function(data){
			data = JSON.parse(data);
			if(data.response==200){
				$(entry).find(".title").html(data.title)
				$(entry).find(".type").html('<i class="icon-document"></i> '+data.cat)
				$(entry).find(".courseCode").html('<i class="icon-layers"></i> '+data.cc)
				$(status).html(statusDone);
				// hide the modal after some split seconds
				setTimeout(function(){ hideEditModal(); }, 1000);
			} else if(data.response=="error") {
				$(status).html("<pre>course code error: "+data.message.cc+"</pre>");
				$(status).append("<pre>sql error: "+data.message.sql+"</pre>");
				btn.disabled=false;
			}
		});
    });
}
function showEditModal(data){
	var container = $(".postWrap");
	$(container).append(data);
}
function hideEditModal(){
	var editFormWrap = $(".postEditWrap");
	$(editFormWrap).hide(100, function(){ $(this).detach() } );
}

function newSupportedCourse(){
	var courseCodeWrap = $(".newCourseCode");
	var form = $(courseCodeWrap).find("form");
	
	$(form).submit(function(e){
        e.preventDefault();
		var btn = $(this).find("button")[0];
		var input = $(this).find("input");
		var status = $(this).find(".status");
		var courseCode = $(input).val();

		btn.disabled=true;
		$(status).html(spinner);
		
		// get the form data from this externally defined function
		var formData = getFormDataAsOject(form);
		$.post(REL_DIR+"pages/scripts/newCourseHandler.php",
			{
				task:"new_course",
				formData:formData
			}
		).done(function(data){
			data = JSON.parse(data);
			if(data.response==200){
				$(status).html(statusDone);
				setTimeout(function(){ hideModal(); }, 1000);
			} else {
				btn.disabled=false;
				if(data.message.cc){ $(status).html(data.message.cc); }
				if(data.message.sql){ $(status).html(data.message.sql); }
			}
		});
    });
}

function managePostedCourses(){
	var container = $(".allCourses");
	var btn = $(container).find(".btn");
	
	$(btn).click(function() {
        var clickedBtn = this;
		var wrap = $(clickedBtn).parent();
		var courseCode = $(wrap).attr("data-cc")
		
		var proceed = confirm("Are you sure you want to delete ("+courseCode+")");
		if(proceed==true){
			$.post(REL_DIR+"pages/scripts/deleteCourseHandler.php", { task:"delete_course", courseCode:courseCode }
			).done(function(data){
				data = JSON.parse(data);
				if(data.response == 200){ $(wrap).detach(); }
			});
		}
    });
}

// when user wants to mark a message as resolved
function resolveContactMsg(){
	var container = $(".contactUsMessages");
	var delBtnElem = "<button class='delBtn'><i class='icon-trash-can2'></i></button>";
	var resolveBtn = $(container).find(".resBtn");

	$(resolveBtn).click(function() {
        var clickedBtn = this;
		var wrap = $(clickedBtn).parent().parent();
		var messageId = $(wrap).attr("data-messageid");
		var sender = $(wrap).find(".tags")[2];
			sender = $(sender).find("span")[1];
			sender = $(sender).html();
		var resText = $(wrap).find(".tags")[4];
			resText = $(resText).find("span");
		
		// confirm that user wants to do this
		var proceed = confirm("Mark "+sender+"'s message as resolved?");
		if(proceed==true){
			$.post(REL_DIR+"pages/scripts/modifyContactMessageHandler.php", { task:"resolve", messageId:messageId }
			).done(function(data){
				data = JSON.parse(data);
				if(data.response == 200){
					$(resText).attr("class", "true");
					$(clickedBtn).parent().append(delBtnElem);
					$(clickedBtn).detach();
					// assign the event on the delete button
					delContactMsg();
					
					// after the the message has been marked each time, get the current
					// value of the notifier
					var notifier = $("[data-action='contact us']").find(".notifCount");
					var notifierVal = parseInt($(notifier).html());
					// check if the message was only 1
					$(notifier).html(notifierVal-1)
					if((notifierVal-1)==0){ $(notifier).hide("fast"); }
				}
			});
		}
    });
}

function delContactMsg(){
	var container = $(".contactUsMessages");
	var delBtn = $(container).find(".delBtn");
	
	// if user wants to mark a message as resolved
	$(delBtn).click(function() {
        var clickedBtn = this;
		var wrap = $(clickedBtn).parent().parent();
		var messageId = $(wrap).attr("data-messageid");
		var sender = $(wrap).find(".tags")[2];
			sender = $(sender).find("span")[1];
			sender = $(sender).html();
		
		// confirm that user wants to do this
		var proceed = confirm("Sure you want to delete "+sender+"'s message?");
		if(proceed==true){
			$.post(REL_DIR+"pages/scripts/modifyContactMessageHandler.php", { task:"delete", messageId:messageId }
			).done(function(data){
				data = JSON.parse(data);
				if(data.response == 200){ $(wrap).hide("fast"); }
			});
		}
    });
}

// for the notifier on contact us message
function notification(){
	//var notifierElem = '<span class="notifCount"></span>';
	
	// check if there is unresolved messages
	var msgIco = $("[data-action='contact us']").find(".ico");
	$.post(REL_DIR+"pages/scripts/notifierHandler.php", { task:"contact_message_notifier"}
	).done(function(data){
		var notifierElem = $(msgIco).find("span");
		data = JSON.parse(data);
		if(data.response == 200){
			$(notifierElem).addClass("notifCount");
			$(notifierElem).html(data.value);
		} else { if(data.value==0){ $(notifierElem).removeClass("notifCount")} }
	});

	// check and update the numbers of password recovery requests unattended
	var passRecIco = $("[data-action='password recovery']").find(".ico");
	$.post(REL_DIR+"pages/scripts/notifierHandler.php", { task:"password_recovery_notifier"}
	).done(function(data){
		var notifierElem = $(passRecIco).find("span");
		data = JSON.parse(data);
		if(data.response == 200){
			$(notifierElem).addClass("notifCount");
			$(notifierElem).html(data.value);
		} else { if(data.value==0){ $(notifierElem).removeClass("notifCount")} }
	});
}

// interaction with the content in password reset area
function resetInteraction(){
	// this function is from an external file
	accordion();
	resetActions();
}

// handle the deletion and resolving of password reset section
function resetActions(){
	var container = $(".resetRequests");
	var btns = $(container).find("button");
	
	$(btns).click(function(e) {
		var btnElem = $(e.target);
		var targetUId = $(btnElem).parent().parent().attr("data-targetUId");
		var action = $(btnElem).attr("id");
		var statusElem = $(btnElem).next("span");
		var ico_done = "<img src='images/check.png' />"
		// show progress
		$(statusElem).html(spinner);
		$(btnElem).detach();
		// send the ajax call
		$.post(REL_DIR+"pages/scripts/passResetActionHandler.php",{
			task:"password_recovery_"+action,
			targetUId:targetUId
		}).done(function(data){
			data = JSON.parse(data);
			if(data.response==200){
				var _this = $(statusElem).parent().parent();
				// everything is okay
				$(statusElem).html(statusDone);
				// if user resolved that the mail's been sent, indicate it by checking the icon
				if(data.task=="password_recovery_issent"){
					var indicator = $(_this).find(".head").find(".status").find(".indicator")[0];
					$(indicator).html(ico_done);
				}
				// if user deleted, then hide entry
				if(data.task=="password_recovery_delete"){ $(_this).slideUp(300); }
			} else {
				$(statusElem).html("Error, refresh and try again");
			}
		});
    });
}