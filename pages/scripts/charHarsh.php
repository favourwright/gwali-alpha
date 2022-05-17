<?php
// this is my function I built to replace some characters that would break my script
function stripChars($char){
	// check if name only contains "'"
	if(strstr($char, "'")==true) {
		$stage1 = str_replace("'", "&#8217;", $char);
	} else {
		$stage1 = $char;
	}
	
	// check if name only contains """
	if(strstr($stage1, '"')==true) {
		$stage2 = str_replace('"', "&#8220;", $stage1);
	} else {
		$stage2 = $stage1;
	}
	
	// check if name only contains "‘"
	if(strstr($stage2, '‘')==true) {
		$stage3 = str_replace('‘', "&#8216;", $stage2);
	} else {
		$stage3 = $stage2;
	}
	
	// check if name only contains "’"
	if(strstr($stage3, '’')==true) {
		$stage4 = str_replace('’', "&#8217;", $stage3);
	} else {
		$stage4 = $stage3;
	}
	
	// check if name only contains "“"
	if(strstr($stage4, '“')==true) {
		$stage5 = str_replace('“', "&#8220;", $stage4);
	} else {
		$stage5 = $stage4;
	}
	
	// check if name only contains "”"
	if(strstr($stage5, '”')==true) {
		$stage6 = str_replace('”', "&#8221;", $stage5);
	} else {
		$stage6 = $stage5;
	}
	
	// check if name only contains "„"
	if(strstr($stage6, '„')==true) {
		$stage7 = str_replace('„', "&#8222;", $stage6);
	} else {
		$stage7 = $stage6;
	}
	
	// check if name only contains "‥"
	if(strstr($stage7, '‥')==true) {
		$stage8 = str_replace('‥', "&#8229;", $stage7);
	} else {
		$stage8 = $stage7;
	}
	
	// check if name only contains "…"
	if(strstr($stage8, '…')==true) {
		$stage9 = str_replace('…', "&#8230;", $stage8);
	} else {
		$stage9 = $stage8;
	}
	
	// check if name only contains "′"
	if(strstr($stage9, '′')==true) {
		$stage10 = str_replace('′', "&#8242;", $stage9);
	} else {
		$stage10 = $stage9;
	}
	
	// check if name only contains "″"
	if(strstr($stage10, '″')==true) {
		$stage11 = str_replace('″', "&#8243;", $stage10);
	} else {
		$stage11 = $stage10;
	}
	
	// check if name only contains "‵"
	if(strstr($stage11, '‵')==true) {
		$stage12 = str_replace('‵', "&#8245;", $stage11);
	} else {
		$stage12 = $stage11;
	}

	// check if name only contains "⇢"
	if(strstr($stage12, '⇢')==true) {
		$stage13 = str_replace('⇢', "&#8674;", $stage12);
	} else {
		$stage13 = $stage12;
	}

	// check if name only contains "<"
	if(strstr($stage13, '<')==true) {
		$stage14 = str_replace('<', "&lt;", $stage13);
	} else {
		$stage14 = $stage13;
	}

	// check if name only contains ">"
	if(strstr($stage14, '>')==true) {
		$stage15 = str_replace('>', "&gt;", $stage14);
	} else {
		$stage15 = $stage14;
	}

	// check if name only contains "}"
	if(strstr($stage15, '}')==true) {
		$stage16 = str_replace('}', "&#125;", $stage15);
	} else {
		$stage16 = $stage15;
	}

	// check if name only contains "{"
	if(strstr($stage16, '{')==true) {
		$stage17 = str_replace('{', "&#123;", $stage16);
	} else {
		$stage17 = $stage16;
	}

	return $stage17;
}