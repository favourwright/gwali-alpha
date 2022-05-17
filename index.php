<?php
	# this should dynamically add the gwali root folder on only localhost
	$lh_dir = NULL;
	if($_SERVER['SERVER_NAME']=="localhost"){ $lh_dir="gwali/"; }
	$rsc = $_SERVER["REQUEST_SCHEME"]; // http, https, ftp...
	$prot = "$rsc://"; // server protocol used
	$sern = $_SERVER['SERVER_NAME']; // server name
	
	include $_SERVER['DOCUMENT_ROOT']."/{$lh_dir}pages/includes/defines.php";
	date_default_timezone_set("Africa/Lagos");
	session_start();
	ob_start();
	
	// This is where the database connection string is
	// included for the whole page
	// import the essentials class
	include MODELS_DIR ."db_connection.php";
	include MODELS_DIR ."records.php";
	include MODELS_DIR ."student.php";
	include MODELS_DIR ."seo.php";
	$records = new Records;
	$student = new Student;
	$seo = new Seo;
	# get info about current user
	$userIdentity = $student->studentIdentifier();
	
	# the get var and server var
	$meta = $seo->meta($_GET, $_SERVER);

	# the class that has all school faculties, departments and study duration
	$schoolsAndItsData = $student->schoolsAndItsData();
    $parseForJs = json_encode($schoolsAndItsData);
//	echo "<pre>";
//	print_r($schoolsAndItsData);
//	echo "</pre>";
?><!doctype html>
<html>
<head>
<!--NORMAL SEO-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo $meta->description; ?>" />
<meta name="keywords" content="<?php echo $meta->keyword; ?>" />
<!--<meta name="theme-color" content="#444444" />-->
<!--FACEBOOK SEO-->
<meta property="og:url" content="<?php echo $meta->uri; ?>">
<meta property="og:image" content="<?php echo $meta->share_me_img; ?>">
<meta property="og:description" content="<?php echo $meta->description; ?>">
<meta property="og:title" content="<?php echo $meta->page_title; ?>">
<meta property="og:site_name" content="<?php echo $meta->site_name; ?>">
<meta property="og:see_also" content="<?php echo $meta->site_home_link; ?>">
<!--TWITTER SEO-->
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php echo $meta->uri; ?>">
<meta name="twitter:title" content="<?php echo $meta->page_title; ?>">
<meta name="twitter:description" content="<?php echo $meta->description; ?>">
<meta name="twitter:image" content="<?php echo $meta->share_me_img; ?>">
<!--OTHERS-->
<link href="<?php echo REL_DIR; ?>css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="<?php echo REL_DIR; ?>css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo REL_DIR; ?>icon/style.css" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo $meta->favicon; ?>" type="image/.png" />
<script src="<?php echo REL_DIR; ?>scripts/jquery-3.2.1.min.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/main.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/formHomekeeping.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/cookies.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/carousel.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/detectDevice.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/header_nav.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/mobile_nav.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/redirectToLogin.js" type="text/jscript"></script>
<title><?php echo $meta->page_title; ?></title>
</head>
<body>
<div id="siteWrap" class="str_col_12">
<div class="device_detect"> <span class="mobile">mobile</span> <span class="tablet">tablet</span> <span class="desktop">desktop</span> </div>
<script> detect(); </script>
<script> //console.log(<?php //echo $parseForJs; ?>) </script>
    <?php include INCLUDES."header.php"; ?>
    <div id="matchHeader"></div>

    <div class="str_col_12" id="pageContent" data-swipe-modal-env>
        <div class="recentActivity" style="display:none">CHEM 121 assignment added 2minutes ago</div>
        <!--PHP DYNAMIC PAGE FETCHING STARTS HERE-->
        <?php
        if(isset($_GET['page']) && $_GET['page']!=""){ $get = $_GET['page']; };
        if(!isset($get)){ // HOME CONTENT BELOW ?>
        <div class="landingWrap">
            <div class="landing unselectable str_col_12">
            	<div class="carousel">
                	<div class="each">
                    	<div class="img"><img src="images/busy_bee.png" /> <i class="abs"></i></div>
                        <div class="content flex">
                        	<h1 class="flex">Missed out on last class... we, gat, you <span class="line1"></span><span class="line2"></span></h1>
                        </div>
                    </div>
                	<div class="each">
                    	<div class="img"><img src="images/8c53f229042467.png" /> <i class="abs"></i></div>
                        <div class="content flex">
                        	<h1 class="flex">Study smarter with your note problem solved <span class="line1"></span><span class="line2"></span></h1>
                        </div>
                    </div>
                	<div class="each">
                    	<div class="img"><img src="images/girl_n_gadget_artwork_2.png" /> <i class="abs"></i></div>
                        <div class="content flex">
                        	<h1 class="flex">School can be made a little less stressful <span class="line1"></span><span class="line2"></span></h1>
                        </div>
                    </div>
                	<div class="each">
                    	<div class="img"><img src="images/02.png" /> <i class="abs"></i></div>
                        <div class="content flex">
                        	<h1 class="flex">Assisting students is the heart of our operation <span class="line1"></span><span class="line2"></span></h1>
                        </div>
                    </div>
                	<div class="each">
                    	<div class="img"><img src="images/galshir-genesis.png" /> <i class="abs"></i></div>
                        <div class="content flex">
                        	<h1 class="flex">Have you been writing excellent lecture notes? <span class="line1"></span><span class="line2"></span></h1>
                            <button class="abs_a">Become our writer <a href="become-our-writer"></a></button>
                        </div>
                    </div>
                    
                    <div class="seeker"></div>
                </div>
            </div>
            
            <div class="pageContent str_col_12">
                <div class="supported str_col_12">
                	<div class="wrap">
                        <?php
							$rs = $records->getCourseCodes();
							$count = count($rs->ccOriginalArr)-1;
							$_courseCodes = $rs->ccOriginalArr;
							$courseCodes = $rs->ccChangedArr;

							for($i=0;$i<$count;$i++){
								# the only reason I use break here is because of the manipulation I did which
								# creates an extra array elememt that is empty
								#NOTE: courseCodes varaible is declared in header
								$link = str_replace(" ", "_", $courseCodes[$i]);
								if($i==$count){ break; }
								echo "<div class='each'><div class='course'>{$courseCodes[$i]} <a href='?filter_course={$link}'></a></div></div>";
							}
						?>
                    </div>
                </div>
                <script>resizeContainer();</script>

                <div class="postWrap str_col_12">
                    <div class="nowShowing str_col_12">
                        <?php
                        $filter = NULL;
                        # independent check to know if the selected filter (course)
                        # has an entry on the database
                        $showing_tag = 'Showing <span>all courses</span>';
                        if(isset($_GET['filter_course'])&&$_GET['filter_course']!=""){
                            $filter = $_GET['filter_course'];
                            $cId=$records->getCourseId($filter);
                            if($cId){
                                if($records->getRecord("entry", "courseId", $cId)){
                                    $showing_tag = "Showing <span>".str_replace("_", " ", $_GET['filter_course'])."</span>";
                                } else { $showing_tag = "<span>".str_replace("_", " ", $_GET['filter_course'])."</span> not found"; }
                            } else { $showing_tag = "<span>".str_replace("_", " ", $_GET['filter_course'])."</span> not found"; }
                        }
                        ?>
                        <div class="showing"><?php echo $showing_tag; ?></div>
                        <button class="showPrev no_outline">All in a glance</button>
                        <div class="backDateWrap">
                            <div class="backDateContainer">
                                <div class="backDate">
                                    <?php if($prevEntries = $records->seePrevious($filter)){ foreach($prevEntries as $prevEntry){ print_r($prevEntry); } } ?>
                                </div>
                            </div>
                            <div class="close"></div>
                        </div>
                    </div>
                    <div class="postContainer str_col_12">
                        <div class="posts str_col_12">
                        <?php
                        $entries = $records->getHomeRecords($filter);
                        if($entries->entries){ foreach($entries->entries as $entry){ echo $entry; } } else { echo "<span class='noPosts flex'>There are no posts yet</span>"; }
                        ?>
                        </div>
                        <?php
                        # display the button on page load only if the displayed record is less than the total records
                        if($entries->postCount > count($entries->entries)){ ?><div data-records="<?php echo $entries->postCount; ?>" data-filter="<?php echo $filter; ?>" id="loadMore" class="flex">
                        	<button class="flex">
                            	<div class='loading'><img title='please wait...' src='<?php echo REL_DIR; ?>images/loader.gif' /></div>
                                <div class="text">Load More</div>
                        	</button>
						</div><?php } ?>
                        <script src="<?php echo REL_DIR; ?>scripts/loadMore.js" type="text/jscript"></script>
                    </div>
                    
                    <div class="hide_small"></div>
                </div>
            </div>
        </div>
        <?php
            } elseif(isset($get) && $get!="") {
                // when the user has clicked on the navigation links, get the address from the address-bar
                // then include it
                $page = $_GET['page'];
                if(!include("pages/$page.php")){
                    // if the GET from the address isn't on the website, give an error
                    echo '<h1 class="sleek_text text_center padding_xlarge">hey, I guess you have a <em>typo</em> in your address or the page you were looking for doesn\'t exist anymore</h1>';
                }
                ob_end_flush();
            
            } else {
                // catch any-other error involved in the editing of the address bar
                echo "<h1 class=\"sleek_text text_center padding_xxlarge\">Ooops we didn't quite get that :( </h1>";
            }
        ?>    
        <!--PHP DYNAMIC PAGE FETCHING ENDS HERE-->
        <script>
        // my attempt for a better content filling
        // it actually works
        initiateAutoHeight();
        </script>
        <aside class="mainSideBar hide_small hide_medium"></aside>
        <div class="cookieAlert">
            <div class="str_col_12">
                <div class="str_col_12">
                    Hey Gwalian, the Gwali team in an effort to provide the best services and functions through this app to you stores <a href="<?php echo REL_DIR; ?>?page=privacy_policy#usageData" title="what are cookies?" target="_blank">cookies</a> on your device to give you optimum functionalities like commenting on our posts without proper signup and more. Identification through this means is un-reliable, so if you want your activities identified on this app, please <a href="<?php echo REL_DIR; ?>?page=login_signup#newMembers" title="sign up">signup</a> or <a href="<?php echo REL_DIR; ?>?page=login_signup" title="login">login</a>.
                </div>
                <button>accept and continue</button>
            </div>
        </div>
    </div>
    <?php include INCLUDES."footer.php"; ?>
</div>
<script src="<?php echo REL_DIR; ?>scripts/backHistory.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/logout.js" type="text/jscript"></script>
<script src="<?php echo REL_DIR; ?>scripts/formDataAsObject.js" type="text/jscript"></script>
</body>
</html>