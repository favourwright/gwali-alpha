// this construct is called in the swipe modal when the modal is active
function swipeModal__construct(){
	Forms();
}

function Forms(){
	var modal = $(".swipe_modal");
	var _form = $(modal).find("form")[0];
	var _input = $(_form).find("input");
	var _select = $(_form).find("select");
	
	$(_input).keyup(function(e) {
		var submit_btn = $(this).parent().find("button");
		if(submit_btn.hasClass("hide")){ $(submit_btn).removeClass("hide"); }
	});
	$(_select).change(function(e) {
		var submit_btn = $(this).parent().find("button");
		if(submit_btn.hasClass("hide")){ $(submit_btn).removeClass("hide"); }
	});
	
	$(_form).submit(function(e) {
		console.log(_form);
		var formData = getFormDataAsOject(_form);
		e.preventDefault();
        console.log(formData);
    });
}