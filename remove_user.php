<?php
session_start();
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_GET['n_code']) && isset($_GET['o_code'])){
echo $ocode = mysql_real_escape_string($_GET['o_code']);
echo $ncode = mysql_real_escape_string($_GET['n_code']);
if($ocode==$ncode){
$query_remove=mysql_query("DELETE FROM authors WHERE profileCode='$ocode'");
} else {
$_SESSION['code_error'] = 'Session has expired, try again.';
header("location:index.php?profile_code=$ncode");
}
} else {
header('location:index.php');
}
?>