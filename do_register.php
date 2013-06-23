<?php
session_start();
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
include('crypto.php');
include('log.php');
$uname = $_POST['RegisterName'];
$uname = stripslashes($uname);
$uname = mysql_real_escape_string($uname);
$pass = $_POST['RegisterPassword'];
$pass = stripslashes($pass);
$pass = mysql_real_escape_string($pass);
$re_pass = $_POST['RegisterPasswordRe'];
$re_pass = stripslashes($re_pass);
$re_pass = mysql_real_escape_string($re_pass);
$email = $_POST['RegisterMail'];
$email = stripslashes($email);
$email = mysql_real_escape_string($email);
$captcha_txt = $_POST['CaptchaText'];
$captcha_txt = stripslashes($captcha_txt);
$captcha_txt = mysql_real_escape_string($captcha_txt);
$c_txt = $_SESSION['captcha_txt'];
$c2_txt = $_SESSION['captcha_atxt'];
if(empty($uname) or empty($pass) or empty($re_pass) or empty($email) or empty($captcha_txt) or $uname=="Name" or $pass=="Password" or $re_pass=="Retype Password" or $email=="Email"){
$_SESSION['fill_error'] = 'Please fill in all registration fields.';
header("location:index.php");
}
$query_check_username = mysql_query("SELECT * FROM authors WHERE author='$uname'");
$count_username = mysql_num_rows($query_check_username);
if($count_username!=0){
$_SESSION['username_used'] = 'Username already in use.';
header('location:index.php');
} else {
if($pass==$re_pass){ 
if($captcha_txt==$c_txt or $captcha_txt==$c2_txt){
define('LOG_UPLOADS',true);
define('LOG_FILE','forbidden/log/uploads.log');
$allowed_ext = array (

  // archives
  /*'zip' => 'application/zip',
  'rar' => 'application/x-rar-compressed',
  'bz' => 'application/x-bzip',
  'gtar' => 'application/x-gtar',
  'tar.gz' => 'application/x-gtar',*/
  
  // documents 
  //'pdf' => 'application/pdf',
  //'doc' => 'application/msword',
  //'docx' => 'application/msword',
  //'xls' => 'application/vnd.ms-excel',
  //'ppt' => 'application/vnd.ms-powerpoint',
  //'pptx' => 'application/vnd.ms-powerpoint', 
  // extra
  //'torrent' => 'application/x-bittorrent',
  
  // executables
  //'exe' => 'application/octet-stream',

  // images
  'gif' => 'image/gif',
  'png' => 'image/png',
  'jpg' => 'image/jpeg',
  'jpeg' => 'image/jpeg'

  // audio
  //'mp3' => 'audio/mpeg',
  //'wav' => 'audio/x-wav',
  //'mp4' => 'audio/mp4',

  // video
  //'mpeg' => 'video/mpeg',
  //'mpg' => 'video/mpeg',
  //'mpe' => 'video/mpeg',
  //'mov' => 'video/quicktime',
  //'avi' => 'video/x-msvideo',
  //'wmv' => 'video/x-ms-wmv'
);
$exttest = $_FILES['RegisterImage']['name'];

/*$strip = str_replace($exttest, "", "-");
$strip = str_replace($exttest, "", "&");
$strip = str_replace($exttest, "", "(");
$strip = str_replace($exttest, "", ")");
$strip = str_replace($exttest, "", "[");
$strip = str_replace($exttest, "", "]");
$strip = str_replace($exttest, "", " ");*/
$fext = strtolower(substr(strrchr($exttest,"."),1));

if (!array_key_exists($fext, $allowed_ext)) {
  
  
}
else{

$name = $_FILES["RegisterImage"]["name"];
$tmpname = $_FILES["RegisterImage"]["tmp_name"];

move_uploaded_file($tmpname, "author_images/$name") || die;
$dir = "author_images/".$_FILES['RegisterImage']['name'];
$filef = $_FILES['RegisterImage']['name'];
if ($_FILES['RegisterImage']['name'] != "")	
{

$res = $_FILES['RegisterImage']['name'];
$filname = $_FILES['RegisterImage']['name'];
$size = $_FILES['RegisterImage']['size'];
$type = $_FILES['RegisterImage']['type'];


}
if (!LOG_UPLOADS) die();

$f = @fopen(LOG_FILE, 'a+');
if ($f) {
  @fputs($f, date("m.d.Y g:ia")."  ".$_SERVER['REMOTE_ADDR']."  ".$filef."  "."\n");
  @fclose($f);

}

}
$hash = encrypt($pass);
$image = $dir;
if(empty($image)){
$image = "image/author_file.png";
}
$date = date("d-m-Y");
$ip = $_SERVER['REMOTE_ADDR'];
$query_register = mysql_query("INSERT INTO authors (author, password, image, email, register_date, ip_address) VALUES ('$uname', '$hash', '$image', '$email', '$date', '$ip')");
$query_get_id = mysql_query("SELECT id FROM authors WHERE author='$name'");
while($r = mysql_fetch_array($query_get_id)){
$author_id = $r['id'];
}
header("location:do_login.php?u=".$uname."&p=".$pass);
} else {
$_SESSION['captcha_wrong'] = 'You identified the wrong person.';
header("location:index.php");
}
} else {
$_SESSION['password_mismatch'] = "Passwords don't match.";
header("location:index.php");
}
}
?>