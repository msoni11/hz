<?php 
include 'includes/Application.php';

// Get serials numbers
/*function save_settings() {
    
       $db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT * FROM config");
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['name']] = $db->RowData['value'];
			}
	
        }
        
        
        foreach($_REQUEST as $var=> $val)//extracting only  form fileds from $_REQUEST 
        {
           if($var=='hosturl'  || $var=='version' || $var=='ldapencoding' || $var=='accountsuffix' || $var=='basedn' || $var=='adminusername' || $var=='password' || $var=='usertype' || $var=='contexts')
            {
             $form_fields[$var] = $val;   
            }    
        }
        	
    	$to_insert = array_diff_key($form_fields,$resultarr);//getting only those values who are not present in database
        
        //echo "<pre>";
//        print_r($_REQUEST);
//        print_r($form_fields);
//        print_r($resultarr);
//        print_r($to_insert);
//        
//       echo "</pre>";
        if(count($to_insert)>0)
        {
            $insert_sql="INSERT INTO config(name,value) VALUES ";
            $c=0;
            foreach($to_insert as $var=>$val)
            {
                
                $insert_sql.="('".mysql_real_escape_string(trim($var))."','".mysql_real_escape_string(trim($val))."')";
                if($c!=(count($to_insert)-1))
                {
                    $insert_sql.= ",";
                }
                 $c++;
            }
         $insert_status = $db->Query($insert_sql);   
         }
        
        
        $to_update = array_diff_key($form_fields,$to_insert);
        if(count($to_update)>0)
        {
            
            $update_status=0;
            foreach($to_update as $var=>$val)
            {
                $update_sql="UPDATE config SET value = '".mysql_real_escape_string(trim($val))."' WHERE name='".mysql_real_escape_string(trim($var))."'";
                $update_status += $db->Query($update_sql);
            }
        
        }
        
        if($insert_status && $update_status)
        {
            echo "0";
            die();
        }
        if($insert_status)
        {
            echo "1";
            die();
        }
        if($update_status)
        {
            echo "2";
        }
        
        
	
}*/

function newLdapEntry() {
	$hosturl       = trim($_REQUEST['hosturl']);
	$version       = (int)$_REQUEST['version'];
	$ldapencoding  = trim($_REQUEST['ldapencoding']);
	$accountsuffix = trim($_REQUEST['accountsuffix']);
	$basedn        = trim($_REQUEST['basedn']);
	$adminusername = trim($_REQUEST['adminusername']);
	$password      = $_REQUEST['password'];
	$location      = trim($_REQUEST['location']);
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($hosturl) && isset($version) && isset($ldapencoding) && isset($accountsuffix) && isset($basedn) && isset($adminusername) && isset($password) && isset($location)) {
		if (($hosturl != '') && ($version != '') && (is_numeric($version)) && ($ldapencoding != '') && ($accountsuffix != '') && ($basedn != '') && ($adminusername != '') && ($password != '') && ($location != '')) {
			$db = new cDB();
			$db1 = new cDB();
			$sql = "INSERT INTO config_ldap(hostUrl,version,ldapEncoding,accountSuffix,baseDN,userName,password,location) 
					VALUES('".$hosturl."','".$version."','".$ldapencoding."','".$accountsuffix."','".$basedn."','".$adminusername."','".$password."','".$location."')";
			$db1->Query($sql);
			if ($db1->LastInsertID) {
				echo "0"; //status true.Show success message
				die();
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

// function definition : New admin entry
function newuser() {
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($_REQUEST['uname']) && isset($_REQUEST['password']) && isset($_REQUEST['location'])) {
		$db = new cDB();
		$db1 = new cDB();
		$uname = $_REQUEST['uname'];
		$password = $_REQUEST['password'];
		$usertype = $_REQUEST['location'];
		if (($uname != '') && ($password != '') && ($usertype != '')) {
			$sqlselect = "SELECT * FROM hz_users WHERE username='".$uname."'";
			$db->Query($sqlselect);
			if ($db->RowCount) {
				echo "102"; //User already exists;
				die();
			} else {
				$sql = "INSERT INTO hz_users(username,password,isadmin) 
						VALUES('".$uname."','".$password."','1')";
				$db->Query($sql);
				if ($adminid = $db->LastInsertID) {
					$locations = explode(',', $usertype);
					foreach ($locations as $location) {
						$sql = "INSERT INTO hz_admin_allowed_location(adminID,ldapID) 
								VALUES('".$adminid."',".$location.")";
						$db1->Query($sql);
						if (!$db1->LastInsertID) {
							$deleteSql = 'DELETE FROM hz_users WHERE id ='.$adminid;
							$db1->Query($sql);
							$deleteSql = 'DELETE FROM hz_admin_allowed_location WHERE adminID ='.$adminid;
							$db1->Query($deleteSql);
							echo "103"; //status false. Error inserting into database.
							exit();
						}
						
					}
					echo "0"; //status true.Show success message
					die();
				} else {
					echo "103"; //status false. Error inserting into database.
					die();
				}
			}
		} else {
			echo "105"; // form field hasn't received by post
			die();
		}
	} else {
		echo "104";//Internal update error
		die();
	}
}


if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'saveconfig':
		save_settings();
		break;
		
		case 'newLdapEntry':
		newLdapEntry();
		break;
		
		case 'newuser':
		newuser();
		break;
		
		default:
		echo "404";
	}
}
?>
