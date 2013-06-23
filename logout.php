<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
$username=unserialize($_COOKIE['z_user']);
setcookie("z_user", "", time()-3600);
$set_offline=mysql_query("UPDATE authors SET online='NO' WHERE author='$username'");
$query_set_inactive = mysql_query("UPDATE authors SET active='NO' WHERE author='$username'");
header('location:index.php');
?>