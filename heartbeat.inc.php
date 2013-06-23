<?php

/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_COOKIE['z_user'])){
$username = unserialize($_COOKIE['z_user']);

if(isset($_GET['set'])){
$set = mysql_real_escape_string($_GET['set']);
}
if($set=='inactive'){
$query_set_inactive = mysql_query("UPDATE authors SET active='NO' WHERE author='$username'");
} elseif($set=='active'){
$query_set_active = mysql_query("UPDATE authors SET active='YES' WHERE author='$username'");
}
}


?>