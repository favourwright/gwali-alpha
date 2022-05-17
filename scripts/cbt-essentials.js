$(document).ready(function() {
    countDownToView();
});

// function for bringing countdown timer into view on scroll
function countDownToView(){
	var elem = $(".count-time");
	$(window).scroll(function(){
		var offset = window.scrollY;
		if(offset>100){ $(elem).addClass("float"); }
		else { $(elem).removeClass("float"); }
	});
}