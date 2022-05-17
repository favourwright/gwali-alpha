// accordion handler
function accordion(){
	var accordion = $("[data-accordion]");
	$(accordion).each(function() { initiate(this); });
	
	function initiate(elem){
		var elem = elem;
		var clickable = $(elem).find("[data-acc-toggler]");
		$(clickable).click(function(e) {
            var hiddenContent = $(elem).find("[data-acc-target]");
			if($(hiddenContent).outerHeight()){
				$(hiddenContent).css("max-height", 0);
			} else {$(hiddenContent).css("max-height", $(hiddenContent)[0].scrollHeight+"px"); }
        });
	}
}