<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
$query = mysql_query("SELECT * FROM authors WHERE online='YES' AND active='YES' ORDER BY author ASC");
while($row = mysql_fetch_array($query)){
$id = $row['id'];
$name = $row['author'];
$photo = $row['image'];
echo '<li class="UserLink" onclick="LoadUser('.$id.');"><img id="LinkImage" src="'.$photo.'" width="30" height="30"><span id="LinkName">'.$name.'</span></li>';
}
?>