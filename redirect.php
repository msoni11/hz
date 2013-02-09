<?php 
// Authnticate user login
include 'includes/Application.php';
$db = new cDB();
$options = array();
$cfgDB = new cDB();

$_SESSION['status'] = array();
if (isset($_POST['txtsubmit'])) {
    $txtusername = strtolower($_POST['txtusername']);
    $txtpassword = $_POST['txtpassword'];
    $isadmin     = $_POST['txtusertype'];

    if (empty($txtusername) || empty($txtpassword)) {
        $_SESSION['status'][] = 'All fields are required';
    }
//Check for anonymous/admin.
    if (isset($isadmin) && strtolower($isadmin) == 'anuser') {
		//This check is for anonymous user.
		$usertype = 0; //Active directory check
		$cfgDB->Query('SELECT * FROM config_ldap');
		if ($cfgDB->RowCount) {
			while ($cfgDB->ReadRow()) {
				$options[] = array(
					'domain_controllers' => array(
						$cfgDB->RowData['hostUrl']
					),
					'account_suffix'=>$cfgDB->RowData['accountSuffix'],
					'base_dn'=>$cfgDB->RowData['baseDN'],
					'admin_username' => $cfgDB->RowData['userName'],
					'admin_password' => $cfgDB->RowData['password'],
				);
			}
		}
	} else {
		$usertype = 1; //admin check
		$cfgDB->Query('SELECT * FROM config_ldap WHERE id='.$isadmin);
		if ($cfgDB->RowCount) {
			while ($cfgDB->ReadRow()) {
				$options[] = array(
					'domain_controllers' => array(
						$cfgDB->RowData['hostUrl']
					),
					'account_suffix'=>$cfgDB->RowData['accountSuffix'],
					'base_dn'=>$cfgDB->RowData['baseDN'],
					'admin_username' => $cfgDB->RowData['userName'],
					'admin_password' => $cfgDB->RowData['password'],
				);
			}
		}
		
		if (count($options) !== 1) {
			$_SESSION['status'][] = 'We could not authorize admin for multiple OU';
			header("Location:index.php");
		}
	}
	
	if (empty($_SESSION['status'])) {
		//login with AD
		if ($usertype === 0) {
			if ($ldap) {
				foreach ($options as $option) {
					try {
						$adldap = new adLDAP($options);
					}
					catch (adLDAPException $e) {
						$_SESSION['status'][] = 'One of your ldap settings is not configured properly';
						header("Location:index.php");
					}
				}
				if ($adldap->user()->authenticate($txtusername, $txtpassword)) {
					$userdetail = array();
					$_SESSION['username']   = $txtusername;
					$_SESSION['isadmin']    = 0;
					$userdetail = $adldap->user()->info($txtusername, array("description","name","department","title","cn","sn","company","physicaldeliveryofficename","mail","manager"));
					$userdetail['managermail'] = $adldap->contact()->info($userdetail[0]['manager'][0], array('mail'));
					$_SESSION['adldapinfo'] = $userdetail;
					header("Location:user_home.php");
				} else {
					$_SESSION['status'][] = 'User doesn\'t exist! Enter valid username & password';
					header("Location:index.php");
				}
			} else {
					$userdetail = array();
					$_SESSION['username']   = $txtusername;
					$_SESSION['isadmin']    = 0;
					header("Location:user_home.php");
				//$_SESSION['status'][] = 'Set ldap to true in application';
				//header("Location:index.php");
			}
		} else {
			$query = "SELECT * FROM hz_users WHERE username='".$txtusername."' AND password='".$txtpassword."' AND isadmin='1' AND ldapID=".$usertype;
			$db->Query($query);
			if ($db->RowCount) {
				if ($db->ReadRow()) {
					if ($db->RowData['password'] === $txtpassword) {
						if ($usertype == 1) {
								try {
									$adldap = new adLDAP($options[0]);
								}
								catch (adLDAPException $e) {
									$_SESSION['status'][] = 'One of your ldap settings is not configured properly';
									header("Location:index.php");
								}
							$_SESSION['username'] = $txtusername;
							$_SESSION['isadmin']  = $db->RowData['isadmin'];
							header("Location:admin/admin_home.php");
						}
					} else {
						$_SESSION['status'][] = 'User doesn\'t exist! Enter valid username & password';
						header("Location:index.php");
					}
				} 
			} else {
				$_SESSION['status'][] = 'User doesn\'t exist! Enter valid username & password';
				header("Location:index.php");
			}
		}
    } else {
		header("Location:index.php");
    }
}

?>