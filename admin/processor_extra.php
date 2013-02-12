<?php 
include 'includes/Application.php';
// function definition : New employee entry

function newip() {
	$start       = $_REQUEST['start'];
	$end   = $_REQUEST['end'];
    
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
        }
	elseif (isset($start)  && isset($end) ) {
		if (($start != '')   && ($end != '') ) {
		  
            if(filter_var($start, FILTER_VALIDATE_IP) && filter_var($end, FILTER_VALIDATE_IP) )
            {
               $startarr = explode(".",$start);
               $endarr = explode(".",$end);
               if($startarr[0]==$endarr[0] && $startarr[1]==$endarr[1] && $startarr[0]==$endarr[0])
               {
                $db1 = new cDB();
    			$sql = "INSERT INTO hz_ip_address(address) 
    						VALUES('".$empid."','".$hardware."','".$reason."','".$have."','".$type."','".$manager."',0)";
    			$db1->Query($sql);
                $new =$db1->LastInsertID;
                
               }
                
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


if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'addips':
		newip();
		break;
        

		default:
		echo "404";
	}
}
?>