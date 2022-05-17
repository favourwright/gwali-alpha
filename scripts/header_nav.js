$(document).ready(function() {
    animateList();
});
// function that adds the html element for hover animation of navigation items
function animateList(){
	var li = $("header").find("nav").find(".desktop").find("li");
	var hoverElem = '<span class="hover_anim"></span>';
	$(li).each(function() { $(this).append(hoverElem); });
}