<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 

$query = mysql_query("SELECT id, image, title, author, likes FROM news WHERE id > (SELECT count(id) - 9 FROM news) ORDER BY id DESC");
while($row = mysql_fetch_array($query)){
	$image = $row['image'];
	$title = $row['title'];
	$likes = $row['likes'];
	$normal_title = $title;
	if(strlen($title)>25){
	$title = substr($title, 0, 25).'...';
	}
	$author = $row['author'];
	$id = $row['id'];
	if(empty($image)){
	$image = "image/article_file.png";
	}
	echo '<div id="recentContainer" title="'.$normal_title.'"><a href="index.php?article_id='.$id.'"><div id="recent" onclick="SelectArticle('.$id.')"><img id="recent_img" src="'.$image.'" width="50px" height="50px"><span id="recent_title"><b>'.$title.'</b></span><br /><span id="recent_author"><i>by '; echo $author; echo '</i></span></div></a><div>';
}

?>