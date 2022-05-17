$(document).ready(function() {
	formHomekeeping();
});

function formHomekeeping(){
		// get all forms present in a page
		var forms = $("form");
		forms.each(function() {
			var form = this;
			// when a user defocuses on any input field check if it has something else clear it
			var all_input = $(form).find("input");
			all_input.each(function(e) {
				$(this).blur(function() {
					var field = this;
					var val = $(this).val().replace(/ /g, '');
					if(val==""){ $(field).val(""); }
				});
			});
			
			// when a user defocuses on any text area field check if it has something else clear it
			var all_textarea = $(form).find("textarea");
			all_textarea.each(function(e) {
				$(this).blur(function() {
					var field = this;
					var val = $(this).val().replace(/ /g, '');
					if(val==""){ $(field).val(""); }
				});
			});
			
		});	
	}
