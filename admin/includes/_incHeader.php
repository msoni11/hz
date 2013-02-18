<?php 
//session_start();
include '../includes/Application.php';
?>
<!DOCTYPE html PUBLIC '//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta name="description" />
<meta name="keywords" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="../styles/screen.css" rel="stylesheet" type="text/css" />
<link href="../styles/login-box.css" rel="stylesheet" type="text/css" />
<link href="../styles/TableTools.css" rel="stylesheet" type="text/css" />
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css" />
<!--<link href="styles/style.css" rel="stylesheet" type="text/css" />-->
<!--<link href="styles/demo_page.css" rel="stylesheet" type="text/css" />-->
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src='../js/jquery-1.7.2.min.js'></script>
<script type=text/javascript src='../js/jquery.dataTables.js'></script>
<script type=text/javascript src='../js/ZeroClipboard.js'></script>
<script type=text/javascript src='../js/TableTools.js'></script>
<script type=text/javascript src='../js/validate.js'></script>
<script type=text/javascript src='../js/editvalidate.js'></script>
<script type=text/javascript src='../js/common.js'></script>
<script type=text/javascript src='../js/stock.js'></script>
<script type=text/javascript src='../js/editcommon.js'></script>
<script type=text/javascript src='../js/authenticate.js'></script>
<title>Hindustan Zinc Limited</title>
</head>
<body>
<!-- Header start -->
<div id="layout">
      
      <div id="header">
        
        <h1 id="logo">
		<a href="#" title=""><img src="../images/logo.gif" height = "130" width = "130" class="imgset" />Hindustan Zinc Limited <span></span></a>
		<br ><div class="textsmall" style="position:absolute; top :24px; left:134px; font-size:0.6em">Smelter, Chanderiya</div>
        </h1>
		<div id="showTopLeft"><img src="images/b_home.png" style=" margin: -3px;padding: 0 2px;" /><a href="admin_home.php">HOME</a> | <a href="updateProfile.php">CHANGE PASSWORD</a> | <img src="images/logout.png" style=" margin: -3px;padding: 0 2px;" /><a href="logout.php">LOGOUT</a></div>
		<hr class="noscreen" />
		<!-- Show only if user is login-->
		<?php if (isset($_SESSION['username'])) { ?>
			<!-- Navbar start -->
			<div id="nav" class="box1">
				<ul>
					<!--<li><a href="admin_home.php">HOME</a></li>-->
					<!-- <li><a href="addUser.php">LOGIN USER</a></li>-->
					<!-- <li><a href="addEmployee.php">NEW EMPLOYEE</a></li>-->
					<li><a href="#">STOCK ENTRY</a>
						<ul>
							<li><a href="addStock.php">ASSET STOCK ENTRY</a></li>
							<li><a href="addOtherStock.php">CONSUMABLE STOCK ENTRY</a></li>
						</ul>
					</li>
					<li><a href="#">LIST</a>
						<ul>
							<li><a href="adlists/listEmployee.php">Employee</a></li>
							<li><a href="adlists/listAssetRequests.php">Request Approval</a></li>
							<li><a href="adlists/listTransferRequests.php">Transfer Approval</a></li>
							<li><a href="adlists/listAuditor.php">Auditor List</a></li>
							<li><a href="adlists/listAsset.php">IT Asset</a></li>
							<li><a href="adlists/listScrap.php">Scrap List</a></li>
							<li><a href="adlists/listIp.php">IP List</a></li>
							<li><a href="adlists/listStore.php">Store</a></li>
							<li><a href="assetVerification.php">Asset Verification</a></li>
							<li><a href="lists/listCriticalAsset.php">Critical Asset</a></li>
							<li><a href="lists/listConsumable.php">Consumable Items</a></li>
							<li><a href="lists/listNetwork.php">Network</a></li>
							<li><a href="adlists/listStock.php">Stock</a></li>
							<li><a href="lists/listConsumableStock.php">Consumable Stock</a></li>
						</ul>
					</li>
					<li><a href="#">REPORT</a>
						<ul>
							<li><a href="report/employee.php">Employee</a></li>
							<li><a href="report/itasset.php">IT Asset</a></li>
							<li><a href="report/criticalasset.php">Critical Asset</a></li>
							<li><a href="report/consumableitasset.php">Consumable Items</a></li>
							<li><a href="report/network.php">Network</a></li>
							<li><a href="report/transferredasset.php">Transferred Asset</a></li>
							<li><a href="report/stock.php">Stock</a></li>
							<li><a href="report/availablestock.php">Available Stock</a></li>
							<li><a href="report/stockbydepartment.php">Department Wise Stock</a></li>
							<li><a href="report/availablecriticalstock.php">Available Critical Stock</a></li>
							<li><a href="report/criticalstockbydepartment.php">Critical Stock By Department</a></li>
							<li><a href="report/consumablestock.php">Consumable Stock</a></li>
							<li><a href="report/availableconsumablestock.php">Available Consumable Stock</a></li>
							<li><a href="report/consumablestockbydepartment.php">Department Wise Consumable Stock</a></li>
						</ul>
					</li>
					<li><a href="userasset.php">IT ASSET</a></li>
					<li><a href="otheruserasset.php">CONSUMABLE ITEMS</a></li>
					<!-- <li><a href="addNetwork.php">NETWORK</a></li>-->
					<li><a href="criticalasset.php">CRITICAL ASSET</a></li>
					<li><a href="importcsv.php">IMPORT</a></li>
					<li><a href="addScrap.php">SCRAP</a></li>
					<li><a href="ip.php">Auditor IP</a></li>
					<li><a href="addIPAddress.php">Add IP</a></li>
					<li><a href="addLocation.php">Add Location</a></li>
					
					<!--<li><a href="logout.php">LOGOUT</a></li>-->
				</ul>
				<hr class="noscreen" />
			</div>
			<!-- Navbar end   -->
		<?php } else { ?>
		<table border="0" width="98%">
			<tr>
				<td width="60"><div id="welcome">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome </div></td>
				<td width="30%"><div class="time"><?php print date('D, d M Y H:i:s'); ?></div></td>
			</tr>
		</table>
		<?php } ?>
      </div>
     
      <hr class="noscreen" />

<!-- Header End -->
