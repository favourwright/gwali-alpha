<?php
#$page_links->contact_us = "?page=contact_us";
$page_links->contact_us = REL_DIR."contact-us";
#$page_links->about_us = "?page=about_us";
$page_links->about_us = REL_DIR."about-us";
#$page_links->privacy = "?page=privacy_policy";
$page_links->privacy = REL_DIR."privacy";
#$page_links->terms = "?page=terms";
$page_links->terms = REL_DIR."terms";

$hide_footer = NULL;
if(isset($data->get["page"]) && $data->get["page"]=="view_page"){$hide_footer=" style='display:none;'";}
?><footer class="str_col_12"<?php echo $hide_footer; ?>>
	<div class="str_col_12">
    	<div class="main str_col_12">
        	<div class="large_col_8 medium_col_6 mobile_col_12">
            	
            </div>
            
        	<div class="large_col_4 medium_col_6 mobile_col_12">
            	<div class="title"><span>#</span>Our social handles</div>
                <div class="socicons flex flex_wrap">
                	<div class="icon-group">
                    	<div class="icon flex">
                        	<i class="icon-twitter abs_a"><a href="https://twitter.com/gwalinotes" target="_blank"></a></i>
                        	<i class="icon-facebook abs_a"><a href="https://facebook.com/gwalinote" target="_blank"></a></i>
                        	<i class="icon-instagram abs_a"><a href="https://instagram.com/gwalinotes" target="_blank"></a></i>
                            <i class="icon-whatsapp abs_a"><a href="https://chat.whatsapp.com/KZUV3zzffunC5yMPHt7ULp" target="_blank"></a></i>
                        </div>
                        <div class="handle">@gwalinotes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="subLinks str_col_12 italics font_11 unselectable">
        	<a href="<?php echo $page_links->home; ?>" title="Home page">Home</a> &#8226; <a href="<?php echo $page_links->contact_us; ?>" title="Send us a message">Contact us</a> &#8226; <a href="<?php echo $page_links->about_us; ?>" title="About Gwali club?">About us</a> &#8226; <a href="<?php echo $page_links->privacy; ?>" title="Our privacy policy">Privacy policy</a> &#8226; <a href="<?php echo $page_links->terms; ?>" title="Our terms of service">Terms</a>
        </div>
    </div>

    <?php
		$startD = "1";
		$startM = "march";
    	$startY = 2019;
		$currentY = date("Y");
		$currenty = date("y");
		
		# pack an output into a variable
		$copyDate = $startY;
		if($currentY > $startY){
			$copyDate = $startY." - ".$currenty;
		}
	?>
    <div class="copyright"> &copy;<?php echo $copyDate; ?> Gwali&#8482;</div>
</footer>