<?php
function myMail($mailto, $from_mail, $from_name, $subject, $message) {
    
    $uid = md5(uniqid(time()));
   
    $header = "From: ".$from_name." <".$from_mail.">\r\n";
    //$header .= "Reply-To: ".$replyto."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
   if (mail($mailto, $subject, "", $header)) {
        return true; // or use booleans here
    } else {
        return false;
    }
}


myMail("him.developer@gmail.com","Admin","Webmaster","Subject","Message")
?>