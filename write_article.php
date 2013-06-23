<?php session_start(); ?>
<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
$art_title = $_POST['Article_title'];
$art_content = $_POST['Article_content'];
if($art_title=="Article title" or $art_content=="Article content"){
$accept=0;
} else {
$accept=1;
}
if($accept=="1"){
$art_title = stripslashes($art_title);
$art_title = mysql_real_escape_string($art_title);
$art_content = stripslashes($art_content);
$art_content = mysql_real_escape_string($art_content);
$art_author = $_POST['Article_author'];
$art_author = stripslashes($art_author);
$art_author = mysql_real_escape_string($art_author);

define('LOG_UPLOADS',true);
define('LOG_FILE','forbidden/log/uploads.log');
$allowed_ext = array (

 
  

  'gif' => 'image/gif',
  'png' => 'image/png',
  'jpg' => 'image/jpeg',
  'jpeg' => 'image/jpeg'


);
$exttest = $_FILES['Article_image']['name'];


$fext = strtolower(substr(strrchr($exttest,"."),1));

if (!array_key_exists($fext, $allowed_ext)) {
header("location:index.php");
}
else{

$name = $_FILES["Article_image"]["name"];
$tmpname = $_FILES["Article_image"]["tmp_name"];

move_uploaded_file($tmpname, "article_images/$name") || die;
$dir = "article_images/".$_FILES['Article_image']['name'];
$filef = $_FILES['Article_image']['name'];
if ($_FILES['Article_image']['name'] != "")	
{

$res = $_FILES['Article_image']['name'];
$filname = $_FILES['Article_image']['name'];
$size = $_FILES['Article_image']['size'];
$type = $_FILES['Article_image']['type'];
$_SESSION['size'] = $size;
$_SESSION['type'] = $type;
$_SESSION['filename'] = $filef;

}
if (!LOG_UPLOADS) die();

$f = @fopen(LOG_FILE, 'a+');
if ($f) {
  @fputs($f, date("m.d.Y g:ia")."  ".$_SERVER['REMOTE_ADDR']."  ".$filef."  "."\n");
  @fclose($f);

}

}
$query_get_author_image = mysql_query("SELECT image FROM authors WHERE author='$art_author'");
while($select_row = mysql_fetch_array($query_get_author_image)){
$author_image = $select_row['image'];
}
echo $art_image = $dir;

$curr_date = date("d-m-Y");
$u_code = rand(0,99999999);
$query = mysql_query("INSERT INTO news (title, content, image, date, author, author_image, code) VALUES ('$art_title', '$art_content', '$art_image', '$curr_date', '$art_author', '$author_image', '$u_code')");
$query_get_id=mysql_query("SELECT id FROM news WHERE code='$u_code'");
while($select_id_row = mysql_fetch_array($query_get_id)){
$art_id = $select_id_row['id'];
}
header("location:index.php?article_id=$art_id");
}
else {
header("location:index.php");
}
?>
