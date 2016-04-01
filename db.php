<?php
	$conn = mysqli_connect("localhost", "root", "");
	if($conn) {
		$db = mysqli_select_db($conn, "user");
		if(!$db) {
			echo "NO database";
		}	
	}
?>