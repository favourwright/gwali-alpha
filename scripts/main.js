$(document).ready(function(){
	clickAway();
	resizeContainer();
	showPrev();
	test();
});
// hide element on click away
function clickAway(){
	// course options tooltip
	var optBtn = $(".optBtn");
	// fixed navbar button group
	var elementGroup = $(".tooltipGroup").find(".each");
	
	// all elements that needs this function
	var elementsArr = [["header_group_elements",elementGroup]]
	for(i=0;i<elementsArr.length;i++){
		var eachElem = elementsArr[i];
		var elemName = eachElem[0];
		var element = eachElem[1];
		if(elemName=="header_group_elements"){
			$(element).each(function(){
				var each_element = this;
				var ico = $(each_element).find(".ico");
				var tooltip = $(each_element).find(".tooltip");
				var check = tooltip[0];
				if(check){
					$(ico).click(function() { $(tooltip).toggle("fast",
						function(){
							var attr = $(this).attr("data-state")
							if(attr=="closed"){ attr = "open"; }
							else { attr = "closed"; }
							$(this).attr("data-state",attr);
						});
						// handy function. loving this
						event.stopPropagation();
					});
				}
            });
		}
	}
	$(window).click(function(e) {
		var windowElem = e.target;
		var windowElemId = $(windowElem).attr("data-id");
		
		$(elementsArr).each(function(){
			var eachElem = this;
			var elemName = eachElem[0];
			var element = eachElem[1];
			
			// for opt element
			if(elemName=="course_options_element"){
				var option = $(element).next();
				if(windowElem!=option && windowElemId!="unopened"){ $(option).hide(); }
			}
			// for those header buttons including the user login and others
			if(elemName=="header_group_elements"){
				$(element).each(function(){
					var each_element = this;
					var ico = $(each_element).find(".ico");
					var tooltip = $(each_element).find(".tooltip");
					// navigate to that particular DOM element
					var check = tooltip[0];
					if(check){
						var state = $(tooltip).attr("data-state");
						if(windowElem!=check && state!="closed"){ $(tooltip).hide(); $(tooltip).attr("data-state", "closed"); }
					}
				});
			}
		});
    });
}
// ensure that the supported courses container contains all elem
function resizeContainer(){
	var eachCourse = $(".supported").find(".each");
	var size = [];
	for(i=0;i<eachCourse.length;i++){
		var each = eachCourse[i];
		var eachSize = $(each).outerWidth()+6;
		eachSize = eachSize;
		size.push(eachSize);
	}
	var sum = 0;
	for(cc=0;cc<size.length;cc++){
		var last = size.length-1;
		var eachSum = size[cc]
		if(cc==last){eachSum = eachSum;}
		sum = sum + eachSum;
	}
	$(".wrap").css("width", sum+"px");
}
// function for showing the previous posts
function showPrev(){
	var button = $(".showPrev");
	var modal = $(".backDateWrap");
	var closeM = $(modal).find(".close");
	$(button).click(function(e) {
        $(modal).addClass("show");
    });
	$(closeM).click(function(e) {
        $(modal).removeClass("show");
    });
};

function test(){
	var test = $('.recentActivity');
	//$(test).slideUp();
}