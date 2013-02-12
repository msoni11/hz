<?php 
include '../includes/Application.php';
// Get make details
function getemake() {
	$hw_id = (int)$_REQUEST['hardwareid'];
	if (isset($hw_id) && $hw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hm.id, hm.name FROM hz_make hm LEFT OUTER JOIN hz_hardware hh ON (hm.hw_id = hh.id) WHERE hw_id=".$hw_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = $db->RowData['name'];
			}
			echo json_encode($resultarr);
		} else {
		echo "102"; // id doesn't exist
		}
	}
}

// Get model details
function getemodel() {
	$make_id = (int)$_REQUEST['makeid'];
	if (isset($make_id) && $make_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hmd.id, hmd.modelname FROM hz_model hmd LEFT OUTER JOIN hz_make hm ON (hmd.make_id = hm.id) WHERE make_id=".$make_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultmodel['model'][$db->RowData['id']] = $db->RowData['modelname'];
			}
			//echo json_encode($resultmodel);
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
	$hw_id = (int)$_REQUEST['hardwareid'];
	if (isset($hw_id) && $hw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hp.id, hp.printertype FROM hz_printertype hp LEFT OUTER JOIN hz_hardware hh ON (hp.hw_id = hh.id) WHERE hw_id=".$hw_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = $db->RowData['printertype'];
			}
			echo json_encode($resultarr);
		} else {
		echo "102"; // id doesn't exist
		}
	
	}
}

// Get printer model
function geteprintermodel() {
	$type_id = (int)$_REQUEST['printertypeid'];
	if (isset($type_id) && $type_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hpm.id, hpm.printermodel FROM hz_printermodel hpm LEFT OUTER JOIN hz_printertype hp ON (hpm.printertype_id = hp.id) WHERE printertype_id=".$type_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = $db->RowData['printermodel'];
				//$resultarr['ip'] = $db->RowData['hasnetwork'];
			}
			echo json_encode($resultarr);
		} else {
		echo "102"; // id doesn't exist
		}
	
	}
}

// Check IP
function checkIP() {
	$printer_id = (int)$_REQUEST['printertypeid'];
	if (isset($printer_id) && $printer_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hasnetwork FROM hz_printertype WHERE id=".$printer_id);
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$resultarr['ip'] = $db->RowData['hasnetwork'];
			}
		}
		echo json_encode($resultarr);
	}
}

// Get cartage
function getecartage() {
	$hw_id = (int)$_REQUEST['hardwareid'];
	if (isset($hw_id) && $hw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hc.id, hc.cartage FROM hz_cartage hc LEFT OUTER JOIN hz_hardware hh ON (hc.hw_id = hh.id) WHERE hw_id=".$hw_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = $db->RowData['cartage'];
			}
			echo json_encode($resultarr);
		} else {
		echo "102"; // id doesn't exist
		}
	
	}
}

//Get critical hardware name 
function getecriticalhardwarename() {
	$criticalhw_id = (int)$_REQUEST['hardwareid'];
	if (isset($criticalhw_id) && $criticalhw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hchn.* FROM hz_critical_hardware_name hchn LEFT OUTER JOIN hz_hardware hch ON (hch.id = hchn.hardware_id) WHERE hch.id =".$criticalhw_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = strtoupper($db->RowData['name']);
			}
			echo json_encode($resultarr);
		} else {
			echo "102"; // id doesn't exist
		}
	
	}
}

//Get critical hardware make 
function getecriticalmake() {
	$criticalhw_id = (int)$_REQUEST['criticalhardwareid'];
	if (isset($criticalhw_id) && $criticalhw_id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hcm.* FROM hz_critical_make hcm LEFT OUTER JOIN hz_critical_hardware hch ON (hch.id = hcm.criticalhw_id) WHERE hch.id =".$criticalhw_id);
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['id']] = strtoupper($db->RowData['name']);
			}
			echo json_encode($resultarr);
		} else {
			echo "102"; // id doesn't exist
		}
	
	}
}


// Get cpu serials numbers
function getserials() {
    $hardware_id = $_REQUEST["hardware"];
    $make_id = $_REQUEST["make"];
    $model_id = $_REQUEST["model"];
    if($hardware_id && $make_id && $model_id)
    {
       $db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT * FROM hz_products WHERE stockID IN (SELECT id FROM `hz_stock` WHERE `hardware`=$hardware_id AND `make`=$make_id AND `model`=$model_id) AND configurationID <> 0");
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

// Get cpu serials numbers
function get_m_serials() {
    $hardware_id = $_REQUEST["hardware"];
    $make_id = $_REQUEST["make"];
    $model_id = $_REQUEST["model"];
    if($hardware_id && $make_id && $model_id)
    {
       $db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT * FROM hz_products WHERE stockID IN (SELECT id FROM `hz_stock` WHERE `hardware`=$hardware_id AND `make`=$make_id AND `model`=$model_id) AND configurationID = 0");
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

function getcpuconfig() {
    $serial_id = $_REQUEST["serial_id"];
    
    if($serial_id)
    {
       $db = new cDB();
		$resultarr = array();
        //echo "SELECT * FROM hz_configuration WHERE id IN (SELECT configurationID FROM `hz_products` WHERE `productID`=$serial_id)";
		$getSql = $db->Query("SELECT * FROM hz_configuration WHERE id IN (SELECT configurationID FROM `hz_products` WHERE `productID`=$serial_id)");
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$resultarr[$db->RowData['make_id']] = strtoupper($db->RowData['config']);
			}
			echo json_encode($resultarr);
		} else {
			echo "102"; // id doesn't exist
		}
    }
	
}

// Get User asset details
function getassetdetails() {
	$id = trim($_REQUEST['reggetempid']);
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($id) && $id != '') {
		$db  = new cDB();
		$db1 = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT hr.*,hz.name FROM hz_registration hr LEFT OUTER JOIN hz_hardware hz ON hr.hardware = hz.id WHERE hr.empid='".$id."'");
		if ($db->RowCount) {
			while ($db->ReadRow()) {
				$cpuno = $db1->Query('SELECT serial FROM hz_products WHERE productID='.$db->RowData['cpuno']);
				if ($db1->RowCount) {
				    if ($db1->ReadRow()) {
				$arrdata[] = array_merge($db->RowData,$db1->RowData);;
						//$arrdata[] = $db1->RowData;
					}
				}
			}
			echo json_encode($arrdata);
		} else {
		echo "102"; // id doesn't exist
		}
	}
}

function getassetcode()
{
    $serial_id = $_REQUEST["serial_id"];
    
    if($serial_id)
    {
       $db = new cDB();
		$resultarr = array();
       
		$getSql = $db->Query("SELECT * FROM `hz_products` WHERE `productID`=$serial_id");
        echo $getSql;
       if ($db->RowCount) {
			while ($db->ReadRow()) {
				$code = strtoupper($db->RowData['asset_code']);
			}
			echo $code;
		} else {
			echo "102"; // id doesn't exist
		}
    }
}



if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'getemake':
		getemake();
		break;

		case 'getemodel':
		getemodel();
		break;

		case 'geteprintertype':
		geteprintertype();
		break;
		
		case geteprintermodel;
		geteprintermodel();
		break;
		
		case checkIP:
		checkIP();
		break;
		
		case getecartage:
		getecartage();
		break;
		
		//Critical hardware
		case getecriticalhardwarename:
		getecriticalhardwarename();
		break;
		
		case getecriticalmake;
		getecriticalmake();
		break;
        
        //cpu serials
        case 'getserials':
		getserials();
		break;
        
        //monitor serials
        case 'getmserials':
		get_m_serials();
		break;
        
        
        case 'getcpuconfig':
		getcpuconfig();
		break;
		
        case 'getassetdetails':
		getassetdetails();
		break;
        
        case 'getassetcode':
		getassetcode();
		break;

		default:
		echo "404";
	}
}
?>