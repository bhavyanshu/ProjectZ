<?php
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
include('crypto.php');
include('log.php');
if(isset($_GET['author_name'])){
$a = mysql_real_escape_string($_GET['author_name']);
$date = date("HidmY");
$plain = $a.$date;
echo $hash = encrypt($plain);
setcookie('z_code', $hash, time()+60);
$query = mysql_query("UPDATE authors SET profileCode='$hash' WHERE author='$a'");
}
?>