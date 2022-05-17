<?php
# proceed only if this was a post request
if($_POST['task']=="logout"){
	# I need to set a session; without session start I literally can't
	session_start();
	
	# unset the sessions
	unset($_SESSION['gwalian_login_session']);
	# set the cookie to be sometime in the past
	setcookie("gwalian_persist", "", -1, "/");
	# return an okay status	
	echo 200;
}