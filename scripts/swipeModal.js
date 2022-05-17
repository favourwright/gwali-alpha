$(document).ready(function() { swipeModal() });

// env == environment; refers to the literal meaning of the word
// I added the "data-" attribute in the index page so that env is readily available when needed
var env = $("[data-swipe-modal-env]");
function swipeElem(content){
	var html = '<div class="swipe_modal_wrap">';
		html +=		'<div class="swipe_modal no_outline">';
		html +=			'<div class="artDivide"><div class="line"></div></div>';
		html +=			'<!--INSIDE CONTENT_WRAP IS WHERE ITS CONTENT WOULD DYNAMICALLY BE ADDED-->';
		html +=			'<div class="content_wrap str_col_12">'+content+'</div>';
		html +=		'</div>';
		html +=		'<div class="overlay"></div>';
		html +='</div>';
	
	// I used a callback function here so that I'd be able to apply
	// my custom animation on the modal once its appended
	$(env).append(function(){
		// without this, the animation won't work
		// and I set the delay as small as possible so that it works as tho
		// the setTimeout function wasn't applied
		setTimeout(function(){ showSwipeModal(); }, 100);
	}, html);

	hideSwipeModal();
	
	/////// THE CONSTRUCTS WHERE FUNCTIONS OF THE INSERTED ELEMENT GOES  /////////
	swipeModal__construct()
}
function swipeModal(){
	var trigger = $("[data-swipe-trigger]");
	
	$(trigger).click(function(e) {
		var triggered = this;
        var id = $(triggered).attr("data-swipe-trigger");
		// with the above id, find the related div and insert it into the modal
		var relContent = $("[data-swipe-content='"+id+"']")[0].outerHTML;
		// finally call the function that has the html element
		swipeElem(relContent);
    });
}

function showSwipeModal(){
	var modal = $(".swipe_modal");
	$(modal).addClass("show");
}
function hideSwipeModal(){
	var overlay = $(".overlay");
	var modal = $(".swipe_modal");
	$(overlay).click(function() {
		$(modal).removeClass("show");
		// I wait 2 mili-second because it currelates to the css on "swipe_modal"
		// then detach the modal
		setTimeout(function(){ $(".swipe_modal_wrap").detach(); }, 200);
	});
}