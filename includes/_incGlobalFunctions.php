<?php
function HandleError( $theError = "") {
	global $appErrorPage;
	echo $theError;
	die();
}

/**
 * 
 * TO get all OU defined in our database
 * @param int $IDorUserID Either admin id OR ldap_config id
 * @param bool $isadmnin
 * 
 * @return array of object
 */
/*function getLdapOU($IDorUserID, $isadmnin=false) {
	if (empty($IDorUserID)) {
	    die('Error Calling function getLdapOU(), $id can\'t be empty');
	}
	$options = array();
	$db = new cDB();
	if ($isadmnin) {
	    //$IDorUserID is admin id
	    $sql = 'SELECT cl.* FROM hz_users hu 
	    			LEFT OUTER JOIN hz_admin_allowed_location hal ON hu.id = hal.adminID
	    			LEFT OUTER JOIN hz_config_ldap hcl ON hcl.id = hal.ldapID
	    		WHERE hu.id='.$IDorUserID;
		$db->Query($sql);
		if($db->RowCount) {
			while($db->ReadRow()) {
				$options[] = array(
					'domain_controllers' => array(
						$db->RowData['hostUrl']
					),
					'account_suffix'=>$db->RowData['accountSuffix'],
					'base_dn'=>$db->RowData['baseDN'],
					'admin_username' => $db->RowData['userName'],
					'admin_password' => $db->RowData['password'],
				);
			}
		} else {
			return false;
		}
	} else {
	    //$IDorUserID is config_ldap id
		$sql = 'SELECT * FROM config_ldap WHERE id='.$IDorUserID;
		$db->Query($sql);
		if($db->RowCount) {
			while($db->ReadRow()) {
				$options[$db->RowData['id']] = array(
					'domain_controllers' => array(
						$db->RowData['hostUrl']
					),
					'account_suffix'=>$db->RowData['accountSuffix'],
					'base_dn'=>$db->RowData['baseDN'],
					'admin_username' => $db->RowData['userName'],
					'admin_password' => $db->RowData['password'],
				);
			}
		} else {
			return false;
		}
	}
	
	return $options;
}*/

/**
 * 
 * TO get all OU defined in our database
 * @param int $IDorUserID Either admin id OR ldap_config id
 * 
 * @return array of object
 */
function getLdapOU($IDorUserID) {
	if (empty($IDorUserID)) {
	    die('Error Calling function getLdapOU(), $id can\'t be empty');
	}
	$options = array();
	$db = new cDB();
    //$IDorUserID is config_ldap id
	$sql = 'SELECT * FROM config_ldap WHERE id='.$IDorUserID;
	$db->Query($sql);
	if($db->RowCount) {
		while($db->ReadRow()) {
			$contexts = explode(';', $db->RowData['contexts']);
			for($i=0;$i<count($contexts);$i++) {
				$options[] = array(
					'domain_controllers' => array(
						$db->RowData['hostUrl']
					),
					'account_suffix'=>$db->RowData['accountSuffix'],
					'base_dn'=>$contexts[$i],
					'admin_username' => $db->RowData['userName'],
					'admin_password' => $db->RowData['password'],
				);
			}
		}
	} else {
		return false;
	}
	return $options;
}

/**
 * 
 * Initialize adldap class
 * @param array $options
 * 
 * @return stdClass object
 */
function initializeLDAP($options) {
	if(is_array($options))
	return $adldap = new adLDAP($options);
}

?>