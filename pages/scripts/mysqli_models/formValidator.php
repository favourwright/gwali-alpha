<?php
class FormValidate extends DB_con {
	public $whiteSpaceErr = "only letters and white space allowed";
	public $emptyErr = "this field cannot be empty";
	public $emailErr = "invalid email format";
	public $err = "error";	

	# this validates name and if there is and displays errors accordingly
	public function name($input){
		$dirtyName = $input;
		$output = new stdClass();
		$output->message = NULL;
		$output->data = NULL;
		if(spaceCheck($dirtyName)!=""){
			if(!preg_match("/^[a-zA-Z ]*$/", $dirtyName)){
				# return an error message
				$output->message = $this->whiteSpaceErr;
			} else { $output->data = $dirtyName; }
		} else { $output->message = $this->emptyErr; }
		return $output;
	}
	
	# this validates emails
	public function email($input){
		$dirtyMail = $input;
		$output = new stdClass();
		$output->message = NULL;
		$output->data = NULL;
		$email = strtolower(mysqli_real_escape_string($dbconnect, $dirtyMail));
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			# return an error message
		  $output->message = $this->emailErr;
		} else { $output->data = $email; }
		return $output;
	}
		
	# this validates reg. number
	public function regNum($input){
		
	}
}