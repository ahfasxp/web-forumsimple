<?php
//connect.php
	$namahost="localhost";
	$username="root";
	$password="";
	$database="forum";
 
if(!mysql_connect($namahost, $username, $password))
	{
	    exit('Error: could not establish database connection');
	}
if(!mysql_select_db($database))
	{
	    exit('Error: could not select the database');
	}
?>