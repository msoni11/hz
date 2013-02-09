<?php 
include 'includes/Application.php';
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


// function definition : New registration entry
function newregistration() {
	$regempid = $_REQUEST['regempid'];
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
		
		if (($regempid != '') && (is_numeric($regempid)) && ($regempname != '') && ($regunitname != '') && ($regdeptname != '') && 
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
							$totalAvail = "SELECT count(*) total FROM hz_registration WHERE hardware='".$reghardware."' AND printertype='".$regprintertype."' AND make='".$regmake."' AND model='".$regmodel."'";
						} else {
							$totalAvail = "SELECT count(*) total FROM hz_registration WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."'";
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
										//}
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
							$totalAvail = "SELECT count(*) total FROM hz_otherregistration WHERE hardware='".$reghardware."' AND make='".$regmake."' AND model='".$regmodel."'";

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
function getempdetails() {
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

						$totalAvail = "SELECT count(*) total FROM hz_criticalregistration WHERE hardware='".$crithardware."' AND make='".$critmake."' AND model='".$critmodel."'";

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

if (isset($_POST['functype'])) {
	switch ($_POST['functype']) {
		
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

		default:
		echo "404";

	}
}
?>
