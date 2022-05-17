$(document).ready(function() {
    setTimeout(function(){ putView(); }, 1000);
});

var REL_DIR = getCookie("REL_DIR");
function putView(){
	var essential = JSON.parse($(".comments").attr("data-essentials"));
	$.post(REL_DIR+"pages/scripts/viewHandler.php",
		{
			task:"new_view",
			essential:essential
		}
	// basically I dont need this callback function. still am keeping it empty
	).done(function(data){ /*console.log(data);*/ });
}