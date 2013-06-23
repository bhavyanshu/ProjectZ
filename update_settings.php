<?php
include('crypto.php');
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
$author = stripslashes(mysql_real_escape_string($_POST['settingsAuthor']));
$password = stripslashes(mysql_real_escape_string($_POST['settingsPassword']));
$repassword = stripslashes(mysql_real_escape_string($_POST['settingsPasswordRe']));
$email = stripslashes(mysql_real_escape_string($_POST['settingsEmail']));
$bio = stripslashes(mysql_real_escape_string($_POST['settingsBio']));
$bday = stripslashes(mysql_real_escape_string($_POST['settingsBday']));

define('LOG_UPLOADS',true);
define('LOG_FILE','forbidden/log/uploads.log');
$allowed_ext = array (

 
  

  'gif' => 'image/gif',
  'png' => 'image/png',
  'jpg' => 'image/jpeg',
  'jpeg' => 'image/jpeg'


);
$exttest = $_FILES['settingsImage']['name'];


$fext = strtolower(substr(strrchr($exttest,"."),1));

if (!array_key_exists($fext, $allowed_ext)) {
  $_SESSION['errup'] = "File type not allowed.";
  

}
else{

$name = $_FILES["settingsImage"]["name"];
$tmpname = $_FILES["settingsImage"]["tmp_name"];

move_uploaded_file($tmpname, "author_images/$name") || die;
$dir = "author_images/".$_FILES['settingsImage']['name'];
$filef = $_FILES['settingsImage']['name'];
if ($_FILES['settingsImage']['name'] != "")	
{

$res = $_FILES['settingsImage']['name'];
$filname = $_FILES['settingsImage']['name'];
$size = $_FILES['settingsImage']['size'];
$type = $_FILES['settingsImage']['type'];
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
if(isset($dir)){
$image = $dir;
$query_image = mysql_query("UPDATE authors SET image='$image' WHERE author='$author'");
}
$query = mysql_query("SELECT author, password, email, bio, birthday FROM authors WHERE author='$author'");
while($row = mysql_fetch_array($query)){
$db_author = $row['author'];
$db_pass = $row['password'];
$db_email = $row['email'];
$db_bio = $row['bio'];
$db_bday = $row['birthday'];
}
if($password!="Password" && $repassword!="Retype password" && $password==$repassword){
$newpass = encrypt($password);
$query_pass = mysql_query("UPDATE authors SET password='$newpass' WHERE author='$author'");
} 
if($email!="Email"){
$query_mail = mysql_query("UPDATE authors SET email='$email' WHERE author='$author'");
}
if($bday!="Birthday"){
$query_bday = mysql_query("UPDATE authors SET birthday='$bday' WHERE author='$author'");
}
if($bio!="Biography"){
$query_bio = mysql_query("UPDATE authors SET bio='$bio' WHERE author='$author'");
}
header('location:index.php');
?>