<?php
session_start();
include('crypto.php');
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 

// Get filled in register field
if(isset($_GET['n'])){
$regname = mysql_real_escape_string($_GET['n']);
$regname = stripslashes($regname);
}
if(isset($_GET['m'])){
$regmail = mysql_real_escape_string($_GET['m']);
$regmail = stripslashes($regmail);
}

// Get Username logged in
if(isset($_COOKIE['z_user'])){
$myusername = unserialize($_COOKIE['z_user']); // !INSECURE!
$query_image = mysql_query("SELECT image FROM authors WHERE author='$myusername'");
while($row_image = mysql_fetch_array($query_image)){
$myuserimage = $row_image['image'];
}
$logged_in = "1";
} else {
$myusername = "Guest";
$myuserimage = "image/author_file.png";
$logged_in = "0";

}
if(empty($myusername)){
header('location:logout.php');
}
// Load cloud page
if(isset($_GET['cloud_id'])){
$cloud_id=mysql_real_escape_string($_GET['cloud_id']);
}

// Load profile page
if(isset($_GET['profile_code']) && $myusername!="Guest"){
$profile_code = mysql_real_escape_string($_GET['profile_code']);
$code_date = date("HidmY");
$real_code = encrypt($myusername.$code_date);
if($profile_code==$real_code){
$profile_accept="1";
} else {
$profile_accept="0";
}
} else {
$profile_accept="0";
}

// Get liked articles
$get_liked_articles = mysql_query("SELECT likedArticles FROM authors WHERE author='$myusername'");
while($s = mysql_fetch_array($get_liked_articles)){
$larticles = $s['likedArticles'];
}
// Load theater view
if(isset($_GET['image_theater']) && isset($_GET['article_id'])){
$image_theater = mysql_real_escape_string($_GET['image_theater']);
}
if(isset($_GET['image_author_theater']) && isset($_GET['author_id'])){
$image_author_theater = mysql_real_escape_string($_GET['image_author_theater']);
}

// Load searched article
if(isset($_GET['article_id'])){
$search_id = mysql_real_escape_string($_GET['article_id']);
$query_check = mysql_query("SELECT * FROM news WHERE id='$search_id'");
$check = mysql_num_rows($query_check);
if($check==0){
header("location:index.php");
}
$query = mysql_query("SELECT title, content, image, author, date, likes FROM news WHERE id='$search_id'");

while($row = mysql_fetch_array($query)){
  $article_title = $row['title'];
  $article_content = $row['content'];
  $article_image = $row['image'];
  $article_author = $row['author'];
  $article_date = $row['date'];
  $article_likes = $row['likes'];
  }

}
// Load searched author
if(isset($_GET['author_id'])){
$uid = mysql_real_escape_string($_GET['author_id']);
$query_check = mysql_query("SELECT * FROM authors WHERE id='$uid'");
$check = mysql_num_rows($query_check);
if($check==0){
header("location:index.php");
}
$query = mysql_query("SELECT * FROM authors WHERE id='$uid'");
while($row = mysql_fetch_array($query)){
  $author_name = $row['author'];
  $author_image = $row['image'];
  $author_online = $row['online'];
  $author_active = $row['active'];
  }
}
// Load action
if(isset($_GET['action']) && isset($_GET['author'])){
$action = mysql_real_escape_string($_GET['action']);
$author = mysql_real_escape_string($_GET['author']);
}

define('LOGS',true);
define('LOG_FILE','forbidden/log/visits.log');
if (!LOGS) die();

$f = @fopen(LOG_FILE, 'a+');
if ($f) {
  @fputs($f, date("m.d.Y H:i:s")."  ".$_SERVER['REMOTE_ADDR']."  ".$myusername." ".unserialize($_COOKIE['z_user'])." \n");
  @fclose($f);

}
?>
<html>
<head>
<title>Zimid</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="shortcut icon" href="image/favicon.ico" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/js_x16v08r.js"></script>
<script type="text/javascript" src="js/jquery.autosize.js"></script>
<script type="text/javascript" src="js/jquery.autosize-min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('textarea').autosize(); 

});
function AdaptToImage(){
document.title="Zimid - Login or Register";
document.getElementById('sidebar').style.visibility="hidden";

}
</script>
</head>
<body>
<div id="header">
<div id="head">
<a href="index.php"><h2 id="Title">Zimid</h2></a>
</div>
<div id="MenuStrip">
<ul id="Menu">
<?php $username1 = "'$myusername'"; $txt_Username = "'Username'"; $LoginUsername = "'LoginUsername'"; $txt_Password = "'Password'"; $LoginPassword = "'LoginPassword'"; if($logged_in=="0"){ echo '<li class="MenuItem"><form id="FrmLogin" action="do_login.php" method="post"><td><label for="LoginUsername"></label><input type="text" class="LoginClassNW" spellcheck="false" autofocus="autofocus" name="LoginUsername" id="LoginUsername" value="Username" onkeydown="ClearSearch('.$LoginUsername.', '.$txt_Username.');" onfocus="InitSearch('.$LoginUsername.', '.$txt_Username.');" onblur="CheckLoginUsername();"></td><td><label for="LoginPassword"></label><input type="text" class="LoginClassNW" spellcheck="false" name="LoginPassword" id="LoginPassword" value="Password" onkeydown="ClearSearch('.$LoginPassword.', '.$txt_Password.');" onfocus="InitSearch('.$LoginPassword.', '.$txt_Password.'); ChangeToPassword('.$LoginPassword.');" onblur="CheckLoginPassword(); ChangeToNormal('.$LoginPassword.', '.$txt_Password.');" onsubmit="ChangeToPassword('.$LoginPassword.');" autocomplete="off"></td><td><label for="LoginSubmit"></label><input type="submit" class="cbutton" name="LoginSubmit" id="LoginSubmit" value="Login"></td></form></li>';} elseif($logged_in=="1"){ echo '<span id="Logout"><a href="logout.php">Logout</a></span>';}?><li class="MenuItem"><div id="status"></div></li><?php if($myusername!="Guest"){ echo '<li class="MenuItem"><div id="UploadNewArticle"><span id="UploadText"><img onclick="Write_article('.$username1.');" id="WritingImage" src="image/writing_file.png" width="30" height="30"></span></div></li>';}?><li class="MenuItem"><div id="AuthorProfile" <?php if($myusername!="Guest"){ $usern = "'$myusername'"; echo 'onclick="LoadUserProfile('.$usern.');"'; } ?> ><img id="MenuAuthorImage" src="<?php echo $myuserimage;?>" width="30" height="30"><span id="MenuAuthorName"><?php echo $myusername; ?></span></div></li><li class="MenuItem"><div id="SearchBar"><form id="SearchForm" method="post" action="search.php"><input type="text" id="SearchText" class="edit-field-overlay" value="Find news and more..."  onkeydown="ClearSearch('SearchText', 'Find news and more...');" onkeyup="SearchLoad();" onfocus="InitSearch('SearchText', 'Find news and more...');" onblur="#WIP CloseSuggest();"  autocomplete="off" /></form></div></li>
</ul>
<div id="SearchSuggest"></div>
</div>
</div>
<div class="content">
<div id="sidebar">
<p>Recent articles</p>
<div id="recentArticles"></div>
</div>
<div id="main">
<div id="ArticleReader"><button id="BtnResetReader" class="cbutton" onclick="resetReader();">&uarr;</button><label for="ReaderSpeed">Speed:</label><input type="text" class="LoginClassNW" id="ReaderSpeed" name="ReaderSpeed" autocomplete="false" spellcheck="false" value="200"><br /><button id="BtnStartReading" class="cbutton" onclick="pageScroll();">Start</button><button id="BtnStopReading" class="cbutton" onclick="stopScroll();">Stop</button></div>
<?php

if(isset($_GET['article_id']) && !isset($_GET['image_theater'])){
echo '<div id="article_container">';
if($myusername==$article_author or $myusername=="admin"){
echo '<button id="article_remove" class="cbutton" title="Remove article" onclick="removeArticle('.$search_id.');">X</button>';
}
echo "<h2 id='article_title'>$article_title</h2>";
echo "<span id='article_content'>$article_content</span><br /><br />";
echo "<button id='BtnReader' class='cbutton'>Reader</button>";
if(!empty($article_image)){ $img = "'$article_image'"; echo '<img title="Click to enlarge" onclick="EnlargeImage('.$search_id.', '.$img.');" id="article_img" src="'.$article_image.'" width="400" heigth="320"> <br />';}
echo "<span id='article_author'>by <a href='author.php?author_name=$article_author'>$article_author</a></span><br />";
echo "<span id='article_date'>date: $article_date</span><br />";
if($myusername!="Guest"){$pos = strpos($larticles, $search_id);} else { $pos=false; }
echo "<span id='article_likes'>$article_likes likes</span><span id='like_article'"; if($pos==false && $myusername!="Guest"){ echo " onclick='like_article(".$search_id.");'>";} else { echo ">";} if($pos==false && $myusername!="Guest"){ echo "Like"; } elseif($myusername!="Guest") { echo "You like this";} echo "</span><br />";
echo '</div>';
}
elseif(isset($_GET['author_id'])){
$author1 = "'".$uid."'";
$img1 = "'".$author_image."'";
if($author_online=="YES"){
$a_online = "online";
} else {
$a_online = "offline";
}
if($author_active=="YES"){
$a_active = "active";
} else {
$a_active = "inactive";
}
echo "<h2 id='article_title'>$author_name - $a_online - $a_active</h2>";
echo '<img onclick="EnlargeAuthorImage('.$author1.', '.$img1.');" id="article_img" src="'.$author_image.'" width="400" heigth="320"> <br />';
}
elseif(isset($_GET['action']) && isset($_GET['author']) && $myusername!="Guest"){
$art_title = "'Article_title'";
$art_txt = "'Article title'";
$art_content = "'Article_content'";
$art_ctxt = "'Article content'";
echo '<h2 id="HeadWriteArticle">Publish an article</h2><form id="FrmWriteArticle" action="write_article.php" method="post" enctype="multipart/form-data"><table id="TblWriteArticle" border="0"><tr><td><label for="Article_title"></label><input type="text" id="Article_title" spellcheck="false" name="Article_title" class="WriteInput" value="Article title" onkeydown="ClearSearch('.$art_title.', '.$art_txt.');" onclick="InitSearch('.$art_title.', '.$art_txt.');"></td></tr><tr><td><label for="Article_content"></label><textarea spellcheck="false" type="text" id="Article_content" name="Article_content" style="overflow:hidden;" class="WriteInput" onkeydown="ClearSearch('.$art_content.', '.$art_ctxt.');" onclick="InitSearch('.$art_content.', '.$art_ctxt.');"></textarea></td></tr><tr><td><input class="WriteInput" type="file" id="Article_image" name="Article_image"><label id="imglbl" for="Article_image"></label></td></tr><tr><td><input type="text" value="'; echo $author; echo '" style="display:none;" id="Article_author" name="Article_author"><input class="cbutton" type="submit" value="Publish" id="Article_submit" name="Article_submit"></table></form>';
}
elseif(isset($_GET['image_theater']) && isset($_GET['article_id'])){
echo '<div class="overlay" id="ImageContainer"><img class="overlay" src="'.$image_theater.'" width="800" height="600" id="theater_image"><button class="cbutton" id="BtnCloseImage" title="Close" onclick="CloseImage('.$search_id.');">X</button></div>';
}
elseif(isset($_GET['profile_code']) && $profile_accept=="1" && $myusername!="Guest"){
include('profile.php');
}
if(isset($_GET['image_author_theater']) && isset($_GET['author_id'])){
echo '<div class="overlay" id="ImageContainer"><img class="overlay" src="'.$image_author_theater.'" width="800" height="600" id="theater_image"><button class="cbutton" title="Close" id="BtnCloseImage" onclick="CloseAuthorImage('.$uid.');">X</button></div>';
}

elseif($logged_in==1  && !isset($_GET['image_theater']) && !isset($_GET['author_id']) && !isset($_GET['image_author_theater']) && !isset($_GET['profile_code']) && !isset($_GET['article_id']) && !isset($_GET['action']) && !isset($_GET['author'])){
include('newscloud.php');
}

if($myusername=="Guest" && !isset($_GET['image_theater']) && !isset($_GET['author_id']) && !isset($_GET['image_author_theater']) && !isset($_GET['profile_code']) && !isset($_GET['article_id']) && !isset($_GET['action']) && !isset($_GET['author'])){
echo '<script type="text/javascript">'
   , 'AdaptToImage();'
   , '</script>';
include('login.php');
}
?>
</div>
<div id="footer">
Zimid is a trademark of Xander Van Raemdonck WebDev. For more information about Zimid, please contact our <a href="mailto:xandervanraemdonck@outlook.com">support service</a>.
</div>
</div>

</body>
</html>