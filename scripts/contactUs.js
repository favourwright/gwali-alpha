$(document).ready(function() {
	contact();
});
// cache the avalable buttons
var REL_DIR = getCookie("REL_DIR");
function contact(){
	var page = $("#contactUs");
	var title = $(page).find(".title").find("span")[0];
	var form = $("form");
	var btn = $(form).find("button");
	var status = $("form").find(".status");

	$(form).submit(function(e) {
        e.preventDefault();		
		var spinner = "<div class='loading'><img title='please wait...' src='"+REL_DIR+"images/loader.gif' /></div>";
		var statusDone = 'Sent!';
		$(btn).addClass("wait");
		$(btn).html(spinner);
		var prog = 50;
		plane(prog);
		
		// get the form data from this externally defined function
		var formData = getFormDataAsOject(form);
		$.post(REL_DIR+"pages/scripts/contactUsHandler.php",
			{ task:"contact_us", formData:formData }
		).done(function(data){
			data = JSON.parse(data);
			if(data.response==200){
				prog = 100;
				plane(prog);
				$(btn).removeClass("wait");
				$(btn).html(statusDone);
				$(btn).unbind("click");
				// clear out the form with a message
				setTimeout(function(){
					$(form).html("<span class='thanks flex'>Thanks for your message!</span>");
					$(title).html("Your message is important to us, it's been duely noted");
				}, 1000);
			} else { $(status).html(data.response); }
		});
    });
}

function plane(prog){
	var images = $(".title").find("img");
	if(prog==50){
		// animate the position of the image
		$(images[1]).css("bottom", "150px");
		$(images[1]).css("left", "150px");
	}
	if(prog==100){
		$(images[0]).css("bottom", "-200px");
		$(images[0]).css("right", "210px");
		$(images[2]).css("top", "100px");
		$(images[2]).css("right", "-100px");
		setTimeout(function(){ $(images).each(function() {$(this).hide()}); }, 500);
	}
}