$(document).ready(function() {
	smartHistory();
    historyBack();
});
// function that knows your last history till its needed
function smartHistory(){
	var history = document.referrer;
	var url = document.location.href;
	var site = 'gwali';
	// check if the referring link is our site
	var check = history.indexOf(site)!=-1;
	if(history!=url && check!=false){ setCookie("smart_history", history, 1); }
	
	// proceed with making a back link only if the page user is coming from
	// somewhere in our site
	if(check!=false || url){
		// custom attribute for clickable back button
		var btn = $("[data-smartHistory]");
		$(btn).click(function() {
			// here it is safe to link to previous page
			document.location.href = getCookie("smart_history");
        });
	}
}

function historyBack(){
	// check if the history cookie exist
	var history = getCookie("smart_history");
	var btn = $("[data-history]");
	// perform this function only if the cookie is set
	if(history){ $(btn).click(function(e) { document.location.href = history; }); }
}