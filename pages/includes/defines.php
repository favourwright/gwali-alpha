<?php
$lh_dir = NULL;
if($_SERVER['SERVER_NAME']=="localhost"){ $lh_dir="gwali/"; }
$rsc = $_SERVER["REQUEST_SCHEME"]; // http, https, ftp...
$prot = "$rsc://"; // server protocol used
$sern = $_SERVER['SERVER_NAME']; // server name

define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']."/{$lh_dir}");
define('DS', DIRECTORY_SEPARATOR);
define('PAGES', DOC_ROOT . 'pages'.DS);
define('INCLUDES', DOC_ROOT . 'pages'.DS.'includes'.DS);
define('SCRIPTS_DIR', DOC_ROOT.'pages'.DS.'scripts'.DS);
//define('HEADERS_DIR', DOC_ROOT . 'pages'.DS.'includes'.DS.'headers'.DS);
define('MODELS_DIR', DOC_ROOT.'pages'.DS.'scripts'.DS.'mysqli_models'.DS);
define('REL_DIR', $prot.$sern.'/'.$lh_dir); // relative link
# this cookie is to enable me move this value to JScript files
setrawcookie("REL_DIR", REL_DIR, time()+(60*60*24*7), "/");

require_once INCLUDES .'dbconnect.php';
include SCRIPTS_DIR."splitByCase.php";
include SCRIPTS_DIR."dateParser.php";
include SCRIPTS_DIR."elaborateDateParser.php";
include SCRIPTS_DIR."charHarsh.php";
include SCRIPTS_DIR."spaceCheck.php";
include SCRIPTS_DIR."imageResizer.php";