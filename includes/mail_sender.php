<?php


function sendMailToEmp($to,$from,$harware,$subject)
{

if($harware==1){$harware_name="DESKTOP";}
if($harware==2){$harware_name="LAPTOP";}
if($harware==3){$harware_name="PRINTER";}
if($harware==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>Request Rejected</title>
</head>

<body>
<table>
<tr><td colspan="2">Your Request for the Asset has been '.$subject.' :</td></tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>

</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);


$subject    = "Your Request for the Asset has been ".$subject;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($to,$subject,$body,$headers);


if(!$mail) {
    return 0;
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
  return 1;
}

}



function sendMailToHOD($from,$subject,$request_info)
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?happroved=1&request_id=".$request_info["requestID"];
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?happroved=0&request_id=".$request_info["requestID"];
if($request_info["HaveAssets"]==1) $have = "YES" ; else $have ="NO";
if($request_info["Executive"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($request_info["HardwareID"]==1){$harware_name="DESKTOP";}
if($request_info["HardwareID"]==2){$harware_name="LAPTOP";}
if($request_info["HardwareID"]==3){$harware_name="PRINTER";}
if($request_info["HardwareID"]==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Asset Request</title>
</head>

<body>
<table>
<tr><td colspan="2">New asset request received with following details:</td></tr>
<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$request_info["EmployeeID"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$request_info["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$request_info["department"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$request_info["designation"].'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$request_info["Reason"].'</td>
</tr>

<tr>
<td>Have Asstes?</td>
<td>'.$have.'</td>
</tr>

<tr>
<td>Type:</td>
<td>'.$type.'</td>
</tr>
<tr><td></td></tr>
<tr><td colspan="2"><strong>This Request has been approved by manager</strong></td></tr>
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);

$mail->Subject    = $subject;

$db = new cDB();
$getSql = $db->Query("SELECT * FROM `config_ldap` WHERE id=".$_SESSION["ldapid"]);
        //echo $getSql;
       if ($db->RowCount) {
			while ($db->ReadRow()) {
				$code = strtoupper($db->RowData['gmEmail']);
			}
$hod_mail = $code;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($hod_mail,$subject,$body, $headers);


if(!$mail) {
    return 0;
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
  return 1;
}

}





function sendMailToReceiver($to,$from,$subject,$request_info,$requestor_info)
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?reapproved=1&request_id=".$request_info["RequestID"];
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?reapproved=0&request_id=".$request_info["RequestID"];
if($request_info["HaveAssets"]==1) $have = "YES" ; else $have ="NO";
if($request_info["Executive"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($request_info["HardwareID"]==1){$harware_name="DESKTOP";}
if($request_info["HardwareID"]==2){$harware_name="LAPTOP";}
if($request_info["HardwareID"]==3){$harware_name="PRINTER";}
if($request_info["HardwareID"]==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Asset Request</title>
</head>

<body>
<table>
<tr><td colspan="2">New asset transfer request received with following details:</td></tr>
<tr>
    <td>Sender Employee ID/Usernmae:</td>
    <td>'.$requestor_info["empid"].'</td>
</tr>
<tr>
    <td>Sender Employee Name:</td>
    <td>'.$requestor_info["empname"].'</td>
</tr>
<tr>
    <td>Sender Employee Department:</td>
    <td>'.$requestor_info["department"].'</td>
</tr>
<tr>
    <td>Sender Employee Designation:</td>
    <td>'.$requestor_info["designation"].'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$request_info["TransferReason"].'</td>
</tr>

<tr><td></td></tr>
<tr><td colspan="2"><strong>This Request has been approved by '.$requestor_info["empname"].'s manager</strong></td></tr>
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);

$mail->Subject    = $subject;


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($to,$subject,$body, $headers);


if(!$mail) {
    return 0;
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
  return 1;
}

}

function sendMailToSecondManager($to,$from,$subject,$request_info,$requestor_details)//mail send to HOD with Transfer request having details of both employees 
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?smapproved=1&request_id=".$request_info["RequestID"];
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?smapproved=0&request_id=".$request_info["RequestID"];
if($request_info["HaveAssets"]==1) $have = "YES" ; else $have ="NO";
if($request_info["Executive"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($request_info["HardwareID"]==1){$harware_name="DESKTOP";}
if($request_info["HardwareID"]==2){$harware_name="LAPTOP";}
if($request_info["HardwareID"]==3){$harware_name="PRINTER";}
if($request_info["HardwareID"]==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Asset Request</title>
</head>

<body>
<table>
<tr><td colspan="2">New asset transfer request received with following details:</td></tr>
<tr><td colspan="2">-------------------------------------------------------------</td></tr>
<tr><td colspan="2"><strong>Requestor\'s Details:</strong></td></tr>
<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$requestor_details["empid"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$requestor_details["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$requestor_details["department"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$requestor_details["designation"].'</td>
</tr>
<tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2"><strong>Receiver\'s Details:</strong></td></tr>



<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$request_info["empid"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$request_info["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$request_info["department"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$request_info["designation"].'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$request_info["TransferReason"].'</td>
</tr>


<tr><td></td></tr>

<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body     = eregi_replace("[\]",'',$body);


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($to,$subject,$body, $headers);


if(!$mail) {
    return 0;
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
  return 1;
}

}



function sendMailToHOD2($from,$subject,$request_info,$requestor_details)//mail send to HOD with Transfer request having details of both employees 
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?happroved=1&request_id=".$request_info["RequestID"];
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?happroved=0&request_id=".$request_info["RequestID"];
if($request_info["HaveAssets"]==1) $have = "YES" ; else $have ="NO";
if($request_info["Executive"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($request_info["HardwareID"]==1){$harware_name="DESKTOP";}
if($request_info["HardwareID"]==2){$harware_name="LAPTOP";}
if($request_info["HardwareID"]==3){$harware_name="PRINTER";}
if($request_info["HardwareID"]==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Asset Request</title>
</head>

<body>
<table>
<tr><td colspan="2">New asset transfer request received with following details:</td></tr>
<tr><td colspan="2">-------------------------------------------------------------</td></tr>
<tr><td colspan="2"><strong>Requestor\'s Details:</strong></td></tr>
<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$requestor_details["empid"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$requestor_details["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$requestor_details["department"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$requestor_details["designation"].'</td>
</tr>
<tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2"><strong>Receiver\'s Details:</strong></td></tr>



<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$request_info["empid"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$request_info["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$request_info["department"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$request_info["designation"].'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$request_info["TransferReason"].'</td>
</tr>


<tr><td></td></tr>
<tr><td colspan="2"><strong>This Request has been approved by both employee\'s manager</strong></td></tr>
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);
$db = new cDB();
$getSql = $db->Query("SELECT * FROM `config_ldap` WHERE id=".$_SESSION["ldapid"]);
        //echo $getSql;
       if ($db->RowCount) {
			while ($db->ReadRow()) {
				$code = strtoupper($db->RowData['gmEmail']);
			}
$hod_mail = $code;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($hod_mail,$subject,$body, $headers);


if(!$mail) {
    return 0;
  //echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  //echo "Message sent!";
  return 1;
}

}
?>