<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
function getCaptcha(){
$min_query = mysql_query("SELECT id FROM captcha ORDER BY id ASC LIMIT 1");
while($row=mysql_fetch_array($min_query)){
$min_id = $row['id'];
}
$max_query = mysql_query("SELECT id FROM captcha ORDER BY id DESC LIMIT 1");
while($rowm=mysql_fetch_array($max_query)){
$max_id = $rowm['id'];
}
$rand_id = rand($min_id, $max_id);
$get_captcha = mysql_query("SELECT * FROM captcha WHERE id='$rand_id'");
while($row_c = mysql_fetch_array($get_captcha)){
$image = $row_c['image'];
$text = $row_c['text'];
$atext = $row_c['textAlter'];
}
return array('img' => $image,
			 'txt' => $text,
			 'atxt' => $atext);
}

?>