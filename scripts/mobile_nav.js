$(document).ready(function(){
	menuToggle();
});

function menuToggle(){
	var nav = $("header").find(".mobile_nav");
	var toggler = $("header").find(".menu_toggler");
	
	$(toggler).click(function() {
		var state = $(nav).attr("data-state");
		// hide
		if(state=="open"){ hide(); }
		// show
		else { show(); }
    });
	
	// hide on clickaway
	$(window).click(function(e){
		var state = $(nav).attr("data-state");
		var target = e.target;
		var par_1 = $(target).parent().attr("data-state");
		var par_2 = $(target).parent().parent().attr("data-state");
		var par_a = $(target).parent().attr("id");
		var toggler_a = $(toggler)[0]; toggler_a = $(toggler_a).attr("id");
		
		// using the clicked elemets Id check if the clicked element is inside the menu
		// if true. do nothing
		if(par_1==state || par_2==state || par_a==toggler_a){}
		 // hide
		else{ hide(); }
	});
}
function hide(){
	var nav = $("header").find(".mobile_nav");
	var nav_w = $(nav).innerWidth();
	$(nav).css("left", "-"+(nav_w+4)+"px");
	$(nav).attr("data-state", "closed")
	$(nav).css("visibility", "hidden");
}
function show(){
	var nav = $("header").find(".mobile_nav");
	$(nav).css("left", 0);
	$(nav).attr("data-state", "open")
	$(nav).css("visibility", "visible");
}