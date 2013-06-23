<?php
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_GET['article_id'])){
$art_id = mysql_real_escape_string($_GET['article_id']);
$get_likes_query = mysql_query("SELECT likes FROM news WHERE id='$art_id'");
while($row = mysql_fetch_array($get_likes_query)){
$curr_likes = $row['likes'];
}
echo "$curr_likes likes";
}
else {
header("location:index.php?article_id=$art_id");
}
?>