<?php
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
include('log.php');
if(isset($_GET['article_id'])){
$curruser = unserialize($_COOKIE['z_user']);
$aid = mysql_real_escape_string($_GET['article_id']);
$query = mysql_query("SELECT author FROM news WHERE id='$aid'");
while($row = mysql_fetch_array($query)){
$art_author = $row['author'];
}
if($curruser==$art_author or $curruser=="admin"){
$query_remove = mysql_query("DELETE FROM news WHERE id='$aid'");
header('location:index.php');
} 
else {
header('location:index.php?article_id='.$aid);
}
} else {
header('location:index.php');
}
?>