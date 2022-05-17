function template(inject){
	var html = '';
        html += '<div class="index">'+inject.index+'</div>'; // question number
        html += '    <div class="text">'+inject.question+'</div>';
        html += '<div class="option str_col_12">';
        html += '	<ul>';
        html += '		<li><label><input type="radio" name="answer" value="a">A <span>'+inject.a+'</span></label> </li>';
        html += '		<li><label><input type="radio" name="answer" value="b">B <span>'+inject.b+'</span></label></li>';
        html += '		<li><label><input type="radio" name="answer" value="c">C <span>'+inject.c+'</span></label></li>';
        html += '		<li><label><input type="radio" name="answer" value="d">D <span>'+inject.d+'</span></label></li>';
        html += '	</ul>';
        html += '</div>';
	$("#cbt-form").find(".question").html(html);
}

function CBTHandler(data){
//	var questionId = data.questionId;
	var questions = data.questions;
	var total_count = questions.length;
	
	// display the first question as a default
	var count = 0;
	template(Select(count, questions));
	var next = $(".controls").find("#next");
	$(next).click(function() {
		if(count==total_count){}
		else{count++;}
		template(Select(count, questions));
    });
	var prev = $(".controls").find("#prev");
	$(prev).click(function() {
		if(count==0){count=total_count-1;}
		else{count--;}
		template(Select(count, questions));
    });
}
function Select(i, questions){
	var index = i+1;
	var injection = {
		index:index,
		question:questions[i].question,
		a:questions[i].option[1],
		b:questions[i].option[2],
		c:questions[i].option[3],
		d:questions[i].option[4]
	};
	return injection;
}
function disptime(time_val) {
	x = setInterval(function() {
		// Find the distance between now and the count down date
		var distance = time_val;
		
		// Time calculations for days, hours, minutes and seconds
		var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
		var minutes = Math.floor((distance % (1 * 60 * 60)) / (1 * 60));
		var seconds = Math.floor((distance % (1 * 60)) / 1);
		
		// Output the result in an element with id="demo"
		document.getElementById("demo").innerHTML = "0" + hours + ":" + minutes + ":" + seconds;
		
		// return the new time from the function
		time_val = time_val - 1;
		currenttime = time_val;
		if(time_val < 0){
			clearInterval(x);
			document.getElementById("demo").innerHTML = "EXPIRED";
		}
	}, 1000);
}