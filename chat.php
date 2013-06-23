<?php
$uid = "2506";
?>
<html>
<head>
<style type="text/css">
.UserLink:hover{
background-color:blue;
cursor:pointer;
}
</style>
<script type="text/javascript">
var uid;
function SendMessage(){
	var msg = document.getElementById('ChatSender').value;
	var xmlhttp; // Creat the ajax var
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    
	document.getElementById('ChatSender').value="";
    }
  }
xmlhttp.open("GET","send_message.inc.php?user_id="+uid+"&msg="+msg,true); // open the connection
xmlhttp.send();
}
function GetUserList(){
var xmlhttpa;
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpa=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttpa=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttpa.onreadystatechange=function()
  {
  if (xmlhttpa.readyState==4 && xmlhttpa.status==200)
    {
    document.getElementById('UserList').innerHTML=xmlhttpa.responseText;
    }
  }
xmlhttpa.open("GET","get_user_online_list.inc.php",true); // open the connection
xmlhttpa.send();
}

function LoadUser(id){
uid = id;
}

function GetChatText(){
var xmlhttpb;
if (window.XMLHttpRequest) 
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttpb=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttpb=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttpb.onreadystatechange=function()
  {
  if (xmlhttpb.readyState==4 && xmlhttpb.status==200)
    {
    document.getElementById('ChatReceiver').innerHTML=xmlhttpb.responseText;
    }
  }
xmlhttpb.open("GET","get_messages.inc.php",true); // open the connection
xmlhttpb.send();
}
setInterval(GetChatText, 1000);
setInterval(GetUserList, 1000);
</script>
</head>
<body onload="GetUserList();">
<ul id="UserList"></ul>
<div id="ChatReceiver"></div><br />
<textarea type="text" id="ChatSender" spellcheck="false" name="ChatSender"></textarea><br />
<button id="ChatSubmit" name="ChatSubmit" onclick="SendMessage();">Send message</button>
</body>
</html>