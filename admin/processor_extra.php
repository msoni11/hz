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


if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'addips':
		newip();
		break;
        
        case 'addlocation':
		newlocation();
		break;


		default:
		echo "404";
	}
}
?>