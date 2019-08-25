<?php
/*
 * How to connect to the database
 */
 
//Fill these with correct values
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "openrobotics");
define("MYSQL_PASSWORD", "Password1");
define("MYSQL_DATABASE", "openrobotics");

/*
 * connect to the db and return a mysqli object
 * return null on connection error
 * remember to close connection
 */
function get_db() {
	$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
	if ($mysqli->connect_errno)	{
		return null;
	} //else
	return $mysqli;
}

?>