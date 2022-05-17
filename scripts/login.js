$(document).ready(function() {
    login();
});

var REL_DIR = getCookie("REL_DIR");
function login(){
	var form = $("#login");

	$(form).submit(function(e) {
		e.preventDefault();
		var btn = $(this).find("[name='login']")[0];
		var status = $(this).find(".login-status");
		// this object I'm creating is what I'll be sending through ajax
		var formDataObj = getFormDataAsOject(this);
		
		// while the ajax is processing, show user that they are been logged in
		$(status).html("<img src='"+REL_DIR+"images/loader.gif' /></div>");
		// disable the submit button to avoid resend of request
		btn.disabled=true;
		
		// send the AJAX call
		$.post(REL_DIR+"pages/scripts/user_login.php",
			{
				task: "login",
				form_data: formDataObj
			}
		).done(function(data){
			//console.log(data);
			data = JSON.parse(data);
			if(data.response=="done"){
				$(status).html('<i class="icon-checkmark text_green font_22"></i> logged in');
				// redirect user to the last page they where on after 1sec
				redirect(data.history);
			} else if(data.response==404){
				$(status).html("incorrect email or password");
				// re-enable the submit button so user can retry
				btn.disabled=false;
			} else if(data.response=="error"){
				$(status).html("server error");
				// re-enable the submit button so user can retry
				btn.disabled=false;
			}
		});
    });
}
function redirect(url){
	var delay = 1000;
	setTimeout(function(){ document.location.href = url; }, delay);
}