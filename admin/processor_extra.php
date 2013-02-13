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
    $location = mysql_real_escape_string(trim($_REQUEST["location"]));
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
    
     if (isset($_SESSION['username']))
         {
    		echo "101"; // Session expires! Login again
    		die;
         }
    elseif ($hardware  && $serial  && $reason && $approved  )
        {
    		if (($hardware != ''  && $serial != '' && $reason != '' && $approved != '' ) )
             {
    		  $sql = "INSERT INTO hz_scraps(HardwareID,ProductID,Reason,Apporved,LdapID) VALUES('".$hardware."','".$serial."','".$reason."','".$approved."','".$_SESSION["ldapid"]."') ";
              $db1 = new cDB();
 			    if($db1->Query($sql))
                {
                    sendMailToHOD("Admin@hz.com","New scrap added");
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


function sendMailToHOD($from,$subject)
{


if($request_info["hardware"]==1){$harware_name="DESKTOP";}
if($request_info["hardware"]==2){$harware_name="LAPTOP";}
if($request_info["hardware"]==3){$harware_name="PRINTER";}
if($request_info["hardware"]==4){$harware_name="SCANNER";}
$body ='<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="" />

	<title>New Scrap added</title>
</head>

<body>
<table>
<tr><td colspan="2">Hardware has been added to scrap with following details:</td></tr>
<tr>
    <td>Hardware :</td>
    <td>'.$harware_name.'</td>
</tr>

<tr>
    <td>Reason:</td>
    <td>'.$_REQUEST["reason"].'</td>
</tr>
<tr>
<td>Apporved By:</td>
<td>'.$_REQUEST["approved"].'</td>
</tr>
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