<?php


	define("HOSTNAME", "localhost");
	define("USERNAME", "root");
	define("PASSWORD", "");
	define("DBNAME", "shoppn");

	function openConnection(){

		//make database connect 
		$con = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME) or die("Connection Failed");

		//echo "<br> Database Connection Succesful";
		return $con;
	}


	function closeConnection($con){
		$con->close();
	}

	//test database connection 
?>