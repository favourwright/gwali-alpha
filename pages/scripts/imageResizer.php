<?php
function imgResizeScript($target, $resized, $width, $height, $extension){
	list($orig_width, $orig_height) = getimagesize($target);
	$scale_ratio = $orig_width / $orig_height;
	
	if(($width / $height) > $scale_ratio){
		$width = $height * $scale_ratio;
	} else {
		$height = $width / $scale_ratio;
	}
	
	$img = "";
	if($extension == "png" || $extension == "PNG"){
		$img = imagecreatefrompng($target);
	} elseif($extension == "gif" || $extension == "GIF"){
		$img = imagecreatefromgif($target);
	} else {
		$img = imagecreatefromjpeg($target);
	}
	
	$true_color = imagecreatetruecolor($width, $height);
	imagecopyresampled($true_color, $img, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
	imagejpeg($true_color, $resized, 80);
}