<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_COOKIE['z_user'])){
if(isset($_GET['user_id']) && isset($_GET['msg'])){
$sender = unserialize($_COOKIE['z_user']);
$uid = mysql_real_escape_string($_GET['user_id']);
$query_get_name = mysql_query("SELECT author FROM authors WHERE id='$uid'");
while($r = mysql_fetch_array($query_get_name)){
$receiver = $r['author'];
}
$msg = mysql_real_escape_string($_GET['msg']);
$date = date('H:i:s d/m/Y');
$query = mysql_query("INSERT INTO messages (sender, receiver, message, date) VALUES ('$sender', '$receiver', '$msg', '$date')");
}
}
?>