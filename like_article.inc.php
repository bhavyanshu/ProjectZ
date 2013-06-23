<?php
session_start();
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_COOKIE['z_user'])){
$liker = unserialize($_COOKIE['z_user']); // !INSECURE!
} else {
header("location:index.php");
}
if(isset($_GET['article_id'])){
$art_id = mysql_real_escape_string($_GET['article_id']);
$get_likes_query = mysql_query("SELECT likes FROM news WHERE id='$art_id'");
$get_liked_articles = mysql_query("SELECT likedArticles FROM authors WHERE author='$liker'");
while($s = mysql_fetch_array($get_liked_articles)){
$larticles = $s['likedArticles'];
}
$pos = strpos($larticles, $art_id);
if($pos == false){
while($row = mysql_fetch_array($get_likes_query)){
$curr_likes = $row['likes'];
}
$new_likes = $curr_likes + 1;
$insert_like_query = mysql_query("UPDATE news SET likes='$new_likes' WHERE id='$art_id'");
$get_user_likes = mysql_query("SELECT likedArticles FROM authors WHERE author='$liker'");
while($r = mysql_fetch_array($get_user_likes)){
$liked = $r['likedArticles'];
}
$newliked = $liked." $art_id";
$insert_likes = mysql_query("UPDATE authors SET likedArticles='$newliked' WHERE author='$liker'");
}

}
else {
header("location:index.php");
}
?>