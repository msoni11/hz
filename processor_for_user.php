<?php 
include 'includes/Application.php';
// function definition : New employee entry

function newrequest() {
	$empid       = $_REQUEST['empid'];
	$emp_name    = $_REQUEST['empname'];
    $emp_dept  = $_REQUEST['empdept'];
    $emp_desi  = $_REQUEST['empdesi'];
    $hardware    = $_REQUEST["hardware"];
    $reason      = $_REQUEST["reason"];
    $have       =  $_REQUEST["have_assets"];
    $type       =  $_REQUEST["type"];
    $manager     =  $_REQUEST["manager"]  ;
	
	//if (!isset($_SESSION['username'])) {
		//echo "101"; // Session expires! Login again
		//die;
	if (isset($empid)  && isset($hardware) && isset($reason) && isset($have) && isset($type) ) {
		if (($empid != '')   && ($hardware != '') && ($reason != '') && ($have != '') && ($type != '') ) {
			$db1 = new cDB();
			$sql = "INSERT INTO hz_asset_requests(EmployeeID,HardwareID,Reason,HaveAssets,Executive,ManagerUsername,Status) 
						VALUES('".$empid."','".$hardware."','".$reason."','".$have."','".$type."','".$manager."',0)";
			$db1->Query($sql);
            $new =$db1->LastInsertID;
				if ($new) {
			              $mail_sent =  sendMangerMail($manager,"New Asset Request",$empid,$emp_name,$emp_dept,$emp_desi,$new);  
                          if($mail_sent)
                          {
                            echo "1";
                            die();
                          }
                          else
                          {
    					echo "0"; //status true.Show success message
    					die();
                          }
				} else {
					echo "103"; //status false. Error inserting into database.
					die();
				}
			
		} else {
		echo "105"; // form field hasn't received by post
		die();
		}
	} else {
		echo "104"; //Internal update error
		die();
	}
}

function newTrequest() {
	$empid       = $_REQUEST['empid'];
    $emp_name    = $_REQUEST['empname'];
    $emp_dept    = $_REQUEST['empdept'];
    $emp_desi    = $_REQUEST['empdesi'];
	$hardware    = $_REQUEST["hardware"];
    $reason      = $_REQUEST["reason"];
    $serial      = $_REQUEST["serial"];
    $email       = $_REQUEST["email"];
    $manager     = $_REQUEST["manager"]  ;
    $requestor   = $_REQUEST["requestor"]  ;
    
    $rmanagermail= $_REQUEST["rmanagermail"];
    
	
    if (isset($empid)  && isset($hardware) && isset($reason) && isset($serial) && isset($email) ) {
		if (($empid != '')   && ($hardware != '') && ($reason != '') && ($serial != '') && ($email != '') ) {
			$db1 = new cDB();
			$sql = "INSERT INTO hz_transfer_requests(RequestorID,EmployeeID,HardwareID,TransferReason,ProductID,Email,ReceiversManagerMail,Status) 
						VALUES('".$requestor."','".$empid."','".$hardware."','".$reason."','".$serial."','".$email."','".$rmanagermail."',0)";
			$db1->Query($sql);
            $new =$db1->LastInsertID;
			if ($new) {
			              $mail_sent= sendRequestorMail($manager,"Adminstrator@hz.com","New Asset Transfer Request",$empid,$emp_name,$emp_dept,$emp_desi,$new);  
                          if($mail_sent)
                          {
                            echo "1";
                            die();
                          }
                          else
                          {
    					echo "0"; //status true.Show success message
    					die();
                          }
				} else {
					echo "103"; //status false. Error inserting into database.
					die();
				}
			
		} else {
		echo "105"; // form field hasn't received by post
		die();
		}
	} else {
		echo "104"; //Internal update error
		die();
	}
}



// Get cpu serials numbers
function getserials() {
    $username = ($_SESSION["username"]) ? $_SESSION["username"] : "777777";
    $hardware_id = $_REQUEST["hardware"];
    if($hardware_id && $username)
    {//echo "SELECT * FROM hz_products WHERE productID	 IN (SELECT cpuno FROM `hz_registration` WHERE `hardware`=$hardware_id AND `empid`='".$username."' )";
       $db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT * FROM hz_products WHERE productID	 IN (SELECT cpuno FROM `hz_registration` WHERE `hardware`=$hardware_id AND `empid`='".$username."' )");
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['productID']] = strtoupper($db->RowData['serial']);
			}
			echo json_encode($resultarr);
		} else {
			echo "102"; // id doesn't exist
		}
    }
	
}

// Get employee details
function get_user_details() {
	$id = $_REQUEST['reggetempid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($id) && $id != '') {
		if (isset($_SESSION['ldapid'])) {
	 		$db = new cDB();
			$option = getLdapOU($_SESSION['ldapid']);
			$resultarr = array();
			if (is_array($option) && !empty($option)) {
				for($i=0;$i<count($option);$i++) {
					$adldap = initializeLDAP($option[$i]);
					$detail = $adldap->user()->info($id, array("description","name","department","title","mail","manager"));
					if (!empty($detail)) {
						break;
					}
				}
			}
			if (!empty($detail)) {
				$detail['manager'] = $adldap->contact()->info($detail[0]['manager'][0]);
				$resultarr['empiddesc'] = $detail[0]['description'][0];
				$resultarr['empname'] = $detail[0]['name'][0];
				$resultarr['department'] = $detail[0]['department'][0];
				$resultarr['designation'] = $detail[0]['title'][0];
				$resultarr['empmail'] = $detail[0]['mail'][0];
				$resultarr['mgrmail'] = $detail['manager'][0]['mail'][0];

				echo json_encode($resultarr);
			} else {
				echo "103"; //some error reading from database
			}
		} else {
			echo "109"; // ldapid variable not assigned ! failure
			die;
		}
	} else {
		echo "105";
		die();
	}
}

function sendMangerMail($to,$subject,$empid,$emp_name,$emp_dept,$emp_desi,$new)
{
$url = explode("/",$_SERVER["SCRIPT_NAME"]);
$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?mapproved=1&request_id=".$new;
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/response.php?mapproved=0&request_id=".$new;
if($_REQUEST["have_assets"]==1) $have = "YES" ; else $have ="NO";
if($_REQUEST["type"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($_REQUEST["hardware"]==1){$harware_name="DESKTOP";}
if($_REQUEST["hardware"]==2){$harware_name="LAPTOP";}
if($_REQUEST["hardware"]==3){$harware_name="PRINTER";}
if($_REQUEST["hardware"]==4){$harware_name="SCANNER";}

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
    <td>'.$empid.'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$emp_name.'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$emp_dept.'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$emp_desi.'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$_REQUEST["reason"].'</td>
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
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Webmaster <Webmaster@hz.com>' . "\r\n";
$mail = mail($to,$subject,$body,$headers);
if(!$mail) {
    return 0;
  
} else {
  
  return 1;
}

}

function sendRequestorMail($to,$from,$subject,$empid,$emp_name,$emp_dept,$emp_desi,$new)
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?happroved=1&request_id=".$new;
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/tresponse.php?happroved=0&request_id=".$new;
if($_REQUEST["have_assets"]==1) $have = "YES" ; else $have ="NO";
if($_REQUEST["type"]==1) $type = "EXECUTIVE" ; else $type ="NON-EXECUTIVE";

if($_REQUEST["hardware"]==1){$harware_name="DESKTOP";}
if($_REQUEST["hardware"]==2){$harware_name="LAPTOP";}
if($_REQUEST["hardware"]==3){$harware_name="PRINTER";}
if($_REQUEST["hardware"]==4){$harware_name="SCANNER";}

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
    <td>'.$_REQUEST["requestor"].'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$_REQUEST["requestorname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$_REQUEST["requestordept"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$_REQUEST["requestordesi"].'</td>
</tr>
<tr>
<tr><td colspan="2"></td></tr>
<tr><td colspan="2"><strong>Receiver\'s Details:</strong></td></tr>



<tr>
    <td>Employee ID/Usernmae:</td>
    <td>'.$empid.'</td>
</tr>
<tr>
    <td>Employee Name:</td>
    <td>'.$_REQUEST["empname"].'</td>
</tr>
<tr>
    <td>Employee Department:</td>
    <td>'.$_REQUEST["empdept"].'</td>
</tr>
<tr>
    <td>Employee Designation:</td>
    <td>'.$_REQUEST["empdesi"].'</td>
</tr>
<tr>
    <td>Hardware:</td>
    <td>'.$harware_name.'</td>
</tr>
<tr>
<td>Reason/Purpose:</td>
<td>'.$_REQUEST["reason"].'</td>
</tr>


<tr><td></td></tr>
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
</table>
<br /><br /><br />
<p>Regards,</p>
<p>Inventory System</p>

</body>
</html>';
$body             = eregi_replace("[\]",'',$body);

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








if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'newrequest':
		newrequest();
		break;
        
        case 'newtrequest':
		newTrequest();
		break;
		
	// serials
        case 'getserials':
		getserials();
		break;
        
        case 'getuserinfo':
		get_user_details();
		break;
        
        

		default:
		echo "404";
	}
}
?>