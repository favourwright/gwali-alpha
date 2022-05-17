function checkPass(){
	//Store the password field objects into variables ...
	var pass1 = $("#newPass");
	var pass1Val = $(pass1).val();
	var pass2 = $("#confirmPass");
	var pass2Val = $(pass2).val();
	var pass1Check = pass1Val.replace(/ /g, "").length;
	var pass2Check = pass2Val.replace(/ /g, "").length;
	
	if(pass1Check > 0 && pass2Check > 0){
		//Set the colors we will be using ...
		var defaultColor = "#888";
		var goodColor = "#0fd20f";
		var badColor = "#ff6666";
		//Compare the values in the password field 
		//and the confirmation field
		if(pass1Val == pass2Val){
			//The passwords match. 
			//Set the color to the good color and inform
			$(pass2).css("border-bottom", "1px solid "+goodColor);
		} else {
			//The passwords do not match.
			//Set the color to the bad color and
			$(pass2).css("border-bottom", "1px solid "+badColor);
		}
	} else if(pass1Check > 0 && pass2Check <= 0) {
		$(pass2).css("border-bottom", "1px solid "+defaultColor);
	} else {
		$(pass2).css("border-bottom", "1px solid "+defaultColor);
		$(pass1).val("");
		$(pass2).val("");
	}
}