// I'm doing this so that user has to be logged in before they view this page
var REL_DIR = getCookie("REL_DIR");
function redirectNonUsers(pageId, pageName){
	var page = $("#"+pageId);
	var data = $(page).attr("data-check");
	if(data){
		var obj = JSON.parse(data);
		if(obj.page && obj.page==pageName){
			if(obj.uId){ }
			else { document.location.href = REL_DIR+"index.php?page=login_signup"; }
		}
	}
}