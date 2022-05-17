$(document).ready(function() {
});

var triggers = $("[data-modal-1-trigger]")
function test(){
	$(triggers).click(function() {
        var clicked = this;
		var btn_name = $(clicked).attr("data-modal-1-trigger");
		console.log(btn_name)
    });
}