$(document).ready(function() {
	/* ---------------------------------- THIS IS FOR INPUT FIELDS ---------------------------------- */
	// this is done here so that forms without label and span( which are required for this to work are ignored )
	var form = $("form");
	var labels = $(form).find("label");
	var globalArr = [];
	labels.each(function() {
        var spanElem = $(this).find("[data-animated-title]");
		// this means that the conditions were met
		if(spanElem){
			// set some global variable here
			globalArr.push("true");
		}
    });	
	
	var proceed = null
	// search the array of global to make sure that at least on of the span elements were found
	if(globalArr.indexOf("true")!=-1){
		proceed = true;
	};
	
	// if this proceed has been set to true then proceed to apply this function to that form
	if(proceed==true){
		var inputFields = $(labels).find("input");
		
		// this loop is used to add a listener to each of the input fields
		for(i=0;i<inputFields.length;i++){
			// blur is when the user de-focuses
			inputFields[i].addEventListener("blur", blurFunc, false);
			inputFields[i].addEventListener("focus", focusFunc, false);
			
			// this ensures that when the page loads; for all form fields that
			// has contents already, the tags are taken up as default
			var input = inputFields[i];
			var value = $(input).val();
			var label = $(input).parent().find("[data-animated-title]");
			if(value!=""){
				// if this field has something, move the title tag upwards
				label.css("top", "-14px");
				label.css("color", "#036");
				label.css("font-size", "11px");
			}
		};
		
		function blurFunc(e){
			var elem = $(this);
			var content = $(this).val();
			// only make the span(label) come back to its original position
			// if the user hadn't entered any thing in the input field
			if(content==""){
				var label = elem.parent().find("[data-animated-title]");
				label.css("top", "6px");
				label.css("color", "");
				label.css("font-size", "");
			}
		};
		
		function focusFunc(e){
			// when the user focuses on the input field, the prev selector
			// targets the span element and moves it up
			var label = $(this).parent().find("[data-animated-title]");
			label.css("top", "-14px");
			label.css("color", "#036");
			label.css("font-size", "11px");
		};
		
		
		/* ---------------------------------- THIS IS FOR TEXT AREA ---------------------------------- */
		var textarea = $(labels).find("textarea");
		
		// this loop is used to add a listener to each of the input fields
		for(i=0;i<textarea.length;i++){
			// blur is when the user de-focuses
			textarea[i].addEventListener("blur", blurFunc, false);
			textarea[i].addEventListener("focus", focusFunc, false);
			
			// this ensures that when the page loads; for all form fields that
			// has contents already, the tags are taken up as default
			var textareaField = textarea[i];
			var textareaVal = $(textareaField).val();
			if(textareaVal!=""){
				var textareaLabel = $(textareaField).parent().find("[data-animated-title]");
				textareaLabel.css("top", "-14px");
				textareaLabel.css("color", "#036");
				textareaLabel.css("font-size", "11px");
			}
		};
	}
	
});
