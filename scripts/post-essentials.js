$(document).ready(function() {
   growPostContainer();
});
$(window).resize(function() {
    growPostContainer();
});

function growPostContainer(){
	var postContainer = $(".post-container");
	var posts = $(postContainer).find(".each");
	$(posts).each(function() {
        var current = this;
		var targetDiv = $(current).find(".wrap")[0];
		console.log(targetDiv)
		// -70; because that is the padding-right value
		var width = (targetDiv.clientWidth)-70;
		$(targetDiv).css("min-height", width+"px");
    });
}