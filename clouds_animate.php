<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
$query_get_clouds = mysql_query("SELECT * FROM clouds ORDER BY rating DESC");
while($row = mysql_fetch_array($query_get_clouds)){
$ids[] = $row['id'];
$names[] = $row['name'];
$owners[] = $row['owner'];
$images[] = $row['photo'];
$ratings[] = $row['rating'];
}
		$a = 0;
		$b = 0;
		$c = 0;
		$d = 0;
		$e = 0;
		$g = 0;
		$f = 0;
foreach ($ids as $id){
$ids[$a] = $id;
$a++;
}
foreach ($names as $name){
$names[$b] = $name;
$b++;
}
foreach ($owners as $owner){
$owners[$c] = $owner;
$c++;
}
foreach ($images as $image){
$images[$d] = $image;
$d++;
}
foreach ($ratings as $rating){
$ratings[$e] = $rating;
$e++;
$f=$e;
}
echo '<ul id="cloudlist">';
for($i=0;$i<$f;$i++){
echo '<li class="cloud" onclick="OpenCloud('.$ids[$i].');"><img src="'.$images[$i].'" id="cloudImage" width="150" height="150"><span id="cloudName">'.$names[$i].'</span><span id="cloudRating">'.$ratings[$i].'</span></li>';
}
echo '</ul>';
?>