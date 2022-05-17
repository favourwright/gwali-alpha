<?php
date_default_timezone_set("Africa/Lagos");
// THIS IS THE REVIEWED SCRIPT; FACEBOOK TYPE
function elaborateDateParser($rawDate){
	$converted = strtotime($rawDate);
	$currentTime = time();
	$timeDiff = $currentTime-$converted;
	$seconds = $timeDiff;
	
	$month = date('M', $converted);
	$day = date('D', $converted);
	$year = date('Y', $converted);
	$time = date('h:ia', $converted);
	
	$minutes = round($seconds / 60); // value 60 is seconds
	$hours = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
	$days = round($seconds / 86400); //86400 = 24 * 60 * 60;
	$weeks = round($seconds / 604800); // 7*24*60*60;
	$months = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
	$years = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
	if ($seconds <= 60){ $display = "Just Now"; }
	elseif ($minutes <= 60){ if ($minutes == 1){ $display = "one minute ago"; } else { $display = "$minutes minutes ago"; } }
	elseif ($hours <= 24){ if ($hours == 1){ $display = "an hour ago"; } else { $display = "$hours hrs ago"; } }
	elseif ($days <= 7){ if ($days == 1){ $display = "yesterday"; } else { $display = "$days days ago"; } }
	elseif ($weeks <= 4.3){ if($weeks == 1){ $display = "a week ago"; } else { $display = "$weeks weeks ago"; } }
	elseif ($months <= 12){ if($months == 1){ $display = "$day, a month ago at $time"; } else { $display = "$day, $months months ago at $time"; } }
	else { if($years == 1){ $display = "a year ago on $month at $time"; } else { $display = "$years years ago on $month at $time"; } }
	
	// return an output
	return ucfirst($display);
}