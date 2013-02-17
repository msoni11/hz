<?php 
include '../includes/Application.php';
// function definition : New employee entry

function newip() {
	$start       = $_REQUEST['start'];
	$end   = $_REQUEST['end'];
    $admin = $_SESSION["ldapid"];
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
        }
	elseif ($start && $end ) {
		if (($start != '')   && ($end != '') ) {
		  
            if(filter_var($start, FILTER_VALIDATE_IP) && filter_var($end, FILTER_VALIDATE_IP) )
            {
               $startarr = explode(".",$start);
               $endarr = explode(".",$end);
               if($startarr[0]==$endarr[0] && $startarr[1]==$endarr[1] && $startarr[2]==$endarr[2] && $startarr[3]<= $endarr[3] )
               {
                        $sql = "INSERT INTO hz_ip_address(Address,LdapID) VALUES ";
                
                        for($i = $startarr[3];$i<=$endarr[3]; $i++)
                        {
                            $values.= " ('".$startarr[0].".".$startarr[1].".".$startarr[2].".".$i."','".$_SESSION["ldapid"]."') " ;
                            if($i!=$endarr[3])
                            {
                                $values.=" , ";
                            }
                        }
                        $sql = $sql.$values;              
                       
                        $db1 = new cDB();
         			    if($db1->Query($sql))
                        {
                            echo "0";
                            die();
                        }
                
                
               }
               else
               {
                echo "107"; //invalid ip range
                die();
               }
                
            }
            else
            {
                echo "106"; // Invalid ip format
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

function newlocation()
{
    $location = mysql_real_escape_string(trim(strtoupper($_REQUEST["location"])));
    if (!isset($_SESSION['username']))
         {
    		echo "101"; // Session expires! Login again
    		die;
         }
    elseif ($location)
        {
    		if (($location != ''))
             {
    		  $sql = "INSERT INTO hz_locations(LocationName,LdapID) VALUES('".$location."','".$_SESSION["ldapid"]."') ";
              $db1 = new cDB();
 			    if($db1->Query($sql))
                {
                    echo "0";
                    die();
                }
              
             }
             else {
    		echo "105"; // form field hasn't received by post
    		die();
    		}
          
          
        }
        else
        {
		echo "104"; //Internal update error
		die();
        }
		  
}


function newscrap()
{
    $hardware = mysql_real_escape_string(trim($_REQUEST["hardware"]));
    $make = mysql_real_escape_string(trim($_REQUEST["make"]));
    $model = mysql_real_escape_string(trim($_REQUEST["model"]));
    $serial = mysql_real_escape_string(trim($_REQUEST["serial"]));
    $reason = mysql_real_escape_string(trim($_REQUEST["reason"]));
    $approved = mysql_real_escape_string(trim($_REQUEST["approved"]));
    
     if (!isset($_SESSION['username']))
         {
    		echo "101"; // Session expires! Login again
    		die;
         }
    elseif ($hardware  && $serial  && $reason && $approved  )
        {
    		if (($hardware != ''  && $serial != '' && $reason != '' && $approved != '' ) )
             {
             	
    		  $sql = "INSERT INTO hz_scraps(HardwareID,ProductID,Reason,Apporved,LdapID) VALUES('".$hardware."','".$serial."','".$reason."','".$approved."','".$_SESSION["ldapid"]."') ";
              $db = new cDB();
    		  $db1 = new cDB();
    		  $db2 = new cDB();
    		  $db2->Query('SELECT * FROM hz_scraps WHERE ProductID='.$serial.' AND status IN(0,1) ORDER BY ScrapID Desc LIMIT 0,1');
    		  if ($db2->RowCount) {
    		  		echo "112"; //Eiter already scraped or in waiting
    		  } else {
    		  	$db2->Query("SELECT * FROM hz_registration WHERE (monitorno=".$serial." OR cpuno=".$serial.") AND activestatus='A'");
    		  	  if ($db2->RowCount) {
    		  		echo "113"; //Eiter already scraped or in waiting
	    		  } else {
	    		  	if($db1->Query($sql))
		                {
		                    $db->Query('SELECT gmEmail FROM config_ldap WHERE id='.$_SESSION['ldapid']);
		                	if ($db->RowCount) {
		                		if ($db->ReadRow()) {
				                    $sendmail = sendMailToHOD($db->RowData['gmEmail'],"New scrap added",$db1->LastInsertID);
				                    if ($sendmail) {
					                    echo "0"; //mail sent
					                    die();
				                    } else {
					                    echo "1"; //Mail not sent
					                    die();
				                    }
		                		} else {
		                			echo "111";//Email not found or session variable missing
		                		}
		                	}
		                }
	    		  }
    		  	
    		  }
	           } else {
	    		echo "105"; // form field hasn't received by post
	    		die();
	    		}
    		  }
        else
        {
		echo "104"; //Internal update error
		die();
        }
}


function sendMailToHOD($from,$subject,$scrapID)
{

$url = explode("/",$_SERVER["SCRIPT_NAME"]);

$approve_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/scrapResponse.php?gmScrapApproved=1&request_id=".$scrapID;
$reject_url = "http://".$_SERVER["SERVER_NAME"].$url[0]."/".$url[1]."/scrapResponse.php?gmScrapApproved=0&request_id=".$scrapID;
if($request_info["hardware"]==1){$harware_name="DESKTOP";}
if($request_info["hardware"]==2){$harware_name="LAPTOP";}
if($request_info["hardware"]==3){$harware_name="PRINTER";}
if($request_info["hardware"]==4){$harware_name="SCANNER";}
$db = new cDB();
$db->Query("SELECT name FROM hz_hardware WHERE id=".$_REQUEST['hardware']);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$hwname = $db->RowData['name'];
	}
}
$db->Query("SELECT name FROM hz_make WHERE id=".$_REQUEST['make']);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$make = $db->RowData['name'];
	}
}
$db->Query("SELECT modelname FROM hz_model WHERE id=".$_REQUEST['model']);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$model = $db->RowData['modelname'];
	}
}
$db->Query("SELECT serial FROM hz_products WHERE productID=".$_REQUEST['serial']);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$serial = $db->RowData['serial'];
	}
}

$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Scrap added</title>
</head>

<body>
<table>
<tr><td colspan="2">Waiting For Your Approval </td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td colspan="2">IT Team Wants to Scrap This Hardware Following Details Are:-</td></tr>
<tr>
    <td>Hardware :</td>
    <td>'.$hwname.'</td>
</tr>
<tr>
    <td>Make :</td>
    <td>'.$make.'</td>
</tr>
<tr>
    <td>Model :</td>
    <td>'.$model.'</td>
</tr>
<tr>
    <td>Hardware :</td>
    <td>'.$serial.'</td>
</tr>


<tr>
    <td>Reason:</td>
    <td>'.$_REQUEST["reason"].'</td>
</tr>
<tr>
	<td>For Apporvel:</td>
	<td>'.$_REQUEST["approved"].'</td>
</tr>
<tr><td></td><td><a href="'.$approve_url.'">Approve</a>&nbsp;&nbsp;<a href="'.$reject_url.'">Reject</a></td></tr>
<tr><td></td></tr>

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
}

if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'addips':
		newip();
		break;
        
        case 'addlocation':
		newlocation();
		break;

        case 'newscrap':
		newscrap();
		break;


		default:
		echo "404";
	}
}
?>