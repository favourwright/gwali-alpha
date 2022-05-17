$(document).ready(function() {
    signup();
});

var REL_DIR = getCookie("REL_DIR");
function signup(){
	var form = $("#signup");
	
	$(form).submit(function(e) {
		e.preventDefault();
		var btn = $(this).find("[name='signup']")[0];
		var status = $(this).find(".signup-status");
		// this object I'm creating is what I'll be sending through ajax
		// the function is defined in another js script
		var formDataObj = getFormDataAsOject(this);
		
		// while the ajax is processing, show user that they are been logged in
		$(status).html("<img src='"+REL_DIR+"images/loader.gif' /></div>");
		// disable the submit button to avoid resend of request
		btn.disabled=true;
		
		// send the AJAX call
		$.post(REL_DIR+"pages/scripts/user_signup.php",
			{
				task: "signup",
				form_data: formDataObj
			}
		).done(function(data){
			//console.log(data);
			data = JSON.parse(data);
			if(data.response==200){
				$(status).html('<i class="icon-checkmark text_green font_24"></i> successfully signed up');
				// redirect user to the last page they where on after 1sec
				redirect(data.history);
			} else if(data.response=="data error"){
				// there was error from the user input
				$(status).html("somethings wrong with your input");
				// call the function that points user to where the problem is comming from
				alertFormErrors(form, data.message);
				// re-enable the submit button so they can try again
				btn.disabled=false;
			} else if(data.response==null){
				// the user wasn't added to the database
				// sql or server error
				$(status).html("server error");
				// re-enable the submit button so user can retry
				btn.disabled=false;
			}
		});
    });
	// remove the error linter when user enters new input
	$("input").keyup(function() {
		// check if the element is in this input
		if($(this).parent().find(".inputErr").length>0){
			$(this).parent().find(".inputErr").detach();
		}
	});
}

// function that redirects user to a specified link
function redirect(url){
	var delay = 1000;
	setTimeout(function(){ document.location.href = url; }, delay);
}

// function that lights up areas of form that has errors
function alertFormErrors(form, errors){
	// this is a list of all the elements that I'll be implementing this error display for
	var inputTag = [["firstName", null], ["lastName",null], ["email",null], ["num1",null], ["num2",null], ["regNum",null], ["password",null]]
	// populate the values of fields with errors
	if(errors.firstname){ inputTag[0][1] = errors.firstname; }
	if(errors.lastname){ inputTag[1][1] = errors.lastname; }
	if(errors.email){ inputTag[2][1] = errors.email; }
	if(errors.num1){ inputTag[3][1] = errors.num1; }
	if(errors.num2){ inputTag[4][1] = errors.num2; }
	if(errors.regNum){ inputTag[5][1] = errors.regNum; }
	if(errors.password){ inputTag[6][1] = errors.password; }
	
	// using the parsed-in form, search for all input elements in it
	var inputElem = $(form).find("input");
	$(inputElem).each(function(){
		var _this = this;
		var attr = $(this).attr("name");
		
		// loop over the array I created above and use its values for comparison with the DOM
		$(inputTag).each(function() {
            var tag = this;
			var name = tag[0];
			var val = tag[1];
			if(attr == name){
				if(val!=null){
					// locate the parent then append the linter element if its not already there
					var _parent = $(_this).parent()
					// check if error is alerting for this particular field already
					if($(_parent).find(".inputErr").length>0){
						// change the value as it already exist
						$(_parent).find(".inputErr").find(".info").html(val);
					} else {
						$(_parent).append('<span class="inputErr"><span class="info">'+val+'</span></span>');
					}
					
				// if the value is null and previously, we added a lint: remove
				} else { 
					var _parent = $(_this).parent()
					// check if error is alerting for this particular field already
					if($(_parent).find(".inputErr").length>0){
						// remove the lint element
						$(_parent).find(".inputErr").detach();
					}
				}
			}
        });
    });
}