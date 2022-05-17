<?php
date_default_timezone_set("Africa/Lagos");
session_start();
ob_start();
$theme = "light";
if($theme=="dark"){$theme_hex = "#31353e";}else{$theme_hex = "#fff";}
include "../pages/includes/defines.php";
// This is where the database connection string is
// included for the whole page
// import the essentials class
include MODELS_DIR ."db_connection.php";
include MODELS_DIR ."records.php";
include MODELS_DIR ."cbt.php";
$cbt = new CBT;
$question_json = $cbt->parsedQuestion(5615545);
//echo "<pre>";
//print_r(json_decode($question_json));
//echo "</pre>";
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="<?php echo $theme_hex; ?>">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="<?php echo $theme_hex; ?>">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $theme_hex; ?>">
<link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="../css/new.css" rel="stylesheet" type="text/css">
<script src="../scripts/jquery-3.2.1.min.js" type="text/jscript"></script>
<script src="../scripts/new-menu.js" type="text/jscript"></script>
<script src="../scripts/post-essentials.js" type="text/jscript"></script>
<script src="../scripts/handleCBT.js" type="text/jscript"></script>
<title>Home</title>
</head>
<body class="<?php echo $theme; ?>">
<div class="page-ex-wrap str_col_12">
<?php include INCLUDES."header.new.php"; ?>
<?php include INCLUDES."nav.php"; ?>
<div class="page-content-wrap str_col_12">
    <?php include INCLUDES."aside.php"; ?>
    <div class="page-int-wrap str_col_12">
    <!--I'm inside-->
    <?php
    if(isset($_GET['page']) && $_GET['page']!=""){ $get = $_GET['page']; }
	if(!isset($get)){ include PAGES."home.php"; /* HOMEPAGE CONTENT */ }
	elseif(isset($get) && $get!=""){
		# when the user has clicked on the navigation links, get the address from the address-bar
		# then include it
		$page = $_GET['page'];
		if(!include PAGES."$page.php"){
			# if the GET from the address isn't on the website, give an error
			echo '<h1 class="sleek_text text_center padding_xlarge">hey, I guess you have a <em>typo</em> in your address or the page you were looking for doesn\'t exist anymore</h1>';
		}
		# stop the output buffer
		ob_end_flush();
	} else {
		# catch any-other error involved in the editing of the address bar
		echo '<h1 class="sleek_text text_center padding_xxlarge">Ooops we didn\'t quite get that :( </h1>';
	} ?>    
    </div>
</div>
<footer><!--I'm the footer--></footer>
</div>
</body>
</html>