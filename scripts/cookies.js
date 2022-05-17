$(document).ready(function() {
	checkCookie();
	// wait 5secs after page fully loads before showing the alert
    setTimeout(function(){ cookieAlert(); }, 5000);
});

function cookieAlert(){
	var dimension = detectDeviceDimension();
	var cookieBox = $(".cookieAlert");
	var acceptBtn = $(cookieBox).find("button");
	var check = getCookie("gwali_identity_cookie");
	var check = JSON.parse(check);
	
	if(check.acknowledged==null){
		$(cookieBox).css("width", (dimension.width)+"px");
		$(cookieBox).fadeIn(500);
		
		$(acceptBtn).click(function() {
			// remove the cookie box
			$(cookieBox).fadeOut(500);
			// change cookie value to acknowledged
			cookie = '{"user_cookieId":"'+check.user_cookieId+'", "acknowledged":'+true+'}';
			setCookie("gwali_identity_cookie", cookie, (7*4));
		});
	}
}
// detect the device width and height
function detectDeviceDimension(){
	var windowH = $(this).innerHeight();
	var windowW = $(this).innerWidth();
	
	var dimension = {width:windowW, height:windowH}
	return dimension;
}

function setCookie(cName, cValue, exDays){
	var d = new Date();
	d.setTime(d.getTime()+(exDays * 24*60*60*1000));
	var expires = "expires ="+d.toUTCString();
	document.cookie = cName+"="+cValue+";"+expires+"; path=/";
}

function getCookie(cName){
	var cookieValue = '';
	var name = cName +"=";
	var cookieArr = document.cookie.split(';');
	for(var i=0;i<cookieArr.length;i++){
		var eachCookie = cookieArr[i];
		
		while(eachCookie.charAt(0)==' '){
			eachCookie = eachCookie.substring(1);
		}
		if(eachCookie.indexOf(name)==0){
			cookieValue = eachCookie.substring(name.length, eachCookie.length);
		}
	}
	return cookieValue;
}
// function that checks if a particular cookie exists else set the cookie
function checkCookie(){
	// I bet this "username is the name of the cookie"
	var cookie = getCookie("gwali_identity_cookie");
	if(cookie==""){
		// generate a "unique" id from 100000 - 1000000
		var user_cookieId = ((Math.random()*100000000)+1000000);
		// set acknowledged to null untill the user accepts the cookies then
		// we stop alerting the user of the policy
		cookie = '{"user_cookieId":"'+user_cookieId+'", "acknowledged":'+null+'}';
		// expires after six months (7days*4==1month)
		setCookie("gwali_identity_cookie", cookie, (7*4));
	}
}