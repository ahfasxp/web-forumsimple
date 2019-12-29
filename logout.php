<?php
include 'connect.php';

session_start();
session_destroy();
mysql_close($database);
header("location:login.php");

?>