<?php
	// This is where the database connection string is
	// included for the whole page
	include $_SERVER['DOCUMENT_ROOT'].'/pages/includes/defines.php';
	session_start();
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="I'm sure you don't have the right to be here, access denied" />
<meta name="keywords" content="page error, page access error, unauthorized access, access error, dir access error, access denied" />
<meta property="og:title" content=".DIR Access Error" />
<meta property="og:description" content="I'm sure you don't have the right to be here" />
<meta property="og:image" content="http:/.com/images/logo.png" />
<meta property="og:site_name" content="BorrowEye" />
<link href="../../../../css/main.css" rel="stylesheet" type="text/css">
<link href="../../../../icon/style.css" rel="stylesheet">
<link href="../../../../css/boilerplate.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../../../../images/favicon.png" type="image/png" />
<title>.DIR Access Error</title>
</head>

<body>
<div id="site_wrap" class="site_wrap str_col_12">
	<script src="../../../../scripts/forcedHeight.js"></script>
	<?php include INCLUDES."header.php"; ?>
    <div class="str_col_12" id="gapMatch"></div>

	<div id="global_content" class="str_col_12">
        <div class="str_col_12 padding_large">
        	<!--THE DIR ACCESS ERROR GOES HERE-->
            <div id="accessError">
            	<div class="str_col_12">
                    <i class="icon-shield"></i>
                    Ooops... I'm not sure you have the right to be here
                    <br /><span class="text_grey">Access>> denied</span>
                </div>
            </div>
        </div>

        <?php include INCLUDES.'aSide.php'; ?>
    </div>


	<?php include INCLUDES.'footer.php'; ?>
</div>

</body>
</html>