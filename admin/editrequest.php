<?php 
include '../includes/Application.php';
// function definition : Edit employee entry
function editemployee() {

	$empid       = $_REQUEST['empid'];
	$empname     = strtoupper($_REQUEST['empname']);
	$unitname    = strtoupper($_REQUEST['unit']);
	$deptname    = strtoupper($_REQUEST['department']);
	$designation = strtoupper($_REQUEST['designation']);

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($empid) && isset($empname) && isset($unitname) && isset($deptname) && isset($designation)) {
		if (($empid != '') && (is_numeric($empid)) && ($empname != '') && ($unitname != '') && ($deptname != '') && ($designation != '')) {
			$db = new cDB();
			$db1 = new cDB();
			$idChecksql = "SELECT empid FROM hz_employees WHERE empid=".$empid;
			$db1->Query($idChecksql);
			if ($db1->RowCount) {
				$sql = "UPDATE hz_employees SET 
								empname='".$empname."',
								unit='".$unitname."',
								department='".$deptname."',
								designation='".$designation."' WHERE empid=".$empid;
				$updateEmp = $db->Query($sql);
				if ($updateEmp) {
					echo "0"; //update success.
					die();
				} else {
					echo "103"; //status false. Error updating record(s).
					die();
				}
			} else {
				echo "102"; //ID missing or deleted.
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

// function definition : Edit registration entry
function editregistration() {
	$regid = $_REQUEST['regid'];
	$regempid = $_REQUEST['regempid'];
	$reghardware = strtoupper($_REQUEST['reghardware']); //int 
	$regcartage = strtoupper($_REQUEST['regcartage']);
	$regprintertype = strtoupper($_REQUEST['regprintertype']); //int
	$regmake = strtoupper($_REQUEST['regmake']);//int
	$regmodel = strtoupper($_REQUEST['regmodel']);//int
	$regcpuno = strtoupper($_REQUEST['regcpuno']);
	$regmonitor = strtoupper($_REQUEST['regmonitor']);
	$regcrtno = strtoupper($_REQUEST['regcrtno']);
	$regconfig = strtoupper($_REQUEST['regconfig']);
	$regasset = strtoupper($_REQUEST['regasset']);
	$regassettext = strtoupper($_REQUEST['regassettext']);
	$regip = strtoupper($_REQUEST['regip']);
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
		die();
	} else if (isset($regempid) && isset($reghardware) && isset($regcartage) && isset($regprintertype) && isset($regmake) && isset($regmodel) &&
				isset($regcpuno) && isset($regmonitor) && isset($regcrtno) && isset($regconfig) &&
				isset($regasset) && isset($regassettext) && isset($regip) && isset($regoffice) && 
				isset($reglicense) && isset($reginternet) && isset($regamc) && isset($regday) && 
				isset($regmonth) && isset($regyear) && isset($regotherasset) && isset($regstatus)) {
		
		if (($regempid != '') && (is_numeric($regempid)) && ($reghardware != '') && ($regcartage != '') && ($regprintertype != '') && ($regmake != '') && ($regmodel != '') &&
				($regcpuno != '') && ($regmonitor != '') && ($regcrtno != '') && ($regconfig != '') &&
				($regasset != '') && ($regassettext != '') && ($regip != '') &&
				($regoffice != '') && ($reglicense != '') && ($reginternet != '') && ($regamc != '') && ($regday != '') && 
				($regmonth != '') && ($regyear != '') && ($regotherasset != '') && ($regstatus != '')) {

			$db = new cDB();
			$db1 = new cDB();
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
							$totalAlloted = $dbTotalAvail->RowData['total'];
							$idChecksql = "SELECT * FROM hz_registration WHERE id=".$regid;
							$db1->Query($idChecksql);
							if ($db1->RowCount) {
								if ($db1->ReadRow()) {
									if (($reghardware == '3') && ($db1->RowData['hardware'] == $reghardware) && ($db1->RowData['printertype'] == $regprintertype) && ($db1->RowData['make'] == $regmake) && ($db1->RowData['model'] == $regmodel) ) {
										if ($stockquantity >= $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									} else if (($db1->RowData['hardware'] == $reghardware) && ($db1->RowData['make'] == $regmake) && ($db1->RowData['model'] == $regmodel) ) {
										if ($stockquantity >= $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									} else {
										if ($stockquantity > $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									}
								}
							} else {
								echo "102"; //ID missing or deleted.
								die();
							}

							if ($flag) {
								$sqlselect = "SELECT * FROM hz_employees WHERE empid=".$regempid;
								$db->Query($sqlselect);
								if ($db->RowCount) {
									if ($db->ReadRow()) {
										$idCheck = "SELECT * FROM hz_registration WHERE empid=".$regempid;
										$db1->Query($idChecksql);
										if ($db1->RowCount) {
											$updatequery = "UPDATE hz_registration SET 
																hardware='".$reghardware."',
																cartage='".$regcartage."',
																printertype='".$regprintertype."',
																make='".$regmake."',
																model='".$regmodel."',
																cpuno='".$regcpuno."',
																monitortype='".$regmonitor."',
																monitorno='".$regcrtno."',
																sysconfig='".$regconfig."',
																assetcode='".$regasset."',
																ipaddr='".$regip."',
																officever='".$regoffice."',
																licensesoft='".$reglicense."',
																internet='".$reginternet."',
																internettype='".$regamc."',
																warnorvendor='".$warnvendor."',
																date='".$date."',
																otheritasset='".$regotherasset."',
																status='".$regstatus."' WHERE id=".$regid." AND empid=".$regempid;
										
											$isupdate = $db->Query($updatequery);
											if ($isupdate) {
												echo "0"; //Records updated
												die();
											} else {
												echo "103"; //Error updating record;
												die();
											}
										} else {
											echo "102"; //ID missing or deleted.
											die();
										}
									}
								}
							} else {
								echo "111"; // Stock full. can't allot asset
								die();
							}
						}
					}
				}
			} else {
				echo "110";
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

// function definition : Edit employee entry
function editnetwork() {
	$id		   = (int)$_REQUEST['id'];
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
		die();
	} else if (isset($id) && isset($ntwdepartment) && isset($ntwitem) && isset($ntwmake) && isset($ntwmodel) && isset($ntwserial) && isset($ntwquantity) && isset($ntwtype) && isset($ntwamc) ) {
		if (($id != '') && (is_numeric($id)) && ($ntwdepartment != '') && ($ntwitem != '') && ($ntwmake != '') && ($ntwmodel != '') && ($ntwserial != '') && ($ntwquantity != '') && (is_numeric($ntwquantity)) &&($ntwtype != '') &&($ntwamc != '')) {

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
			$db1 = new cDB();
			$idChecksql = "SELECT id FROM hz_network WHERE id=".$id;
			$db1->Query($idChecksql);
			if ($db1->RowCount) {
				$sql = "UPDATE hz_network SET 
								location='".$ntwdepartment."',
								item='".$ntwitem."',
								make='".$ntwmake."',
								model='".$ntwmodel."',
								serial='".$ntwserial."',
								quantity='".$ntwquantity."',
								type='".$ntwtype."',
								amcwar='".$ntwamc."',
								warnorvendor='".$warnvendor."' WHERE id=".$id;
				$updateNetwork = $db->Query($sql);
				if ($updateNetwork) {
					echo "0"; //update success.
					die();
				} else {
					echo "103"; //status false. Error updating record(s).
					die();
				}
			} else {
				echo "102"; //ID missing or deleted.
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

// function definition : Edit stock entry
function editstock() {
	$id                   = (int)($_REQUEST['id']);
	$stockdepartment      = (int)($_REQUEST['stockdepartment']);
	$stockhardware        = (int)($_REQUEST['stockhardware']);
	$stocktype            = (int)($_REQUEST['stocktype']);
	$stockmake            = (int)($_REQUEST['stockmake']);
	$stockmodel           = (int)($_REQUEST['stockmodel']);
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

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($stockdepartment) && isset($stockhardware) && isset($stocktype) && isset($stockmake) && isset($stockmodel) && 
		   isset($stockinvoice) && isset($stockday) && isset($stockmonth) && isset($stockyear) && isset($stockpartyname) &&
		   isset($stockrcvrname) && isset($stockquantity) && isset($stockrate) && isset($stockotherstatus) && isset($stockentrytype)) {
		if (($stockdepartment != '') && ($stockhardware != '' || $stockhardware == '0') && ($stockmake != '' || $stockmake == 0) && ($stockmodel != '' || $stockmodel == 0) &&
		    ($stockinvoice != '') && ($stockday != '') && ($stockmonth != '') && ($stockyear != '') &&
		    ($stockpartyname != '') && ($stockrcvrname != '') && ($stockquantity != '') && ($stockrate != '') && ($stockotherstatus != '') && ($stockentrytype != '')) {

			$orderdate = mktime(0,0,0,$stockmonth,$stockday,$stockyear);

			$db = new cDB();
			$db1 = new cDB();
			
			$idChecksql = "SELECT * FROM hz_stock WHERE id=".$id;
			$db1->Query($idChecksql);
			if ($db1->RowCount) {
				if ($db1->ReadRow()) {
					$selfQuantity = $db1->RowData['quantity'];
					$regDB = new cDB();
					$regDB->Query("SELECT count(*) as total FROM hz_registration WHERE hardware='".$db1->RowData['hardware']."' AND printertype='".$db1->RowData['type']."' AND make='".$db1->RowData['make']."' AND model='".$db1->RowData['model']."' AND activestatus='A'" );
					if ($regDB->RowCount) {
						if ($regDB->ReadRow()) {
							$totalAlot = $regDB->RowData['total'];
							$stockDB = new cDB();
							$stockDB->Query("SELECT SUM(quantity) as totalsum FROM hz_stock WHERE hardware='".$db1->RowData['hardware']."' AND type='".$db1->RowData['type']."' AND make='".$db1->RowData['make']."' AND model='".$db1->RowData['model']."'" );
							if ($stockDB->RowCount) {
								if ($stockDB->ReadRow()) {
									$difference = $stockDB->RowData['totalsum'];
									if ($stockquantity >= $selfQuantity) {
										$newtotal = ($stockDB->RowData['totalsum'] + ($stockquantity - $selfQuantity));
									} else {
										$newtotal = ($stockDB->RowData['totalsum'] - ($selfQuantity - $stockquantity));
									}
									if ($newtotal >= $totalAlot) {
										$sql = "UPDATE hz_stock SET 
														department='".$stockdepartment."',
														hardware='".$stockhardware."',
														type='".$stocktype."',
														make='".$stockmake."',
														model='".$stockmodel."',
														invoiceno='".$stockinvoice."',
														orderdate='".$orderdate."',
														partyname='".$stockpartyname."',
														receivername='".$stockrcvrname."',
														quantity='".$stockquantity."',
														rate='".$stockrate."',
														otherstatus='".$stockotherstatus."',
														entrytype = '".$stockentrytype."' WHERE id=".$id;
										$updateStock = $db->Query($sql);
										if ($updateStock) {
											echo "0"; //update success.
											die();
										} else {
											echo "103"; //status false. Error updating record(s).
											die();
										}
									} else {
										echo "111"; // Can't edit.You have issued hardware
										die();
									}
								}
							}
						}
					} else {
						$sql = "UPDATE hz_stock SET 
										department='".$stockdepartment."',
										hardware='".$stockhardware."',
										type='".$stocktype."',
										make='".$stockmake."',
										model='".$stockmodel."',
										invoiceno='".$stockinvoice."',
										orderdate='".$orderdate."',
										partyname='".$stockpartyname."',
										receivername='".$stockrcvrname."',
										quantity='".$stockquantity."',
										rate='".$stockrate."',
										otherstatus='".$stockotherstatus."',
										entrytype = '".$stockentrytype."' WHERE id=".$id;
						$updateStock = $db->Query($sql);
						if ($updateStock) {
							echo "0"; //update success.
							die();
						} else {
							echo "103"; //status false. Error updating record(s).
							die();
						}
					}
				}
			} else {
				echo "102"; //ID missing or deleted.
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

// function definition : Edit other stock entry
function editotherstock() {
	$id                   = (int)($_REQUEST['id']);
	$stockdepartment      = (int)($_REQUEST['stockdepartment']);
	$stockhardware        = (int)($_REQUEST['stockhardware']);
	$stockmake            = (int)($_REQUEST['stockmake']);
	$stockmodel           = (int)($_REQUEST['stockmodel']);
	$stockinvoice         = strtoupper($_REQUEST['stockinvoice']);
	$stockday             = (int)($_REQUEST['stockday']);
	$stockmonth           = (int)($_REQUEST['stockmonth']);
	$stockyear            = (int)($_REQUEST['stockyear']);
	$stockpartyname       = strtoupper($_REQUEST['stockpartyname']);
	$stockrcvrname        = strtoupper($_REQUEST['stockrcvrname']);
	$stockquantity        = $_REQUEST['stockquantity'];
	$stockrate            = $_REQUEST['stockrate'];
	$stockotherstatus     = strtoupper($_REQUEST['stockotherstatus']);
	//$stockentrytype       = strtoupper($_REQUEST['stockentrytype']);

	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die;
	} else if (isset($stockdepartment) && isset($stockhardware) && isset($stockmake) && isset($stockmodel) && 
		   isset($stockinvoice) && isset($stockday) && isset($stockmonth) && isset($stockyear) && isset($stockpartyname) &&
		   isset($stockrcvrname) && isset($stockquantity) && isset($stockrate) && isset($stockotherstatus) ) {
		if (($stockdepartment != '') && ($stockhardware != '' || $stockhardware == '0') && ($stockmake != '' || $stockmake == 0) && ($stockmodel != '' || $stockmodel == 0) &&
		    ($stockinvoice != '') && ($stockday != '') && ($stockmonth != '') && ($stockyear != '') &&
		    ($stockpartyname != '') && ($stockrcvrname != '') && ($stockquantity != '') && ($stockrate != '') && ($stockotherstatus != '') ) {

			$orderdate = mktime(0,0,0,$stockmonth,$stockday,$stockyear);

			$db = new cDB();
			$db1 = new cDB();
			
			$idChecksql = "SELECT * FROM hz_otherstock WHERE id=".$id;
			$db1->Query($idChecksql);
			if ($db1->RowCount) {
				if ($db1->ReadRow()) {
					$selfQuantity = $db1->RowData['quantity'];
					$regDB = new cDB();
					$regDB->Query("SELECT count(*) as total FROM hz_otherregistration WHERE hardware='".$db1->RowData['hardware']."' AND make='".$db1->RowData['make']."' AND model='".$db1->RowData['model']."' AND activestatus='A'" );
					if ($regDB->RowCount) {
						if ($regDB->ReadRow()) {
							$totalAlot = $regDB->RowData['total'];
							$stockDB = new cDB();
							$stockDB->Query("SELECT SUM(quantity) as totalsum FROM hz_otherstock WHERE hardware='".$db1->RowData['hardware']."' AND make='".$db1->RowData['make']."' AND model='".$db1->RowData['model']."'" );
							if ($stockDB->RowCount) {
								if ($stockDB->ReadRow()) {
									$difference = $stockDB->RowData['totalsum'];
									if ($stockquantity >= $selfQuantity) {
										$newtotal = ($stockDB->RowData['totalsum'] + ($stockquantity - $selfQuantity));
									} else {
										$newtotal = ($stockDB->RowData['totalsum'] - ($selfQuantity - $stockquantity));
									}
									if ($newtotal >= $totalAlot) {
										$sql = "UPDATE hz_otherstock SET 
														department='".$stockdepartment."',
														hardware='".$stockhardware."',
														make='".$stockmake."',
														model='".$stockmodel."',
														invoiceno='".$stockinvoice."',
														orderdate='".$orderdate."',
														partyname='".$stockpartyname."',
														receivername='".$stockrcvrname."',
														quantity='".$stockquantity."',
														rate='".$stockrate."',
														otherstatus='".$stockotherstatus."' WHERE id=".$id;
										$updateStock = $db->Query($sql);
										if ($updateStock) {
											echo "0"; //update success.
											die();
										} else {
											echo "103"; //status false. Error updating record(s).
											die();
										}
									} else {
										echo "111"; // Can't edit.You have issued hardware
										die();
									}
								}
							}
						}
					} else {
						$sql = "UPDATE hz_otherstock SET 
										department='".$stockdepartment."',
										hardware='".$stockhardware."',
										make='".$stockmake."',
										model='".$stockmodel."',
										invoiceno='".$stockinvoice."',
										orderdate='".$orderdate."',
										partyname='".$stockpartyname."',
										receivername='".$stockrcvrname."',
										quantity='".$stockquantity."',
										rate='".$stockrate."',
										otherstatus='".$stockotherstatus."' WHERE id=".$id;
						$updateStock = $db->Query($sql);
						if ($updateStock) {
							echo "0"; //update success.
							die();
						} else {
							echo "103"; //status false. Error updating record(s).
							die();
						}
					}
				}
			} else {
				echo "102"; //ID missing or deleted.
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

// function definition : Delete employee
function deleteemployee() {
	$empid = (int)$_REQUEST['delempid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($empid)) {
		if (($empid != '') && (is_numeric($empid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$db2 = new cDB();
			$db3 = new cDB();
			$validateid  = "SELECT empid FROM hz_registration WHERE empid=".$empid." AND activestatus='A'";
			$db->Query($validateid);
			if ($db->RowCount) {
				echo "102"; //No delete permission
			} else {
				$validateemp = "SELECT * FROM hz_employees WHERE empid=".$empid;
				$db1->Query($validateemp);
				if ($db1->RowCount) {
					$sql = "DELETE FROM hz_employees WHERE empid=".$empid;
					$delEmployee = $db3->Query($sql);
					if ($delEmployee) {
						echo "0"; //delete success.
						die();
					} else {
						echo "103"; //status false. Error deleting record(s) in employee.
						die();
					}
				} else {
					echo "107"; //No entry in employee
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

// function definition : Delete registration
function deleteregistration() {
	$regempid = (int)$_REQUEST['delregid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($regempid)) {
		if (($regempid != '') && (is_numeric($regempid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validateid  = "SELECT id FROM hz_registration WHERE id=".$regempid;
			$db->Query($validateid);
			if ($db->RowCount) {
				//$sql = "DELETE FROM hz_registration WHERE id=".$regempid;
				$sql = "UPDATE hz_registration SET activestatus='D' WHERE id=".$regempid;
				$delRegistration = $db1->Query($sql);
					if ($delRegistration) {
						echo "0"; //delete success.
						die();
					} else {
						echo "103"; //status false. Error deleting record(s) in employee.
						die();
					}			
			} else {
				echo "107";
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

// function definition : Delete other registration
function deleteotherregistration() {
	$regempid = (int)$_REQUEST['delregid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($regempid)) {
		if (($regempid != '') && (is_numeric($regempid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validateid  = "SELECT id FROM hz_otherregistration WHERE id=".$regempid;
			$db->Query($validateid);
			if ($db->RowCount) {
				//$sql = "DELETE FROM hz_registration WHERE id=".$regempid;
				$sql = "UPDATE hz_otherregistration SET activestatus='D' WHERE id=".$regempid;
				$delRegistration = $db1->Query($sql);
					if ($delRegistration) {
						echo "0"; //delete success.
						die();
					} else {
						echo "103"; //status false. Error deleting record(s) in employee.
						die();
					}			
			} else {
				echo "107";
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

// function definition : Delete critical registration
function deletecriticalregistration() {
	$regempid = (int)$_REQUEST['delregid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($regempid)) {
		if (($regempid != '') && (is_numeric($regempid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validateid  = "SELECT id FROM hz_criticalregistration WHERE id=".$regempid;
			$db->Query($validateid);
			if ($db->RowCount) {
				//$sql = "DELETE FROM hz_registration WHERE id=".$regempid;
				$sql = "UPDATE hz_criticalregistration SET activestatus='D' WHERE id=".$regempid;
				$delRegistration = $db1->Query($sql);
					if ($delRegistration) {
						echo "0"; //delete success.
						die();
					} else {
						echo "103"; //status false. Error deleting record(s) in employee.
						die();
					}			
			} else {
				echo "107";
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


// function definition : Delete network
function deletenetwork() {
	$ntwrkid = (int)$_REQUEST['delntwrkid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($ntwrkid)) {
		if (($ntwrkid != '') && (is_numeric($ntwrkid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validatentwrkid  = "SELECT * FROM hz_network WHERE id=".$ntwrkid;
			$db->Query($validatentwrkid);
			if ($db->RowCount) {
				$ntwrksql = "DELETE FROM hz_network WHERE id=".$ntwrkid;
				$delNetwork = $db1->Query($ntwrksql);
				if ($delNetwork) {
					echo "0"; //delete success.
					die();
				} else {
					echo "103"; //status false. Error deleting record(s) in network.
					die();
				}
			} else {
				echo "107"; // No entry in network
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

// function definition : Delete Stock
function deletestock() {
	$stockid = (int)$_REQUEST['delstockid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($stockid)) {
		if (($stockid != '') && (is_numeric($stockid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validatestockid  = "SELECT * FROM hz_stock WHERE id=".$stockid;
			$db->Query($validatestockid);
			if ($db->RowCount) {
				if ($db->ReadRow()) {
					$selfQuantity = $db->RowData['quantity'];
					$regDB = new cDB();
					$regDB->Query("SELECT count(*) as total FROM hz_registration WHERE hardware='".$db->RowData['hardware']."' AND printertype='".$db->RowData['type']."' AND make='".$db->RowData['make']."' AND model='".$db->RowData['model']."' AND activestatus='A'" );
					if ($regDB->RowCount) {
						if ($regDB->ReadRow()) {
							$totalAlot = $regDB->RowData['total'];
							$stockDB = new cDB();
							$stockDB->Query("SELECT SUM(quantity) as totalsum FROM hz_stock WHERE hardware='".$db->RowData['hardware']."' AND type='".$db->RowData['type']."' AND make='".$db->RowData['make']."' AND model='".$db->RowData['model']."'" );
							if ($stockDB->RowCount) {
								if ($stockDB->ReadRow()) {
									$difference = $stockDB->RowData['totalsum'] - $totalAlot;
									if ($selfQuantity <= $difference) {
										$stocksql = "DELETE FROM hz_stock WHERE id=".$stockid;
										$delStock = $db1->Query($stocksql);
										if ($delStock) {
											echo "0"; //delete success.
											die();
										} else {
											echo "103"; //status false. Error deleting record(s) in network.
											die();
										}
									} else {
										echo "111"; // Can't delete.You have issued hardware
									}
								}
							}
						}
					} else {
						$stocksql = "DELETE FROM hz_stock WHERE id=".$stockid;
						$delStock = $db1->Query($stocksql);
						if ($delStock) {
							echo "0"; //delete success.
							die();
						} else {
							echo "103"; //status false. Error deleting record(s) in network.
							die();
						}
					}
				}
			} else {
				echo "107"; // No entry in network
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

// function definition : Delete Other Stock
function deleteotherstock() {
	$stockid = (int)$_REQUEST['delotherstockid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($stockid)) {
		if (($stockid != '') && (is_numeric($stockid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validatestockid  = "SELECT * FROM hz_otherstock WHERE id=".$stockid;
			$db->Query($validatestockid);
			if ($db->RowCount) {
				if ($db->ReadRow()) {
					$selfQuantity = $db->RowData['quantity'];
					$regDB = new cDB();
					$regDB->Query("SELECT count(*) as total FROM hz_otherregistration WHERE hardware='".$db->RowData['hardware']."' AND make='".$db->RowData['make']."' AND model='".$db->RowData['model']."' AND activestatus ='A'" );
					if ($regDB->RowCount) {
						if ($regDB->ReadRow()) {
							$totalAlot = $regDB->RowData['total'];
							$stockDB = new cDB();
							$stockDB->Query("SELECT SUM(quantity) as totalsum FROM hz_otherstock WHERE hardware='".$db->RowData['hardware']."' AND make='".$db->RowData['make']."' AND model='".$db->RowData['model']."'" );
							if ($stockDB->RowCount) {
								if ($stockDB->ReadRow()) {
									$difference = $stockDB->RowData['totalsum'] - $totalAlot;
									if ($selfQuantity <= $difference) {
										$stocksql = "DELETE FROM hz_otherstock WHERE id=".$stockid;
										$delStock = $db1->Query($stocksql);
										if ($delStock) {
											echo "0"; //delete success.
											die();
										} else {
											echo "103"; //status false. Error deleting record(s) in network.
											die();
										}
									} else {
										echo "111"; // Can't delete.You have issued hardware
									}
								}
							}
						}
					} else {
						$stocksql = "DELETE FROM hz_otherstock WHERE id=".$stockid;
						$delStock = $db1->Query($stocksql);
						if ($delStock) {
							echo "0"; //delete success.
							die();
						} else {
							echo "103"; //status false. Error deleting record(s) in network.
							die();
						}
					}
				}
			} else {
				echo "107"; // No entry in network
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

// function definition : Transfer registration
function transferregistration() {
	$transferempid = (int)$_REQUEST['transferregid'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($transferempid)) {
		if (($transferempid != '') && (is_numeric($transferempid))) {
			$db  = new cDB();
			$db1 = new cDB();
			$validateid  = "SELECT * FROM hz_registration WHERE id=".$transferempid;
			$db->Query($validateid);
			if ($db->RowCount) {
				if ($db->ReadRow()) {
					$hwid      = $db->RowData['hardware'];
					$printerid = $db->RowData['printertype'];
					$makeid    = $db->RowData['make'];
					$modelid   = $db->RowData['model'];
					$stocksql = "SELECT * FROM hz_stock WHERE hardware=".$hwid." AND type=".$printerid." AND make=".$makeid." AND model=".$modelid;
					$db->Query($stocksql);
					if ($db->RowCount) {
						$sql = "UPDATE hz_registration SET activestatus='T' WHERE id=".$transferempid;
						$delRegistration = $db1->Query($sql);
						if ($delRegistration) {
							echo "0"; //Move success.
							die();
						} else {
							echo "103"; //status false. Error deleting record(s) in employee.
							die();
						}			
					} else {
						echo "110"; // This is not a transferred stock
					}
				}
			} else {
				echo "107";
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

// function definition : Edit critical registration entry
function editcriticalregistration() {
	$critid                    = strtoupper($_REQUEST['criticalid']); //int
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
							$totalAlloted = $dbTotalAvail->RowData['total'];
							$idChecksql = "SELECT * FROM hz_criticalregistration WHERE id=".$critid;
							$db1->Query($idChecksql);
							if ($db1->RowCount) {
								if ($db1->ReadRow()) {
									if (($db1->RowData['hardware'] == $crithardware) && ($db1->RowData['make'] == $critmake) && ($db1->RowData['model'] == $critmodel) ) {
										if ($stockquantity >= $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									} else {
										if ($stockquantity > $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									}
								}
							} else {
								echo "102"; //ID missing or deleted.
								die();
							}
							
							if ( $flag ) {
								 $sql = "UPDATE hz_criticalregistration SET
											department='".$critdepartment."',
											hardware = '".$crithardware."',
											hwname = '".$critname."',
											assetcode = '".$critassetcode."',
											location = '".$critlocation."',
											assetowner = '".$critassetowner."',
											make = '".$critmake."',
											model = '".$critmodel."',
											serialno = '".$critserialno."',
											ipaddr = '".$critipsubnet."',
											hasconfig = '".$hasconfig."',
											configprocessor = '".$critconfprocessor."',
											configram = '".$critconfram."',
											confighdd = '".$critconfhdd."',
											configcdrom = '".$critconfcdrom."',
											hasnetwork = '".$hasnetwork."',
											nwmake = '".$critnwmake."',
											nwspeed = '".$critnwspeed."',
											nwgateway = '".$critnwgateway."',
											hasperipheral = '".$hasperipheral."',
											peripheralmake = '".$critpermake."',
											peripheralmodel = '".$critpermodel."',
											peripheralserialno = '".$critperserno."',
											hassoftware = '".$hassoftware."',
											swoperatingsystem = '".$critswos."',
											swapplication = '".$critswapplication."',
											swserialno = '".$critswserno."',
											otherconfig = '".$critotherconfig."',
											issuedate = '".$date."' WHERE id=".$critid;
							
								$updateCritical = $db1->Query($sql);
								if ($updateCritical) {
									echo "0"; //status true.Show success message
									die();
								} else {
									echo "103"; //status false. Error updating database.
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

// function definition : Edit Other registration entry
function editotherregistration() {
	$regid          = $_REQUEST['regid'];
	$regempid       = $_REQUEST['regempid'];
	$regempname     = strtoupper($_REQUEST['regempname']);
	$regunitname    = strtoupper($_REQUEST['regunit']);
	$regdeptname    = strtoupper($_REQUEST['regdepartment']);
	$regdesignation = strtoupper($_REQUEST['regdesignation']);
	$reghardware    = strtoupper($_REQUEST['reghardware']); //int
	$regmake        = strtoupper($_REQUEST['regmake']); //int
	$regmodel       = strtoupper($_REQUEST['regmodel']); //int
	$regrcvrname    = strtoupper($_REQUEST['regrcvrname']);
	$regday         = $_REQUEST['regday'];
	$regmonth       = $_REQUEST['regmonth'];
	$regyear        = $_REQUEST['regyear'];
	$regissuedby    = strtoupper($_REQUEST['regissuedby']);
	$regstatus      = strtoupper($_REQUEST['regstatus']);

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
							$totalAlloted = $dbTotalAvail->RowData['total'];
							$idChecksql = "SELECT * FROM hz_otherregistration WHERE id=".$regid;
							$db1->Query($idChecksql);
							if ($db1->RowCount) {
								if ($db1->ReadRow()) {
									if (($db1->RowData['hardware'] == $reghardware) && ($db1->RowData['make'] == $regmake) && ($db1->RowData['model'] == $regmodel) ) {
										if ($stockquantity >= $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									} else {
										if ($stockquantity > $totalAlloted) { //allow to update even if stock is full
											$flag = true;
										} else {
											$flag = false;
										}
									}
								}
							} else {
								echo "111"; //ID missing or deleted.
								die();
							}




						if ($flag) {
								$sqlselect = "SELECT * FROM hz_employees WHERE empid=".$regempid;
								$db->Query($sqlselect);
								if ($db->RowCount) {
									if ($db->ReadRow()) {
										$sql = "UPDATE hz_otherregistration	SET
												empid ='".$regempid."', 
												hardware='".$reghardware."', 
												make='".$regmake."', 
												model='".$regmodel."', 
												receivername='".$regrcvrname."', 
												issuedate='".$date."', 
												issuedby='".$regissuedby."', 
												otherstatus='".$regstatus."'
												WHERE id=".$regid;
									
										$updateotherit = $db1->Query($sql);
										if ($updateotherit) {
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

//Store Asset funtion definition
function storeAsset() {
	$assetID = (int)$_REQUEST['assetID'];
	if (!isset($_SESSION['username'])) {
		echo "101"; // Session expires! Login again
		die();
	} else if (isset($assetID)) {
		if (($assetID != '') && (is_numeric($assetID))) {
			$db  = new cDB();
			$db1 = new cDB();
			$db2 = new cDB();
			$db3 = new cDB();
			$validateid  = "SELECT * FROM hz_registration WHERE id=".$assetID." AND activestatus='A'";
			$db->Query($validateid);
			if ($db->RowCount) {
				if ($db->ReadRow()){
					$updateStock = $db1->Query('UPDATE hz_products SET status=2 WHERE ProductID IN('.$db->RowData['cpuno'].','.$db->RowData['monitorno'].') AND status=1');
					if ($updateStock) {
						$updateAsset = $db1->Query("UPDATE hz_registration SET activestatus='D' WHERE id=".$assetID." AND activestatus='A'");
						if ($updateAsset) {
							echo "0"; //update success.
							die();
						} else {
							$updateStock = $db1->Query('UPDATE hz_products SET status=1 WHERE ProductID IN('.$db->RowData['cpuno'].','.$db->RowData['monitorno'].')');
							echo "103"; //status false. Error updating record(s).
							die();
						}
					} else {
						echo "103"; //status false. Error updating record(s).
						die();
					}
				}
			} else {
				echo "107"; //No entry in registration
				die();
			}
		}
			
	} else {
		echo "105"; // form field hasn't received by post
		die();
	}
}

if (isset($_POST['functype'])) {
	switch ($_POST['functype']) {
	
		case 'editemployee':
		editemployee();
		break;

		case 'editregistration':
		editregistration();
		break;

		case 'editotherregistration':
		editotherregistration();
		break;

		case 'editcriticalregistration':
		editcriticalregistration();
		break;

		case 'editnetwork':
		editnetwork();
		break;
		
		case 'editstock':
		editstock();
		break;

		case 'editotherstock':
		editotherstock();
		break;

		case 'deleteemployee':
		deleteemployee();
		break;

		case 'deleteregistration':
		deleteregistration();
		break;
		
		case 'deleteotherregistration':
		deleteotherregistration();
		break;
		
		case 'deletecriticalregistration':
		deletecriticalregistration();
		break;
		
		case 'deletenetwork':
		deletenetwork();
		break;

		case 'deletestock':
		deletestock();
		break;

		case 'deleteotherstock':
		deleteotherstock();
		break;

		case 'transferregistration':
		transferregistration();
		break;
		
		case 'storeAsset':
		storeAsset();
		break;
		
		default:
		echo "404";
	}
}
?>
