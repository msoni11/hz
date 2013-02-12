<?php 
include '../includes/Application.php';
// function definition : New employee entry
function newemployee() {
	$empid       = $_REQUEST['empid'];
	$empname     = strtoupper($_REQUEST['empname']);
	$unitname    = strtoupper($_REQUEST['unit']);
	$deptname    = strtoupper($_REQUEST['department']);
	$designation = strtoupper($_REQUEST['designation']);
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($empid) && isset($empname) && isset($unitname) && isset($deptname) && isset($designation)) {
		if (($empid != '') && (is_numeric($empid)) && ($empname != '') && ($unitname != '') && ($deptname != '') && ($designation != '')) {
			$db = new cDB();
			$db1 = new cDB();
			$idChecksql = "SELECT empid FROM hz_employees WHERE empid=".$empid;
			$db->Query($idChecksql);
			if ($db->RowCount) {
				echo "102"; //Employee id already exists.
				die();
			} else {
				$sql = "INSERT INTO hz_employees(empid,empname,unit,department,designation) 
						VALUES('".$empid."','".$empname."','".$unitname."','".$deptname."','".$designation."')";
				$db1->Query($sql);
				if ($db1->LastInsertID) {
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
		echo "104"; //Internal update error
		die();
	}
}

// function definition : New user entry
function newuser() {
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($_REQUEST['uname']) && isset($_REQUEST['password']) && isset($_REQUEST['usertype'])) {
		$db = new cDB();
		$uname = $_REQUEST['uname'];
		$password = $_REQUEST['password'];
		$usertype = $_REQUEST['usertype'];
		if (($uname != '') && ($password != '') && ($usertype != '')) {
			if (strtolower($usertype) == 'anmuser') {
				$usertype = 0;
			} else {
				$usertype = 1;
			}
			$sqlselect = "SELECT * FROM hz_users WHERE username='".$uname."' AND isadmin=".$usertype;
			$db->Query($sqlselect);
			if ($db->RowCount) {
				echo "102"; //User already exists;
				die();
			} else {
				$sql = "INSERT INTO hz_users(username,password,isadmin) 
						VALUES('".$uname."','".$password."',".$usertype.")";
				$db->Query($sql);
				if ($db->LastInsertID) {
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

// function definition : New registration entry
function newregistration() {
	$regempid = $_REQUEST['regempiddesc'];
	$regempname     = strtoupper($_REQUEST['regempname']);
	$regunitname    = strtoupper($_REQUEST['regunit']);
	$regdeptname    = strtoupper($_REQUEST['regdepartment']);
	$regdesignation = strtoupper($_REQUEST['regdesignation']);
	$reghardware = strtoupper($_REQUEST['reghardware']); //int
	$regcartage = strtoupper($_REQUEST['regcartage']);
	$regprintertype = strtoupper($_REQUEST['regprintertype']); //int
	$regmake = strtoupper($_REQUEST['regmake']); //int
	$regmodel = strtoupper($_REQUEST['regmodel']); //int
	$regcpuno = strtoupper($_REQUEST['regcpuno']);
	$regmonitor = strtoupper($_REQUEST['regmonitor']);
	$regcrtno = strtoupper($_REQUEST['regcrtno']);
	$regconfig = strtoupper($_REQUEST['regconfig']);
	$regasset = strtoupper($_REQUEST['regasset']);
	$regassettext = strtoupper($_REQUEST['regassettext']);
	$regip = $_REQUEST['regip'];
	$regoffice = strtoupper($_REQUEST['regoffice']);
	$reglicense = strtoupper($_REQUEST['reglicense']);
	$reginternet = strtoupper($_REQUEST['reginternet']);
	$regamc = strtoupper($_REQUEST['regamc']);
	if ($regamc == 'AMC') {
		$regvendor = strtoupper($_REQUEST['regvendor']);
	} else if ($regamc == 'WAR') {
		$regwarnday = $_REQUEST['regwarnday'];
		$regwarnmonth = $_REQUEST['regwarnmonth'];
		$regwarnyear = $_REQUEST['regwarnyear'];
	}  
	$regday = $_REQUEST['regday'];
	$regmonth = $_REQUEST['regmonth'];
	$regyear = $_REQUEST['regyear'];
	$regotherasset = strtoupper($_REQUEST['regotherasset']);
	$regstatus = strtoupper($_REQUEST['regstatus']);

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($regempid) && isset($regempname) && isset($regunitname) && isset($regdeptname) && isset($regdesignation) && 
				isset($reghardware) && isset($regcartage) && isset($regprintertype) && isset($regmake) && isset($regmodel) &&
				isset($regcpuno) && isset($regmonitor) && isset($regcrtno) && isset($regconfig) &&
				isset($regasset) && isset($regassettext) && isset($regip) && isset($regoffice) && 
				isset($reglicense) && isset($reginternet) && isset($regamc) && isset($regday) && 
				isset($regmonth) && isset($regyear) && isset($regotherasset) && isset($regstatus)) {
		
		if (($regempid != '') && ($regempname != '') && ($regunitname != '') && ($regdeptname != '') && 
				($regdesignation != '') && ($reghardware != '') && ($regcartage != '') && ($regprintertype != '' || $regprintertype == '0') && ($regmake != '') && ($regmodel != '') &&
				($regcpuno != '') && ($regmonitor != '') && ($regcrtno != '') && ($regconfig != '') &&
				($regasset != '') && ($regassettext != '') && ($regip != '') &&
				($regoffice != '') && ($reglicense != '') && ($reginternet != '') && ($regamc != '') && ($regday != '') && 
				($regmonth != '') && ($regyear != '') && ($regotherasset != '') && ($regstatus != '')) {
		
			$db = new cDB();
			$db1 = new cDB();
			$db2 = new cDB();
			$date = mktime(0,0,0,(int)$regmonth,(int)$regday,(int)$regyear);
			if ($regasset == 'OTHER') {
				$regasset = $regassettext;
			} else {
				$regasset = $regasset."/".$regassettext;
			}
			if ($regamc == 'AMC') {
				if ($regvendor != '') {
					$warnvendor = $regvendor;
				} else {
					echo "105";
					die();
				}
			} else if ($regamc == 'WAR') {
				if (($regwarnday != '') && ($regwarnmonth != '') && ($regwarnyear != '')) {
					$warndate = mktime(0,0,0,(int)$regwarnmonth,(int)$regwarnday,(int)$regwarnyear);
					$warnvendor = $warndate;
				} else {
					echo "105";
					die();
				}
			}
			
			//model
			/*if (is_numeric($regmodel)) {
				if ($reghardware ==3) {
					$mdldb = new cDB();
					$mdldb->Query("SELECT printermodel FROM hz_printermodel WHERE id=".$regmodel);
					if ($mdldb->RowCount) {
						if ($mdldb->ReadRow()) {
							$regmodel = $mdldb->RowData['printermodel'];
						}
					}
				} else {
					$mdldb = new cDB();
					$mdldb->Query("SELECT modelname FROM hz_model WHERE id=".$regmodel);
					if ($mdldb->RowCount) {
						if ($mdldb->ReadRow()) {
							$regmodel = $mdldb->RowData['modelname'];
						}
					}
				}
			}*/

			//hardware
			/*if (is_numeric($reghardware)) {
				$hwdb = new cDB();
				$hwdb->Query("SELECT name FROM hz_hardware WHERE id=".$reghardware);
				if ($hwdb->RowCount) {
					if ($hwdb->ReadRow()) {
						$reghardware = $hwdb->RowData['name'];
					}
				}
			}
			
			//printertype
			if (is_numeric($regprintertype)) {
				$prdb = new cDB();
				$prdb->Query("SELECT printertype FROM hz_printertype WHERE id=".$regprintertype);
				if ($prdb->RowCount) {
					if ($prdb->ReadRow()) {
						$regprintertype = $prdb->RowData['printertype'];
					}
				}
			}
			
			//make
			if (is_numeric($regmake)) {
				$mkdb = new cDB();
				$mkdb->Query("SELECT name FROM hz_make WHERE id=".$regmake);
				if ($mkdb->RowCount) {
					if ($mkdb->ReadRow()) {
						$regmake = $mkdb->RowData['name'];
					}
				}
			}*/
			if ($reghardware == '3') {
				$stockAvail = "SELECT SUM(quantity) quantity FROM hz_stock WHERE hardware='".$reghardware."' AND type='".$regprintertype."' AND make='".$regmake."' AND model='".$regmodel."'";
			} else {
				$stockAvail = "SELECT SUM(quantity) quantity FROM hz_stock WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."'";
			}
			
			$dbStockAvail = new cDB();
			$dbStockAvail->Query($stockAvail);
			if ($dbStockAvail->RowCount) {
				if ($dbStockAvail->ReadRow()) {
					$stockquantity = $dbStockAvail->RowData['quantity'];
					if ($stockquantity == NULL || $stockquantity == '0') {
						echo "110"; // Stock not available
						die();
					} else {
						$dbTotalAvail = new cDB();
						if ($reghardware == '3') {
							$totalAvail = "SELECT count(*) total FROM hz_registration WHERE hardware='".$reghardware."' AND printertype='".$regprintertype."' AND make='".$regmake."' AND model='".$regmodel."' AND activestatus ='A'";
						} else {
							$totalAvail = "SELECT count(*) total FROM hz_registration WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."' AND activestatus ='A'";
						}
						$dbTotalAvail->Query($totalAvail);
						if ($dbTotalAvail->ReadRow()) {
							if ( $stockquantity > $dbTotalAvail->RowData['total']) {
								$sqlselect = "SELECT * FROM hz_employees WHERE empid=".$regempid;
								$db->Query($sqlselect);
								if ($db->RowCount) {
									if ($db->ReadRow()) {
										
										$sql = "UPDATE hz_employees SET 
														empname='".$regempname."',
														unit='".$regunitname."',
														department='".$regdeptname."',
														designation='".$regdesignation."' WHERE empid=".$regempid;
										$updateEmp = $db2->Query($sql);
										if (!$updateEmp) {
											echo "106"; //update error.
											die();
										}
										/*$sqlselect = "SELECT empid FROM hz_registration WHERE empid=".$regempid;
										$db1->Query($sqlselect);
										if ($db1->RowCount) {
											echo "105";	//Error user already exist in registration table
											die();
										} else {*/
										//}
									}
								} else {
									//Insert new entry in employee table
									$sql = "INSERT INTO hz_employees(empid, empname, unit, department, designation, mail, location) 
											VALUES('".$regempid."','".$regempname."','".$regunitname."','".$regdeptname."','".$regdesignation."','','')";
									$insertEmp = $db2->Query($sql);
									if (!$db2->LastInsertID) {
										echo "103"; //User insertion error
										die();
									}
								}
								$sql = "INSERT INTO hz_registration(empid, hardware, cartage, printertype, make, model, cpuno,
																	monitortype, monitorno, sysconfig, assetcode, ipaddr, officever, licensesoft,
																	internet, internettype, warnorvendor, date, otheritasset, status
																	) 
										VALUES('".$regempid."','".$reghardware."','".$regcartage."','".$regprintertype."','".$regmake."','".$regmodel."','".$regcpuno."','".$regmonitor."','".$regcrtno."','".$regconfig."',
												'".$regasset."','".$regip."','".$regoffice."','".$reglicense."','".$reginternet."','".$regamc."','".$warnvendor."','".$date."','".$regotherasset."','".$regstatus."')";
							
								$db1->Query($sql);
								if ($db1->LastInsertID) {
									echo "0"; //status true.Show success message
									die();
								} else {
									echo "103"; //status false. Error inserting into database.
									die();
								}
							} else {
								echo "111"; // Stock full. can't allot asset
								die();
							}
						}					
					}
				}
			} else {
				echo "110"; // Stock not available
				die();
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

// function definition : New Other registration entry
function newotherregistration() {
	$regempid = $_REQUEST['regempid'];
	$regempname     = strtoupper($_REQUEST['regempname']);
	$regunitname    = strtoupper($_REQUEST['regunit']);
	$regdeptname    = strtoupper($_REQUEST['regdepartment']);
	$regdesignation = strtoupper($_REQUEST['regdesignation']);
	$reghardware = strtoupper($_REQUEST['reghardware']); //int
	$regmake = strtoupper($_REQUEST['regmake']); //int
	$regmodel = strtoupper($_REQUEST['regmodel']); //int
	$regrcvrname = strtoupper($_REQUEST['regrcvrname']);
	$regday = $_REQUEST['regday'];
	$regmonth = $_REQUEST['regmonth'];
	$regyear = $_REQUEST['regyear'];
	$regissuedby = strtoupper($_REQUEST['regissuedby']);
	$regstatus = strtoupper($_REQUEST['regstatus']);

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($regempid) && isset($regempname) && isset($regunitname) && isset($regdeptname) && isset($regdesignation) && 
				isset($reghardware) && isset($regmake) && isset($regmodel) && isset($regrcvrname) && isset($regday) && 
				isset($regmonth) && isset($regyear) && isset($regissuedby) && isset($regstatus)) {
		
		if (($regempid != '') && (is_numeric($regempid)) && ($regempname != '') && ($regunitname != '') && ($regdeptname != '') && 
			($regdesignation != '') && ($reghardware != '')  && ($regmake != '') && ($regmodel != '') && ($regrcvrname != '') && 
			($regday != '') && ($regmonth != '') && ($regyear != '') && ($regissuedby != '') && ($regstatus != '')) {
		
			$db = new cDB();
			$db1 = new cDB();
			$db2 = new cDB();
			$date = mktime(0,0,0,(int)$regmonth,(int)$regday,(int)$regyear);

			$stockAvail = "SELECT SUM(quantity) quantity FROM hz_otherstock WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."'";
			
			$dbStockAvail = new cDB();
			$dbStockAvail->Query($stockAvail);
			if ($dbStockAvail->RowCount) {
				if ($dbStockAvail->ReadRow()) {
					$stockquantity = $dbStockAvail->RowData['quantity'];
					if ($stockquantity == NULL || $stockquantity == '0') {
						echo "110"; // Stock not available
						die();
					} else {
						$dbTotalAvail = new cDB();
						$totalAvail = "SELECT count(*) total FROM hz_otherregistration WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."' AND activestatus ='A'";

						$dbTotalAvail->Query($totalAvail);
						if ($dbTotalAvail->ReadRow()) {
							if ( $stockquantity > $dbTotalAvail->RowData['total']) {
								$sqlselect = "SELECT * FROM hz_employees WHERE empid=".$regempid;
								$db->Query($sqlselect);
								if ($db->RowCount) {
									if ($db->ReadRow()) {
										
										$sql = "UPDATE hz_employees SET 
														empname='".$regempname."',
														unit='".$regunitname."',
														department='".$regdeptname."',
														designation='".$regdesignation."' WHERE empid=".$regempid;
										$updateEmp = $db2->Query($sql);
										if (!$updateEmp) {
											echo "106"; //update error.
											die();
										}
										$sql = "INSERT INTO hz_otherregistration(empid, hardware, make, model, receivername, issuedate, issuedby, otherstatus
																			) 
												VALUES('".$regempid."','".$reghardware."','".$regmake."','".$regmodel."','".$regrcvrname."','".$date."','".$regissuedby."','".$regstatus."')";
									
										$db1->Query($sql);
										if ($db1->LastInsertID) {
											echo "0"; //status true.Show success message
											die();
										} else {
											echo "103"; //status false. Error inserting into database.
											die();
										}
									}
								} else {
									echo "102"; //No User with this employee id;
									die();
								}
							} else {
								echo "111"; // Stock full. can't allot asset
								die();
							}
						}					
					}
				}
			} else {
				echo "110"; // Stock not available
				die();
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

// function definition : New network entry
function newnetwork() {
		$ntwdepartment     = strtoupper($_REQUEST['ntwdepartment']);
		$ntwitem       	   = strtoupper($_REQUEST['ntwitem']);
		$ntwmake           = strtoupper($_REQUEST['ntwmake']);
		$ntwmodel          = strtoupper($_REQUEST['ntwmodel']);
		$ntwserial         = strtoupper($_REQUEST['ntwserial']);
		$ntwquantity       = $_REQUEST['ntwquantity'];
		$ntwtype           = strtoupper($_REQUEST['ntwtype']);
		$ntwamc = strtoupper($_REQUEST['ntwamc']);
		if ($ntwamc == 'AMC') {
			$ntwvendor = strtoupper($_REQUEST['ntwvendor']);
		} else if ($ntwamc == 'WAR') {
			$ntwwarnday = $_REQUEST['ntwwarnday'];
			$ntwwarnmonth = $_REQUEST['ntwwarnmonth'];
			$ntwwarnyear = $_REQUEST['ntwwarnyear'];
		}  
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($ntwdepartment) && isset($ntwitem) && isset($ntwmake) && isset($ntwmodel) && isset($ntwserial) && isset($ntwquantity) && isset($ntwtype) && isset($ntwamc) ) {
		if (($ntwdepartment != '') && ($ntwitem != '') && ($ntwmake != '') && ($ntwmodel != '') && ($ntwserial != '') && ($ntwquantity != '') && (is_numeric($ntwquantity)) && ($ntwtype != '') && ($ntwamc != '')) {
			
			if ($ntwamc == 'AMC') {
				if ($ntwvendor != '') {
					$warnvendor = $ntwvendor;
				} else {
					echo "105";
					die();
				}
			} else if ($ntwamc == 'WAR') {
				if (($ntwwarnday != '') && ($ntwwarnmonth != '') && ($ntwwarnyear != '')) {
					$warndate = mktime(0,0,0,(int)$ntwwarnmonth,(int)$ntwwarnday,(int)$ntwwarnyear);
					$warnvendor = $warndate;
				} else {
					echo "105";
					die();
				}
			}
			
			$db = new cDB();
			$sql = "INSERT INTO hz_network(location,item,make,model,serial,quantity,type,amcwar,warnorvendor) 
					VALUES('".$ntwdepartment."','".$ntwitem."','".$ntwmake."','".$ntwmodel."','".$ntwserial."','".$ntwquantity."','".$ntwtype."','".$ntwamc."','".$warnvendor."')";
			$db->Query($sql);
			if ($db->LastInsertID) {
				echo "0"; //status true.Show success message
				die();
			} else {
				echo "103"; //status false. Error inserting into database.
				die();
			}
		} else {
			echo "105";
			die();
		}
	} else {
		echo "104";//Internal update error
		die();
	}
}

// function definition : New network entry
function changePassword() {
		$bitadmin      = $_REQUEST['bitadmin'];
		$checkusername = $_REQUEST['checkusername'];
		$oldpwd        = $_REQUEST['oldpwd'];
		$changepwd     = $_REQUEST['changepwd'];
		$confirmpwd    = $_REQUEST['confirmpwd'];
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($bitadmin) && isset($checkusername) && isset($changepwd) && isset($oldpwd) && isset($confirmpwd)) {
		if (($bitadmin != '') && ($checkusername != '') && ($oldpwd != '') && ($changepwd != '') && ($confirmpwd != '') && ($changepwd == $confirmpwd)) {
			$db = new cDB();
			$db1 = new cDB();
			$db1->Query("SELECT * FROM hz_users WHERE username='".$checkusername."' AND password='".$oldpwd."'");
			if ($db1->RowCount) {
				$sql = "UPDATE hz_users SET password = '".$changepwd."' WHERE username='".$checkusername."' AND isadmin = ".$bitadmin ;
				$updatepwd = $db->Query($sql);
				if ($updatepwd) {
					echo "0"; //status true.Show success message
					die();
				} else {
					echo "103"; //status false. Error updating password.
					die();
				}
			} else {
				echo "102"; //Old password doesn't match
				die();
			}
		} else {
			echo "105";
			die();
		}
	} else {
		echo "104";//Internal update error
		die();
	}
}

// Get employee details
/*function getempdetails() {
	$id = (int)$_REQUEST['reggetempid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($id) && $id != '') {
		$db = new cDB();
		$resultarr = array();
		$getSql = $db->Query("SELECT * FROM hz_employees WHERE empid=".$id);
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$resultarr['empname'] = $db->RowData['empname'];
				$resultarr['unit'] = $db->RowData['unit'];
				$resultarr['department'] = $db->RowData['department'];
				$resultarr['designation'] = $db->RowData['designation'];
				echo json_encode($resultarr);
			} else {
				echo "103"; //some error reading from database
			}
		} else {
		echo "102"; // id doesn't exist
		}
	}
}*/
function getempdetails() {
	//username
	$id = $_REQUEST['reggetempid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($id) && $id != '') {
		if (isset($_SESSION['ldapid'])) {
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
		}
		if (!empty($detail)) {
				$resultarr['empiddesc']   = $detail[0]['description'][0];
				$resultarr['empname'] = $detail[0]['name'][0];
				$resultarr['unit'] = 'NONE';
				$resultarr['department'] = $detail[0]['department'][0];
				$resultarr['designation'] = $detail[0]['title'][0];
				$resultarr['empmail'] = $detail[0]['mail'][0];
				echo json_encode($resultarr);
		} else {
		    echo "102"; // id doesn't exist
		    die;
		}
	}
}


// function definition : New stock entry
function newstock() {
	$stockdepartment      = (int)($_REQUEST['stockdepartment']);
	$stockhardware        = (int)($_REQUEST['stockhardware']);
	$stockaddhardware     = strtoupper($_REQUEST['stockaddhardware']);
	$stocktype            = (int)($_REQUEST['stocktype']);
	$stockaddtype         = strtoupper($_REQUEST['stockaddtype']);
	$stockmake            = (int)($_REQUEST['stockmake']);
	$stockaddmake         = strtoupper($_REQUEST['stockaddmake']);
	$stockmodel           = (int)($_REQUEST['stockmodel']);
	$stockaddmodel        = strtoupper($_REQUEST['stockaddmodel']);
	$stockinvoice         = strtoupper($_REQUEST['stockinvoice']);
	$stockday             = (int)($_REQUEST['stockday']);
	$stockmonth           = (int)($_REQUEST['stockmonth']);
	$stockyear            = (int)($_REQUEST['stockyear']);
	$stockpartyname       = strtoupper($_REQUEST['stockpartyname']);
	$stockrcvrname        = strtoupper($_REQUEST['stockrcvrname']);
	$stockquantity        = $_REQUEST['stockquantity'];
	$stockrate            = $_REQUEST['stockrate'];
	$stockotherstatus     = strtoupper($_REQUEST['stockotherstatus']);
	$stockentrytype       = strtoupper($_REQUEST['stockentrytype']);
    $admin            = $_REQUEST['admin'];
    if(isset($_REQUEST["serials"]))
    {
	$serials              = explode(",",$_REQUEST["serials"]);
	}
    if(isset($_REQUEST["cpu_serials"]))
    {
     $cpu_serials          = explode(",",$_REQUEST["cpu_serials"]);
     $m_serials            = explode(",",$_REQUEST["monitor_serials"]); 
     $config              = $_REQUEST["config"];
     if($config==0)
     {$other  = mysql_real_escape_string(trim($_REQUEST["others"]));}
      
    }
    
    if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($stockdepartment) && isset($stockhardware) && isset($stocktype) && isset($stockmake) && isset($stockmodel) && 
		   isset($stockinvoice) && isset($stockday) && isset($stockmonth) && isset($stockyear) && isset($stockpartyname) &&
		   isset($stockrcvrname) && isset($stockquantity) && isset($stockrate) && isset($stockotherstatus) && isset($stockentrytype)) {
		if (($stockdepartment != '') && ($stockhardware != '' || $stockhardware == '0') && ($stockmake != '' || $stockmake == 0) && ($stockmodel != '' || $stockmodel == 0) &&
		    ($stockinvoice != '') && ($stockday != '') && ($stockmonth != '') && ($stockyear != '') &&
		    ($stockpartyname != '') && ($stockrcvrname != '') && ($stockquantity != '') && ($stockrate != '') && ($stockotherstatus != '') && ($stockentrytype != '') && ($admin != '')) {
			$db = new cDB();
			if ($stockhardware == '0') {
				$db->Query("SELECT * FROM hz_hardware WHERE name='".$stockaddhardware."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$hwid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_hardware(name,ctype) VALUES('".$stockaddhardware."','C')");
					if ($db->LastInsertID) {
						$hwid = $db->LastInsertID;
					} else {
						die(); // Error inserting into hardware
					}
				}
			} else {
				$hwid = $stockhardware;
			}

			$isPrinterType = false;
			if ($hwid == '3' && $stocktype == '0') {
			$isPrinterType = true;
				$db->Query("SELECT * FROM hz_printertype WHERE hw_id='".$hwid."' AND printertype='".$stockaddtype."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$typeid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_printertype(hw_id,printertype) VALUES('".$hwid."','".$stockaddtype."')");
					if ($db->LastInsertID) {
						$typeid = $db->LastInsertID;
					} else {
						die(); // Error inserting into printer type
					}
				}
			} else {
				$typeid = $stocktype;
			}
			
			if ($stockmake == '0') {
				$db->Query("SELECT * FROM hz_make WHERE hw_id='".$hwid."' AND name='".$stockaddmake."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$makeid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_make(hw_id,name) VALUES('".$hwid."', '".$stockaddmake."')");
					if ($db->LastInsertID) {
						$makeid = $db->LastInsertID;
					} else {
						die(); // Error inserting into make
					}
				}
			} else {
				$makeid = $stockmake;
			}
			
			if ($stockmodel == '0') {
				if ($hwid == '3' || $isPrinterType) {
					$db->Query("SELECT * FROM hz_printermodel WHERE printertype_id='".$typeid."' AND printermodel ='".$stockaddmodel."'");
					if ($db->RowCount) {
						if ($db->ReadRow()) {
							$modelid = $db->RowData['id'];
						}
					} else {
						$db->Query("INSERT INTO hz_printermodel(printertype_id,printermodel) VALUES('".$typeid."', '".$stockaddmodel."')");
						if ($db->LastInsertID) {
							$modelid = $db->LastInsertID;
						} else {
							die(); // Error inserting into hardware
						}
					}
				
				} else {
					$db->Query("SELECT * FROM hz_model WHERE make_id='".$makeid."' AND modelname='".$stockaddmodel."'");
					if ($db->RowCount) {
						if ($db->ReadRow()) {
							$modelid = $db->RowData['id'];
						}
					} else {
						$db->Query("INSERT INTO hz_model(make_id,modelname) VALUES('".$makeid."', '".$stockaddmodel."')");
						if ($db->LastInsertID) {
							$modelid = $db->LastInsertID;
						} else {
							die(); // Error inserting into hardware
						}
					}
				}
			} else {
				$modelid = $stockmodel;
			}
            
            
            
			$orderdate = mktime(0,0,0,$stockmonth,$stockday,$stockyear);
			$sql = "INSERT INTO hz_stock(department,hardware,type,make,model,invoiceno,orderdate,partyname,receivername,quantity,rate,otherstatus,entrytype,adminID) 
					VALUES('".$stockdepartment."','".$hwid."',
						'".$typeid."','".$makeid."',
						'".$modelid."','".$stockinvoice."',
						'".$orderdate."','".$stockpartyname."',
						'".$stockrcvrname."','".$stockquantity."',
						'".$stockrate."','".$stockotherstatus."',
						'".$stockentrytype."', '".$admin."'
					       )";
			$db->Query($sql);
            
            	if ($stockID = $db->LastInsertID) {
            	   
                   
               //building Assets code
               
               $sql = "SELECT location FROM config_ldap WHERE id IN (SELECT ldapID FROM hz_users WHERE id =".$admin.")";
                $db->Query($sql);
					if ($db->RowCount) {
						if ($db->ReadRow()) {
							$admin_location = $db->RowData['location'];
						}
                        }
                 $sql = "SELECT code FROM hz_hardware WHERE id=".$stockhardware;
                $db->Query($sql);
					if ($db->RowCount) {
						if ($db->ReadRow()) {
							$hardware_code = $db->RowData['code'];
						}
                        }  
                   
                        
                 $asset_code = $admin_location."/".$hardware_code."/".$stockinvoice."/".$stockyear."/" ;   
				//populating products table
                if(count($serials)>0)
                {
                    $insert_sql = "INSERT INTO hz_products(stockID,serial,status,asset_code) VALUES ";
                        $values="";
                        $c=0;
                        foreach($serials as $val)
                        {
                            $values.="( $stockID , '".$val."' , 1 , '".$asset_code.$val."' )";
                            if($c!=count($serials)-1)
                            {
                                $values.=" , ";
                            }
                            $c++;
                        }
                        $insert_sql.=$values;
                        if($db->Query($insert_sql))
                        {
                            echo "0"; //status true.Show success message
    				        die();   
                        }
                 }
                 if(count($cpu_serials)>0)
                 {
                    //getting configurations id
                    
                    if($config==0)
                    {
                        $insert_new_config = "INSERT INTO hz_configuration(make_id,config) VALUES () ";
                        	$db->Query("INSERT INTO hz_configuration(make_id,config) VALUES('".$stockmake."', '".$other."')");
						if ($db->LastInsertID) {
							$config = $db->LastInsertID;
						} else {
							die(); // Error inserting into hardware
						}
                    }
                    
                     $insert_sql = "INSERT INTO hz_products(stockID,configurationID,serial,status,asset_code) VALUES ";
                        $values="";
                        $c=0;
                        foreach($cpu_serials as $val)
                        {
                            $values.="( $stockID , $config,'".$val."' , 1,'".$asset_code.$val."'  )";
                            if($c!=count($cpu_serials))
                            {
                                $values.=" , ";
                            }
                            $c++;
                        }
                        $c=0;
                        foreach($m_serials as $val)
                        {
                            $values.="( $stockID , 0,'".$val."' , 1,'".$asset_code.$val."' )";
                            if($c!=count($m_serials)-1)
                            {
                                $values.=" , ";
                            }
                            $c++;
                        }
                        $insert_sql.=$values;
                        if($db->Query($insert_sql))
                        {
                            echo "0"; //status true.Show success message
    				        die();   
                        }
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

// function definition : New other stock entry
function newotherstock() {
	$stockdepartment      = (int)($_REQUEST['stockdepartment']);
	$stockhardware        = (int)($_REQUEST['stockhardware']);
	$stockaddhardware     = strtoupper($_REQUEST['stockaddhardware']);
	//$stockaddtype         = strtoupper($_REQUEST['stockaddtype']);
	$stockmake            = (int)($_REQUEST['stockmake']);
	$stockaddmake         = strtoupper($_REQUEST['stockaddmake']);
	$stockmodel           = (int)($_REQUEST['stockmodel']);
	$stockaddmodel        = strtoupper($_REQUEST['stockaddmodel']);
	$stockinvoice         = strtoupper($_REQUEST['stockinvoice']);
	$stockday             = (int)($_REQUEST['stockday']);
	$stockmonth           = (int)($_REQUEST['stockmonth']);
	$stockyear            = (int)($_REQUEST['stockyear']);
	$stockpartyname       = strtoupper($_REQUEST['stockpartyname']);
	$stockrcvrname        = strtoupper($_REQUEST['stockrcvrname']);
	$stockquantity        = $_REQUEST['stockquantity'];
	$stockrate            = $_REQUEST['stockrate'];
	$stockotherstatus     = strtoupper($_REQUEST['stockotherstatus']);
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($stockdepartment) && isset($stockhardware) && isset($stockmake) && isset($stockmodel) && 
		   isset($stockinvoice) && isset($stockday) && isset($stockmonth) && isset($stockyear) && isset($stockpartyname) &&
		   isset($stockrcvrname) && isset($stockquantity) && isset($stockrate) && isset($stockotherstatus) ) {
		if (($stockdepartment != '') && ($stockhardware != '' || $stockhardware == '0') && ($stockmake != '' || $stockmake == 0) && ($stockmodel != '' || $stockmodel == 0) &&
		    ($stockinvoice != '') && ($stockday != '') && ($stockmonth != '') && ($stockyear != '') &&
		    ($stockpartyname != '') && ($stockrcvrname != '') && ($stockquantity != '') && ($stockrate != '') && ($stockotherstatus != '') ) {
			$db = new cDB();
			if ($stockhardware == '0') {
				$db->Query("SELECT * FROM hz_hardware WHERE name='".$stockaddhardware."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$hwid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_hardware(name,ctype) VALUES('".$stockaddhardware."','OA')");
					if ($db->LastInsertID) {
						$hwid = $db->LastInsertID;
					} else {
						die(); // Error inserting into hardware
					}
				}
			} else {
				$hwid = $stockhardware;
			}

			/*$isPrinterType = false;
			if ($hwid == '3' && $stocktype == '0') {
			$isPrinterType = true;
				$db->Query("SELECT * FROM hz_printertype WHERE hw_id='".$hwid."' AND printertype='".$stockaddtype."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$typeid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_printertype(hw_id,printertype) VALUES('".$hwid."','".$stockaddtype."')");
					if ($db->LastInsertID) {
						$typeid = $db->LastInsertID;
					} else {
						die(); // Error inserting into printer type
					}
				}
			} else {
				$typeid = $stocktype;
			}*/
			
			if ($stockmake == '0') {
				$db->Query("SELECT * FROM hz_make WHERE hw_id='".$hwid."' AND name='".$stockaddmake."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$makeid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_make(hw_id,name) VALUES('".$hwid."', '".$stockaddmake."')");
					if ($db->LastInsertID) {
						$makeid = $db->LastInsertID;
					} else {
						die(); // Error inserting into make
					}
				}
			} else {
				$makeid = $stockmake;
			}
			
			if ($stockmodel == '0') {
				$db->Query("SELECT * FROM hz_model WHERE make_id='".$makeid."' AND modelname='".$stockaddmodel."'");
				if ($db->RowCount) {
					if ($db->ReadRow()) {
						$modelid = $db->RowData['id'];
					}
				} else {
					$db->Query("INSERT INTO hz_model(make_id,modelname) VALUES('".$makeid."', '".$stockaddmodel."')");
					if ($db->LastInsertID) {
						$modelid = $db->LastInsertID;
					} else {
						die(); // Error inserting into hardware
					}
				}
			} else {
				$modelid = $stockmodel;
			}
			$orderdate = mktime(0,0,0,$stockmonth,$stockday,$stockyear);
			$sql = "INSERT INTO hz_otherstock(department,hardware,make,model,invoiceno,orderdate,partyname,receivername,quantity,rate,otherstatus) 
					VALUES('".$stockdepartment."','".$hwid."','".$makeid."',
						'".$modelid."','".$stockinvoice."',
						'".$orderdate."','".$stockpartyname."',
						'".$stockrcvrname."','".$stockquantity."',
						'".$stockrate."','".$stockotherstatus."'
					       )";
			$db->Query($sql);
			if ($db->LastInsertID) {
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

// function definition : New critical registration entry
function newcriticalregistration() {
	$critdepartment            = strtoupper($_REQUEST['critdepartment']);
	$crithardware              = strtoupper($_REQUEST['crithardware']); //int
	$critname                  = strtoupper($_REQUEST['critname']);
	$critassetcode             = strtoupper($_REQUEST['critassetcode']);
	$critassetcodetext         = strtoupper($_REQUEST['critassetcodetext']);
	$critlocation              = strtoupper($_REQUEST['critlocation']);
	$critassetowner            = strtoupper($_REQUEST['critassetowner']);
	$critmake                  = strtoupper($_REQUEST['critmake']); //int
	$critmodel                 = strtoupper($_REQUEST['critmodel']); //int
	$critserialno              = strtoupper($_REQUEST['critserialno']);
	$critipsubnet              = strtoupper($_REQUEST['critipsubnet']);
	$hasconfig                 = strtoupper($_REQUEST['hasconfig']);//int
	$critconfprocessor         = strtoupper($_REQUEST['critconfprocessor']);
	$critconfram               = strtoupper($_REQUEST['critconfram']);
	$critconfhdd               = strtoupper($_REQUEST['critconfhdd']);
	$critconfcdrom             = strtoupper($_REQUEST['critconfcdrom']);
	$hasnetwork                = strtoupper($_REQUEST['hasnetwork']);//int
	$critnwmake                = strtoupper($_REQUEST['critnwmake']);
	$critnwspeed               = strtoupper($_REQUEST['critnwspeed']);
	$critnwgateway             = strtoupper($_REQUEST['critnwgateway']);
	$hasperipheral             = strtoupper($_REQUEST['hasperipheral']);//int
	$critpermake               = strtoupper($_REQUEST['critpermake']);
	$critpermodel              = strtoupper($_REQUEST['critpermodel']);
	$critperserno              = strtoupper($_REQUEST['critperserno']);
	$hassoftware               = strtoupper($_REQUEST['hassoftware']); //int
	$critswos                  = strtoupper($_REQUEST['critswos']);
	$critswapplication         = strtoupper($_REQUEST['critswapplication']);
	$critswserno               = strtoupper($_REQUEST['critswserno']);
	$critotherconfig           = strtoupper($_REQUEST['critotherconfig']);
	$critday                   = $_REQUEST['critday'];
	$critmonth                 = $_REQUEST['critmonth'];
	$crityear                  = $_REQUEST['crityear'];

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($critdepartment) && isset($crithardware) && isset($critname) && isset($critassetcode) && isset($critassetcodetext) && 
				isset($critlocation) && isset($critassetowner) && isset($critmake) && isset($critmodel) && isset($critserialno) &&
				isset($critipsubnet) && isset($critconfprocessor) && isset($critconfram) && isset($critconfhdd) &&
				isset($critconfcdrom) && isset($critnwmake) && isset($critnwspeed) && isset($critnwgateway) && 
				isset($critpermake) && isset($critpermodel) && isset($critperserno) && isset($critswos) && 
				isset($critswapplication) && isset($critswserno) && isset($critotherconfig) && isset($critday) &&
				isset($critmonth) && isset($crityear)) {
		
		if (($critdepartment != '') && ($crithardware != '') && ($critname != '') && ($critassetcode != '') &&
				($critassetcodetext != '') && ($critlocation != '') && ($critassetowner != '') && ($critmake != '') &&
				($critmodel != '') && ($critserialno != '') && ($critipsubnet != '') && ($critconfprocessor != '') &&
				($critconfram != '') && ($critconfhdd != '') && ($critconfcdrom != '') && ($critnwmake != '') &&
				($critnwspeed != '') && ($critnwgateway != '') && ($critpermake != '') && ($critpermodel != '') && ($critperserno != '') && 
				($critswos != '') && ($critswapplication != '') && ($critswserno != '') && ($critotherconfig != '') &&
				($critday != '') && ($critmonth != '') && ($crityear != '')) {
		
			if ($critassetcode == 'OTHER') {
				$critassetcode = $critassetcodetext;
			} else {
				$critassetcode = $critassetcode."/".$critassetcodetext;
			}
			$db = new cDB();
			$db1 = new cDB();
			$db2 = new cDB();
			$date = mktime(0,0,0,(int)$critday,(int)$critmonth,(int)$crityear);

			$stockAvail = "SELECT SUM(quantity) quantity FROM hz_stock WHERE hardware='".$crithardware."' AND make='".$critmake."' AND model='".$critmodel."'";
			
			$dbStockAvail = new cDB();
			$dbStockAvail->Query($stockAvail);
			if ($dbStockAvail->RowCount) {
				if ($dbStockAvail->ReadRow()) {
					$stockquantity = $dbStockAvail->RowData['quantity'];
					if ($stockquantity == NULL || $stockquantity == '0') {
						echo "110"; // Stock not available
						die();
					} else {
						$dbTotalAvail = new cDB();

						$totalAvail = "SELECT count(*) total FROM hz_criticalregistration WHERE hardware='".$crithardware."' AND make='".$critmake."' AND model='".$critmodel."' AND activestatus !='A'";

						$dbTotalAvail->Query($totalAvail);
						if ($dbTotalAvail->ReadRow()) {
							if ( $stockquantity > $dbTotalAvail->RowData['total']) {
								$sql = "INSERT INTO hz_criticalregistration(department,hardware,hwname,assetcode,location,assetowner,
																	make,model,serialno,ipaddr,hasconfig,configprocessor,configram,
																	confighdd,configcdrom,hasnetwork,nwmake,nwspeed,nwgateway,hasperipheral,
																	peripheralmake,peripheralmodel,peripheralserialno,hassoftware,swoperatingsystem,
																	swapplication,swserialno,otherconfig,issuedate) 
										VALUES('".$critdepartment."','".$crithardware."','".$critname."','".$critassetcode."','".$critlocation."',
												'".$critassetowner."','".$critmake."','".$critmodel."','".$critserialno."','".$critipsubnet."',
												'".$hasconfig."','".$critconfprocessor."','".$critconfram."','".$critconfhdd."','".$critconfcdrom."',
												'".$hasnetwork."','".$critnwmake."','".$critnwspeed."','".$critnwgateway."','".$hasperipheral."',
												'".$critpermake."','".$critpermodel."','".$critperserno."','".$hassoftware."','".$critswos."',
												'".$critswapplication."','".$critswserno."','".$critotherconfig."','".$date."')";
							
								$db1->Query($sql);
								if ($db1->LastInsertID) {
									echo "0"; //status true.Show success message
									die();
								} else {
									echo "103"; //status false. Error inserting into database.
									die();
								}
							} else {
								echo "111"; // Stock full. can't allot asset
								die();
							}
						}					
					}
				}
			} else {
				echo "110"; // Stock not available
				die();
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

//Function defintion : New IP form
function newip() {
    $ipname          = $_REQUEST['txtipname'];
    $ipunit          = $_REQUEST['txtipunit'];
    $ipaddr          = $_REQUEST['txtipaddress'];
    $ipinternet      = $_REQUEST['txtipinternet'];
    $iprepperson     = $_REQUEST['txtiprepperson'];
    $ipreppersonmail = $_REQUEST['txtipreppersonmail'];
    $ipmobile        = $_REQUEST['txtipmobile'];
    $ipdurationfromd = $_REQUEST['txtipdurationfromday'];
    $ipdurationfromm = $_REQUEST['txtipdurationfrommonth'];
    $ipdurationfromy = $_REQUEST['txtipdurationfromyear'];
    $ipdurationtod   = $_REQUEST['txtipdurationtoday'];
    $ipdurationtom   = $_REQUEST['txtipdurationtomonth'];
    $ipdurationtoy   = $_REQUEST['txtipdurationtoyear'];
	
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($ipname) && isset($ipunit) && isset($ipaddr) && isset($iprepperson) && isset($ipreppersonmail) && isset($ipmobile) && isset($ipdurationfromd) && isset($ipdurationfromm) && isset($ipdurationfromy) && isset($ipdurationtod) && isset($ipdurationtom) && isset($ipdurationtoy)) {
		if (($ipname != '') && ($ipunit != '') && ($ipaddr != '') && ($iprepperson != '') && ($ipreppersonmail != '') && ($ipmobile != '') && ($ipdurationfromd != '') && ($ipdurationfromm != '') && ($ipdurationfromy != '') && ($ipdurationtod != '') && ($ipdurationtom != '') && ($ipdurationtoy != '')) {
			$db = new cDB();
			$db1 = new cDB();
			$durationfrom = mktime(0,0,0,(int)$ipdurationfromm,(int)$ipdurationfromd,(int)$ipdurationfromy);
			$durationto = mktime(0,0,0,(int)$ipdurationtodm,(int)$ipdurationtod,(int)$ipdurationtoy);
			
			$sql = "INSERT INTO hz_ip(auditorName,unit,ip,internet,repPerson,repPersonEmail,mobile,durationFrom,durationTo) 
					VALUES('".$ipname."','".$ipunit."','".$ipaddr."','".$ipinternet."','".$iprepperson."','".$ipreppersonmail."','".$ipmobile."','".$durationfrom."','".$durationto."')";
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

if (isset($_REQUEST['functype'])) {
	switch ($_REQUEST['functype']) {
		case 'newuser':
		newuser();
		break;
		
		case 'newemployee':
		newemployee();
		break;

		case 'newregistration':
		newregistration();
		break;
		
		case 'newotherregistration':
		newotherregistration();
		break;

		case 'newcriticalregistration':
		newcriticalregistration();
		break;

		case 'newnetwork':
		newnetwork();
		break;

		case 'changePassword':
		changePassword();
		break;

		case 'getempdetails':
		getempdetails();
		break;

		case 'newstock':
		newstock();
		break;

		case 'newotherstock':
		newotherstock();
		break;
		
		case 'newip':
		newip();
		break;

		default:
		echo "404";
	}
}
?>
