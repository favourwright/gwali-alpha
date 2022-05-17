$(document).ready(function() {
    logout();
});

var REL_DIR = getCookie("REL_DIR");
function logout(){
	var logoutBtn = $("header").find(".tooltipGroup").find("[name='logout']");
	$(logoutBtn).click(function() {
		// display progress while ajax is in progress
		$(logoutBtn).html("<img title='logging out' src='images/loader.gif' /></div>");
		$(logoutBtn).unbind("click");
		$(logoutBtn).css("cursor", "wait");
		// send the AJAX call
		$.post(REL_DIR+"pages/scripts/logout.php", { task: "logout" }
		).done(function(data){
			data = JSON.parse(data);
			if(data==200){
				// refresh the page
				redirect(document.location.href);
			}
		});
    });
}
function redirect(url){
	var delay = 0;
	setTimeout(function(){ document.location.href = url; }, delay);
}