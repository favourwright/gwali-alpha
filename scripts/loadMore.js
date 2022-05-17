$(document).ready(function() {
	loadMorePost();
});
var REL_DIR = getCookie("REL_DIR");
// cache the avalable buttons
function loadMorePost(){
	// get the cookie having the relative path
	var postWrap = $(".postContainer");
	var container = $(postWrap).find(".posts");
	var btn = $("#loadMore").find("button");
	var spinner = $(btn).find(".loading");
	var text = $(btn).find(".text");
	
	// run the function of getting more posts only when the condition is met
	$(btn).click(function() {
		var used = required();
		$(spinner).show()
		$(text).hide()
		
		$.post(REL_DIR+"pages/scripts/loadMoreHandler.php",
			{ task:"load_more", displayed:used.shown, total_count:used.postCount, filter:used.filter }
		).done(function(data){
			// if the record limit is reached... remove the button
			var data = JSON.parse(data);
			//console.log(data)
			if(data.total <= data.displayed){ $(btn).unbind("click"); $(btn).hide(); }
			$(container).append(data.data);
			$(spinner).hide();
			$(text).show();
		});
	});
}
function required(){
	var postWrap = $(".postContainer");
	var container = $(postWrap).find(".posts");
	var post = $(container).find(".each");
	var displayedPosts = $(post).length;
	var btn = $("#loadMore").find("button");
	var totalPosts = parseInt($(btn).parent().attr("data-records"));
	var filter = $(btn).parent().attr("data-filter");
	var output = {postCount:totalPosts, shown:displayedPosts, filter:filter}
	return output;
}