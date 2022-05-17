<?php
class DB_con {
	protected function dbconnect(){
		# local version
		$dbconnect = new mysqli("localhost", "root", "EmenikE", "gwali-old");
		# live version
		#$dbconnect = mysqli_connect("localhost", "gwalinot_nike", "EmenikeGwali1?", "gwalinot_gwali");
		if(mysqli_connect_errno()) {
			echo "Connection failed:".mysqli_connect_error();
			exit;
		} else {
			return $dbconnect;
		}
	}
}