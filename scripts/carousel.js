$(document).ready(function() {
	showCarousel();
});

function showCarousel(){
	var each = $(".carousel").find(".each");
	// show the first slide as a default
	$(each[0]).addClass("active");
	animate(each[0]);
	changer();
}

// makes the carousel change
function changer(){
	var each = $(".carousel").find(".each");
	var carousel_len = $(each).length-1;
	
	var delay = 15000;
	var count = 0;
	setInterval(function(){
		// when the carousel has show its last item, start over
		if(count==carousel_len){ count = 0; } else { count++; }
		$(each).removeClass("active");
		var current = each[count];
		
		// the theme colours applied to the landing page
		var theme = ["cadetblue_carousel", "blue_carousel", "pink_carousel", "grey_carousel", "teal_carousel"];
		var target_theme_div = $(current).parent().parent().parent().parent();
		
		// if we're on the first slide, remove the class of the last theme array
		if(count==0){ $(target_theme_div).removeClass(theme[theme.length-1]); }
		else { $(target_theme_div).removeClass(theme[count-1]); }
		$(target_theme_div).addClass(theme[count]);
		
		// used for showing the current carousel
		$(current).addClass("active");
		animate(current);
	}, delay)
}

function animate(elem){
	var elem = elem;
	var img_wrap = $(elem).find(".img");
	var img = $(img_wrap).find("img")[0];
	var text = $(elem).find("h1");
	var btn = $(elem).find("button");
	var target_theme_div = $(elem).parent().parent().parent().parent();
	var init_delay = 15000;
	// this is important for the animation to happen on the image
	setTimeout(function(){
		$(img).css("transform", "translate(0)");
	}, 100);
	
	// this is important for the animation to happen on the the background art
	setTimeout(function(){
		$(target_theme_div).addClass("activate");
	}, 100);
		
	// this is important for the animation to happen on the text
	setTimeout(function(){
		$(text).css("transform", "translate(0)");
	}, 400);
	
	// this is important for the animation to happen on the line under h1
	setTimeout(function(){
		$(elem).find(".line1").css("transform", "translateY(0)");
		// this delay coincides with the time the transition ends
	}, 1000);
	
	// this is important for the animation to happen on the line under h1
	setTimeout(function(){
		$(elem).find(".line2").css("transform", "translateY(0)");
		// this delay coincides with the time the transition ends + 3miliseconds delay after the
		// first underline has slid-in
	}, 1300);
	
	// this is important for the animation to happen on the line under h1
	setTimeout(function(){
		// show any button if available
		if(btn.length){ $(btn).fadeIn(500); }
		// this delay coincides with the time the transition ends + 3miliseconds delay after the
		// second underline has slid-in
	}, 2000);
	
	// function that returns all animated elemets to their start position
	setTimeout(function(){
		// return the image in the outside position of the image
		$(img).css("transform", "translate(100%)");
		// return text outside position of the text(normally)
		$(text).css("transform", "translate(-150%)");
		// return line1 in the outside position of the text
		$(elem).find(".line1").css("transform", "translateY(100px)");
		// return line2 in the outside position of the text
		$(elem).find(".line2").css("transform", "translateY(100px)");
		// for the button
		if(btn.length){ $(btn).hide(); }
	}, init_delay);
	
	// removes the theme color after each slide hs ended
	setTimeout(function(){
		$(target_theme_div).removeClass("activate");
	}, init_delay-300);
}