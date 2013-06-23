<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_GET['author_name'])){
$name = $_GET['author_name'];
$query = mysql_query("SELECT id FROM authors WHERE author='$name'");
while($row = mysql_fetch_array($query)){
$uid = $row['id'];
}
}
header("location:index.php?author_id=$uid");
?>