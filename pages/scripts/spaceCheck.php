<?php
// I'm using this function to make sure that the user doesn't just
// insert space in the form
function spaceCheck($input){
	if(strstr($input, " ")==true){
		$output = str_replace(" ", "", $input);
	} else {
		$output = $input;
	}
	return $output;
}