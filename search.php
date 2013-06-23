<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_GET['q'])) {
$search_id = mysql_real_escape_string($_GET['q']);
header("location:index.php?article_id=".$search_id);
} else {
header("location:index.php");
}

?>