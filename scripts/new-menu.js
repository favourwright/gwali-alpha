$(document).ready(function() {
    menu();
});

function menu(){
	var menu_elem = $(".menu");
	var toggler = $(menu_elem).find(".menu-toggler");
	var overlay = $(menu_elem).find(".overlay");
	// handle hamburger button clicks
	openClose(toggler, menu_elem);
	// handle overlay clicks
	openClose(overlay, menu_elem);
}
function openClose(btn, menu_elem){
	// this handles the opening|closing of menu
	$(btn).click(function(e) {
		if(menu_elem.hasClass("active")){
			$(menu_elem).removeClass("active");
		} else { $(menu_elem).addClass("active"); }
    });
}