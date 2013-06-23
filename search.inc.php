<?php
include('log.php');
if(isset($_GET['s'])) {
$search_text = $_GET['s'];
}
if(!empty($search_text)){
if(@mysql_connect("localhost","","")){
if(@mysql_select_db("zimid")){

	
	$query = "SELECT id, title, author, content, image FROM news WHERE title LIKE '%".mysql_real_escape_string($search_text)."%' OR content LIKE '%".mysql_real_escape_string($search_text)."%' OR author LIKE '".mysql_real_escape_string($search_text)."%' ORDER BY search_count DESC";
	$query_run = mysql_query($query);
	$query2 = "SELECT id, author, email, image FROM authors WHERE email LIKE '%".mysql_real_escape_string($search_text)."%' OR author LIKE '".mysql_real_escape_string($search_text)."%' ORDER BY id DESC";
	$query2_run = mysql_query($query2);
	if($query_run){
	while($query_row = mysql_fetch_assoc($query_run)) {
		$title = $query_row['title'];
		$normal_title = $title;
		if(strlen($title)>32){
	$title = substr($title, 0, 32).'...';
	}
		
		echo $username = '<div id="searchContainer" title="'.$normal_title.'"><a href="index.php?article_id='.$query_row['id'].'"><div class="res" onclick="SelectArticle('.$query_row['id'].')" ><span id="Searchres"><img id="search_image" src="'.$query_row['image'].'" width="40" height="40"></img><span id="search_title"><b>'.$title.'</b></span></span></div></a></div>';
		}
	
		
	}
	if($query2_run){
	while($query2_row = mysql_fetch_assoc($query2_run)) {
		
		
		echo $username = '<div id="searchContainer"><a href="index.php?author_id='.$query2_row['id'].'"><div class="res" onclick="SelectAuthor('.$query2_row['id'].')" ><span id="Searchres"><img id="search_image" src="'.$query2_row['image'].'" width="40" height="40"></img><span id="search_title"><b>'.$query2_row['author'].'</b></span></span></div></a></div>';
		}
	
		
	}
	

}
}
}

?>