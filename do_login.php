<?php
session_start();
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
include('crypto.php');
include('log.php');

if(isset($_GET['u']) && isset($_GET['p'])){
$username = $_GET['u'];
$username = stripslashes($username);
$username = mysql_real_escape_string($username);
$password = $_GET['p'];
$password = stripslashes($password);
$password = mysql_real_escape_string($password);
$password = encrypt($password);
} else {
$username = $_POST['LoginUsername'];
$username = stripslashes($username);
$username = mysql_real_escape_string($username);
$password = $_POST['LoginPassword'];
$password = stripslashes($password);
$password = mysql_real_escape_string($password);
$password = encrypt($password);
}
$query="SELECT * FROM authors WHERE author='$username' AND password='$password'";
$result=mysql_query($query);
$count=mysql_num_rows($result);
if($count!=0){
$set_online=mysql_query("UPDATE authors SET online='YES' WHERE author='$username'");
unset($_SESSION['code_error']);
session_register('username');
session_register('password');
setcookie('z_user', serialize($username), time()+3600);
header("location:index.php");
} else {
header("location:index.php");
}
?>