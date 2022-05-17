<?php
$dbconnect = mysqli_connect("localhost", "root", "EmenikE", "gwali-old");
#$dbconnect = mysqli_connect("localhost", "gwalinot_nike", "EmenikeGwali1?", "gwalinot_gwali");
if(mysqli_connect_errno()) {
	echo "Connection failed:".mysqli_connect_error();
	exit;
}