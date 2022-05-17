<?php
# do all the necessary things needed to be done
# making it ready to be parsed to JS
class CBT extends Records {
	# get all the questions
	public function getQuestion($questionId){
		# explicitly cast this variable to always be an integer
		$questionId = (int)$questionId;
		$questions = NULL;
		$sql = "SELECT * FROM cbt WHERE questionId={$questionId}";
		$query = mysqli_query($this->dbconnect(), $sql);
		if($rs = mysqli_fetch_object($query)){
			$questions = $rs;
		}
		# return a value
		return $questions;
	}
	
	# parse all the essential data needed by the JS
	public function parsedQuestion($questionId){
		$questionId = (int)$questionId;
		$output = new stdClass();
		# import the questions
		$rs = $this->getQuestion($questionId);
		$questions = json_decode($rs->questions);
		
		$refactored = array();
		# loop over the questions to eliminate the answer variables
		foreach($questions as $question){
			$each = new stdClass();
			$each->question = $question->question;
			$each->option = $question->option;
			array_push($refactored, $each);
		}
		
		$output->questionId = $questionId;
		$output->courseId = $rs->courseId;
		$output->qpe = $rs->qpe; # questions per exam
		$output->duration = $rs->duration;
		
		# at this point, use the qpe value to limit number of questions
		# try preventing repeat of previously answered questions
		$total_questions = count($refactored)-1;
		$selectedCBQ = array();
		for($i=0;$i<$output->qpe;$i++){
			$select = rand(0, $total_questions);
			# later, I'll check if the selection here is among previously
			# seen questions
			array_push($selectedCBQ, $refactored[$select]);
		}
		
		$output->questions = $selectedCBQ;
		return json_encode($output);
	}
	
	public function customSet($range){
		#$range; a 2 element array that defines min and max numberss
		$set = range($range[0], $range[1]);
		shuffle($set);
		return $set;
	}
	
	public function getDuration($questionId){
		$rs = $this->getQuestion($questionId);
		$duration = $rs->duration;
		sscanf($duration, "%d:%d:%d", $hours, $minutes, $seconds);
		return (isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds);
	}
}