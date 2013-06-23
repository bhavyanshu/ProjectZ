<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_COOKIE['z_user'])){
$user = unserialize($_COOKIE['z_user']);
// user received
 
$query=mysql_query("SELECT * FROM messages WHERE receiver='$user'");
echo '<ul id="ChatLinks">';
while($r = mysql_fetch_array($query)){
$name = $r['sender'];
$query_img = mysql_query("SELECT image FROM authors WHERE author='$name'");
while($ri = mysql_fetch_array($query_img)){
$image = $ri['image'];
}
$msg = $r['message'];
$date = $r['date'];
echo '<li class="ChatLink"><img id="ChatImage" src="'.$image.'" width="30" height="30"><span id="ChatMessage">'.$msg.'</span><span id="ChatDate">'.$date.'</span></li>';
}
// user sent
$query=mysql_query("SELECT * FROM messages WHERE sender='$user'");
while($r = mysql_fetch_array($query)){
$name = $r['sender'];
$query_img = mysql_query("SELECT image FROM authors WHERE author='$user'");
while($ri = mysql_fetch_array($query_img)){
$image = $ri['image'];
}
$msg = $r['message'];
$date = $r['date'];
echo '<li class="ChatLink"><span id="ChatMessage">'.$msg.'</span><span id="ChatDate">'.$date.'</span><img id="ChatImage" src="'.$image.'" width="30" height="30"></li>';
}

echo '</ul>';
}
?>