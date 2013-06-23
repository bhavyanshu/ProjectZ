<?php
include('log.php');
include('captcha.php');
$array = getCaptcha();
$captcha_img = $array['img'];
$captcha_txt = $array['txt'];
$captcha_atxt = $array['atxt'];
$_SESSION['captcha_txt'] = $captcha_txt;
$_SESSION['captcha_atxt'] = $captcha_atxt;

?>
<html>
<head>
</head>
<body onload="AnimateClouds();">
<div id="RegisterBackground"></div>
<div id="RegisterDecoration">
<div id="CloudTranslucent"></div>

<div id="CloudsRegister"></div>
</div>
<div id="RegisterContainer">
<div id="DivRegister">
<span id="HeadRegister">No account yet? Register now!</span>
<div id="Translucent"></div>
<form id="FrmRegister" action="do_register.php" method="post" enctype="multipart/form-data">
<table id="TblRegister" border="0">
<tr>
<td><label for="RegisterName"></label><input type="text" class="LoginClass" spellcheck="false" name="RegisterName" id="RegisterName" value="<?php if(!empty($regname)){ echo $regname; } else { echo 'Name'; } ?>" onkeydown="ClearSearch('RegisterName', 'Name');" onfocus="InitSearch('RegisterName', 'Name');" onblur="CheckRegisterUsername();"></td>
</tr>
<tr>
<td><label for="RegisterPassword"></label><input type="text" class="LoginClass" spellcheck="false" name="RegisterPassword" id="RegisterPassword" value="Password" onkeydown="ClearSearch('RegisterPassword', 'Password');" onfocus="InitSearch('RegisterPassword', 'Password'); ChangeToPassword('RegisterPassword');" onblur="CheckRegisterPassword();  ChangeToNormal('RegisterPassword', 'Password');"></td>
</tr>
<tr>
<td><label for="RegisterPasswordRe"></label><input type="text" class="LoginClass" spellcheck="false" name="RegisterPasswordRe" id="RegisterPasswordRe" value="Retype Password" onkeydown="ClearSearch('RegisterPasswordRe', 'Retype Password');" onfocus="InitSearch('RegisterPasswordRe', 'Retype Password'); ChangeToPassword('RegisterPasswordRe');" onblur="CheckRegisterPasswordRe();  ChangeToNormal('RegisterPasswordRe', 'Retype Password');"></td>
</tr>
<tr>
<td><label for="RegisterMail"></label><input type="text" class="LoginClass" spellcheck="false" name="RegisterMail" id="RegisterMail" value="<?php if(!empty($regmail)){ echo $regmail; } else { echo 'Email'; } ?>" onkeydown="ClearSearch('RegisterMail', 'Email');" onfocus="InitSearch('RegisterMail', 'Email');" onblur="CheckRegisterMail();"></td>
</tr>
<tr>
<td><input type="file" class="LoginClass" name="RegisterImage" id="RegisterImage"><label id="LblRegisterImage" for="RegisterImage"></label></td>
</tr>
<tr>
<td><img name="CaptchaImage" id="CaptchaImage" src="<?php echo $captcha_img; ?>" width="300" height="300" /><td>
</tr>
<tr>
<td><input type="text" class="LoginClass" name="CaptchaText" id="CaptchaText" spellcheck="false" value="Who is the person on the image?" onkeydown="ClearSearch('CaptchaText', 'Who is the person on the image?');" onfocus="InitSearch('CaptchaText', 'Who is the person on the image?');" onblur="CheckForm('CaptchaText', 'Who is the person on the image?');"></td><td><button id="BtnNewImage" class="cbutton" title="Get another image" onclick="LoadNewCaptcha(); return false;"><img title="Get another image" src="image/refresh.ico" width="20" height="25"></button></td>
</tr>
<tr>
<td><input type="submit" class="cbutton" name="RegisterSubmit" id="RegisterSubmit" value="Register"></td>
</tr>
</table>
</form>
</div>
<div id="RegisterErrors">
<?php if(isset($_SESSION['username_used'])){ echo $_SESSION['username_used']."<br />"; } if(isset($_SESSION['password_mismatch'])){ echo $_SESSION['password_mismatch']."<br />"; } if(isset($_SESSION['captcha_wrong'])){ echo $_SESSION['captcha_wrong']."<br />"; } if(isset($_SESSION['fill_error'])){ echo $_SESSION['fill_error']."<br />"; } unset($_SESSION['fill_error']); unset($_SESSION['username_used']); unset($_SESSION['captcha_wrong']); unset($_SESSION['password_mismatch']); ?>
</div>
</div>

</body>
</html>