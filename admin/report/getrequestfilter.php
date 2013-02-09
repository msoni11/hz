<?php 
include '../../includes/Application.php';
// Get make details
function getemake() {
	$hw_id = $_REQUEST['hardwareid'];
	if (isset($hw_id) && $hw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$db->Query("SELECT * FROM hz_hardware WHERE name='".$hw_id."'");
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$hw_id = $db->RowData['id'];
				$getSql = $db->Query("SELECT hm.id, hm.name FROM hz_make hm LEFT OUTER JOIN hz_hardware hh ON (hm.hw_id = hh.id) WHERE hw_id=".$hw_id);
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						$resultarr[$db->RowData['name']] = $db->RowData['name'];
					}
					echo json_encode($resultarr);
				} else {
				echo "102"; // id doesn't exist
				}
			}
		}
	}
}

// Get model details
function getemodel() {
	$make_id = $_REQUEST['makeid'];
	$hw_id = $_REQUEST['hwid'];
	if (isset($make_id) && $make_id != '') {
		$db = new cDB();
		$resultarr = array();
		$db->Query("SELECT * FROM hz_hardware WHERE name='".$hw_id."'");
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$hwid = $db->RowData['id'];
				//echo "SELECT * FROM hz_make WHERE hw_id=".$hwid." AND name='".$make_id."'";
				$db->Query("SELECT * FROM hz_make WHERE hw_id=".$hwid." AND name='".$make_id."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$make_id = $db->RowData['id'];
						$getSql = $db->Query("SELECT hmd.id, hmd.modelname FROM hz_model hmd LEFT OUTER JOIN hz_make hm ON (hmd.make_id = hm.id) WHERE make_id=".$make_id);
						if ($db->RowCount) {
							while ($db->ReadRow()) {
								$resultmodel['model'][$db->RowData['modelname']] = $db->RowData['modelname'];
							}
							//echo json_encode($resultmodel);
						}
					}
				}
			}
		}

		$db1 = new cDB();
		$getSql = $db1->Query("SELECT hmc.id, hmc.config FROM hz_configuration hmc LEFT OUTER JOIN hz_make hm ON (hmc.make_id = hm.id) WHERE make_id=".$make_id);
		if ($db1->RowCount) {
			while ($db1->ReadRow()) {
				$resultmodel['config'][$db1->RowData['id']] = $db1->RowData['config'];
			}
		}
		echo json_encode($resultmodel);
	}
}

// Get printer type
function geteprintertype() {
	$hw_id = $_REQUEST['hardwareid'];
	if (isset($hw_id) && $hw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$db->Query("SELECT * FROM hz_hardware WHERE name='".$hw_id."'");
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$hw_id = $db->RowData['id'];
				$getSql = $db->Query("SELECT hp.id, hp.printertype FROM hz_printertype hp LEFT OUTER JOIN hz_hardware hh ON (hp.hw_id = hh.id) WHERE hw_id=".$hw_id);
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						$resultarr[$db->RowData['printertype']] = $db->RowData['printertype'];
					}
					echo json_encode($resultarr);
				} else {
					echo "102"; // id doesn't exist
				}
			}
		}
	
	}
}

// Get printer model
function geteprintermodel() {
	$type_id = $_REQUEST['printertypeid'];
	$hw_id = $_REQUEST['hwid'];
	if (isset($type_id) && $type_id != '') {
		$db = new cDB();
		$resultarr = array();
		$db->Query("SELECT * FROM hz_hardware WHERE name='".$hw_id."'");
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$hwid = $db->RowData['id'];
				//echo "SELECT * FROM hz_make WHERE hw_id=".$hwid." AND name='".$make_id."'";
				$db->Query("SELECT * FROM hz_printertype WHERE hw_id=".$hwid." AND printertype='".$type_id."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$type_id = $db->RowData['id'];
						$getSql = $db->Query("SELECT hpm.id, hpm.printermodel FROM hz_printermodel hpm LEFT OUTER JOIN hz_printertype hp ON (hpm.printertype_id = hp.id) WHERE printertype_id=".$type_id);
						if ($db->RowCount) {
							while ($db->ReadRow()) {
								$resultarr[$db->RowData['printermodel']] = $db->RowData['printermodel'];
								//$resultarr['ip'] = $db->RowData['hasnetwork'];
							}
							echo json_encode($resultarr);
						} else {
							echo "102"; // id doesn't exist
						}
					}
				}
			}
		}
	}
}

if (isset($_POST['functype'])) {
	switch ($_POST['functype']) {
		case 'getemake':
		getemake();
		break;

		case 'getemodel':
		getemodel();
		break;

		case 'geteprintertype':
		geteprintertype();
		break;
		
		case 'geteprintermodel';
		geteprintermodel();
		break;
		
		default:
		echo "404";
	}
}
?>
