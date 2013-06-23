<?php
	$date = date("d-m-Y");
    $myFile = "forbidden/log/requests-$date.log";
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, "\n\n-------------".$_SERVER['REMOTE_ADDR']."----------------".date('d-m-Y H:i:s')."-------------------\n");
    foreach($_SERVER as $h=>$v)
        if(preg_match('/HTTP_(.+)/',$h,$hp))
            fwrite($fh, "$h = $v\n");
    fwrite($fh, "\r\n");
    fwrite($fh, file_get_contents('php://input'));
    fclose($fh);
   
?>