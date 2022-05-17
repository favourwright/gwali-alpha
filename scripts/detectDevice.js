$(document).ready(function() { autoWindowHeight(); detect(); });
$(window).resize(function() {
    detect();
});
function result(device, width, height){
	var details = {device:device, width:width, height:height}	
	return details;
}
function detect(){
	var element = $(".device_detect")
	var deviceName = element[0].innerText;
	//console.log(element)
	
	var send = {device:deviceName}
	result(send);
}

function autoWindowHeight() {
	// this function was created in an effort to always make my footer reach the
	// bottom of the screen
	// i.e, when the content of the page is so little.
	var site_wrap = $("#pageContent");
	var wrapHeight = $(site_wrap).outerHeight();
	var header = $("header");
	var headerHeight = $(header).outerHeight()+1;//this +1 is for the border under the header
	var footer = $("footer");
	var footerHeight = $(footer).innerHeight()+1;
	var windowHeight = $(window).outerHeight();
	var forcedHeight = windowHeight-(headerHeight+footerHeight);
	
	var send = {height:forcedHeight}
	result(send);
		
	// only change the height to fit window if the content is not enough to fill it
	if(wrapHeight < windowHeight) {
		// I need to minus the height of the header
		$(site_wrap).css("min-height", forcedHeight+"px");
	}
	
	// also always update a cookie that I'll consume to prevent the charpy resizing occuring
	// with document.ready function
	var existingHeightCookie = null;
	var existingHeightCookie = getCookie("smart_height");
	if(existingHeightCookie){
		var send = {height:existingHeightCookie}
		result(send);
		// check if its value is same as the live height
		if(existingHeightCookie!=forcedHeight){
			setCookie("smart_height", forcedHeight, 1);
		}
	} else { setCookie("smart_height", forcedHeight, 1); }
	
	//console.log(result())
}

// the function that actually initiates the whole function
function initiateAutoHeight(){
	var height = getCookie("smart_height");
	if(height){
		site_wrap = $("#pageContent");
		$(site_wrap).css("min-height", height+"px");
	}
}