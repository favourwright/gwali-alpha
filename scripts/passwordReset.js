$(document).ready(function() {
    recover();
});

var REL_DIR = getCookie("REL_DIR");
function recover(){
	var form = $("form");
	var btn = $(form).find("button")[0];
	var status = $(form).find(".status");
	var infoBox = $(form).find(".info");
	
	$(form).submit(function(e) {
        e.preventDefault();
		var emailField = $(form).find("[name='email']");
		var email = $(emailField).val();
		// because I removed the required attribute on the input element.
		// I need to check that the input field has something before proceeding
		if(email!=""){
			// progress display
			$(status).html("<img src='"+REL_DIR+"images/loader.gif' /></div>");
			// remove the submit button from view
			$(btn).hide("fast");
			$(form).find(emailField).keyup(function(e){ $(infoBox).hide(); });
			
			$.post(REL_DIR+"pages/scripts/passwordResetHandler.php", {task:"reset_password", email:email}
			).done(function(data){
				$(infoBox).show();
				$(status).html("");
				data = JSON.parse(data);
				if(data.response==200){
					var info = '<strong class="text_green font_16">Success!</strong><br /> <strong>Note that:</strong> Due to some logistical issues, this process is manually handled and may take up to 24 hours before a password reset link is sent to your mail (<strong class="italics">'+data.email+'</strong>). Our sincere apologies';
					// clear out the email field
					$(emailField).val("");
					$(infoBox).html(info);
				}
				if(data.response=="error"){
					// bring back the button
					$(btn).show("fast");
					// display the appropriate messages
					if(data.message.insert){ $(infoBox).html(data.message.insert); }
					if(data.message.duplicate){ $(infoBox).html(data.message.duplicate); }
					if(data.message.email){ $(infoBox).html(data.message.email); }
				}
			});
		}
    });
}