<?php
function splitAtUpperCase($input) {
	$arrayStr = preg_split('/(?=[A-Z])/', $input, -1, PREG_SPLIT_NO_EMPTY);
	$total = count($arrayStr)-1; $output = '';
	//perform a loop so as to add a space after each uppercase
	for($i=0;$i<count($arrayStr);$i++){
		$output .= $arrayStr[$i];
		// make sure not to add space at the end of the string
		if($i!=$total){ $output.=' ';}
	}
	return $output;

}