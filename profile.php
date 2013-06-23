<?php
include('log.php');
/* This code will make a connection with database */
$con=mysql_connect("localhost","",""); 
/* Now, we select the database */
mysql_select_db("zimid"); 
if(isset($_GET['profile_code'])){
$code = mysql_real_escape_string($_COOKIE['z_code']);
$query = mysql_query("SELECT id, author, image, email, bio, birthday FROM authors WHERE profileCode='$code'");
while($row=mysql_fetch_array($query)){
$id = $row['id'];
$author = $row['author'];
$image = $row['image'];
$email = $row['email'];
$bio = $row['bio'];
$birthday = $row['birthday'];
}
}
?>

<div id="settingsDiv">
<h2 id="settingsHead">Settings</h2>
<form id="settingsFrm" action="update_settings.php" method="post" enctype="multipart/form-data">
<table id="settingsTbl" border="0">
<tr>
<td><input type="text" class="LoginClass" spellcheck="false" id="settingsAuthor" name="settingsAuthor" value="<?php echo $author; ?>" readonly></td>
</tr>
<tr>
<td><input type="text" class="LoginClass" spellcheck="false" id="settingsPassword" name="settingsPassword" value="Password" onkeydown="ClearSearch('settingsPassword', 'Password');" onfocus="InitSearch('settingsPassword', 'Password'); ChangeToPassword('settingsPassword');" onblur="CheckForm('settingsPassword', 'Password'); ChangeToNormal('settingsPassword', 'Password');"></td>
</tr>
<tr>
<td><input type="text" class="LoginClass" spellcheck="false" id="settingsPasswordRe" name="settingsPasswordRe" value="Retype password" onkeydown="ClearSearch('settingsPasswordRe', 'Retype password');" onfocus="InitSearch('settingsPasswordRe', 'Retype password'); ChangeToPassword('settingsPasswordRe');" onblur="CheckForm('settingsPasswordRe', 'Retype password'); ChangeToNormal('settingsPasswordRe', 'Retype password');"></td>
</tr>
<tr>
<td><input type="text" class="LoginClass" spellcheck="false" id="settingsEmail" name="settingsEmail" value="<?php if(empty($email)){ echo "Email"; } else { echo $email;} ?>" onkeydown="ClearSearch('settingsEmail', 'Email');" onfocus="InitSearch('settingsEmail', 'Email');" onblur="CheckForm('settingsEmail', 'Email');"></td>
</tr>
<tr>
<td><input type="text" class="LoginClass" spellcheck="false" id="settingsBday" name="settingsBday" value="<?php if(empty($birthday)){ echo "Birthday"; } else { echo $birthday;}  ?>" onkeydown="ClearSearch('settingsBday', 'Birthday');" onfocus="InitSearch('settingsBday', 'Birthday');" onblur="CheckForm('settingsBday', 'Birthday');"></td>
</tr>
<tr>
<td><textarea type="text" class="LoginClass" spellcheck="false" id="settingsBio" name="settingsBio" onkeydown="ClearSearch('settingsBio', 'Biography');" onfocus="InitSearch('settingsBio', 'Biography');" onblur="CheckForm('settingsBio', 'Biography');" style="overflow:hidden; resize:none; height:auto; width:300px; word-wrap:break-word;"><?php if(empty($bio)){ echo "Biography"; } else { echo $bio;}  ?></textarea></td>
</tr>
<div id="ImageDiv">
<?php if(!empty($image)){ 
echo '<img src="'.$image.'" height="250" width="250">';
}
?>
<br /><input type="file" class="LoginClass" id="settingsImage" name="settingsImage">
</div>
<tr>
<td><input type="submit" class="cbutton" id="settingsSubmit" name="settingsSubmit" value="Save settings"></td>
</tr>
</table>
</form>
</div>
<div id="RegisterErrors">
<?php if(isset($_SESSION['code_error'])){ echo $_SESSION['code_error']."<br />"; } unset($_SESSION['code_error']); ?>
</div>
<button id="RemoveProfile" class="cbutton" onclick="PromptAccept();">Remove profile</button>
<div id="AcceptRemove">
<span id="RemoveAsk">Are you sure you want to remove your account?</span><br />
<button id="RemoveYes" class="cbutton" onclick="YesRemove('<?php echo $author; ?>', '<?php echo $code; ?>', 0, 1)">Yes</button>
<button id="RemoveNo" class="cbutton" onclick="NoRemove();">No</button>
</div>