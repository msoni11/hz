<?php 
//session_start();
include 'Application.php';
?>
<!DOCTYPE html PUBLIC '//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta name="description" />
<meta name="keywords" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="styles/screen.css" rel="stylesheet" type="text/css" />
<link href="styles/login-box.css" rel="stylesheet" type="text/css" />
<link href="styles/TableTools.css" rel="stylesheet" type="text/css" />
<!--<link href="styles/style.css" rel="stylesheet" type="text/css" />-->
<!--<link href="styles/demo_page.css" rel="stylesheet" type="text/css" />-->
<link href="styles/demo_table.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src='js/jquery-1.7.2.min.js'></script>
<script type=text/javascript src='js/jquery.dataTables.js'></script>
<script type=text/javascript src='js/ZeroClipboard.js'></script>
<script type=text/javascript src='js/TableTools.js'></script>
<script type=text/javascript src='js/validate.js'></script>
<script type=text/javascript src='js/editvalidate.js'></script>
<script type=text/javascript src='js/common.js'></script>
<script type=text/javascript src='js/authenticate.js'></script>
<title>Hindustan Zinc Limited</title>
</head>
<body>
<!-- Header start -->
<div id="layout">
      
      <div id="header">
        
        <h1 id="logo">
		<a href="#" title=""><img src="images/logo.gif" height = "130" width = "130" class="imgset" />Hindustan Zinc Limited <span></span></a>
		<br ><div class="textsmall" style="position:absolute; top :24px; left:134px; font-size:0.6em">Smelter, Chanderiya</div>
        </h1>
		<hr class="noscreen" />
		<!-- Show only if user is login-->
			<!-- Navbar end   -->
         	<?php if (isset($_SESSION['adldapinfo'])) { ?>   
            <!-- Navbar start -->
			<div id="nav" class="box1">
				<ul>
   	                <li><a href="user_home.php">HOME</a></li>
					<li><a href="request_asset.php">REQUEST ASSET</a></li>
					<li><a href="transfer_request.php">TRANSFER ASSET</a></li>
					<li><a href="asset_list.php">ASSET LIST</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
				</ul>
				<hr class="noscreen" />
			</div>
		<?php } else if (isset($_SESSION['username'])) { ?>
			<!-- Navbar start -->
			 <!-- not required -->
			 <!-- <div id="nav" class="box1">
				<ul>
					<li><a href="home.php">HOME</a></li>
					<li><a href="addEmployee.php">EMPLOYEE</a></li>
					<li><a href="userasset.php">IT ASSET</a></li>
					<li><a href="addNetwork.php">NETWORK</a></li>
					<li><a href="criticalasset.php">CRITICAL ASSET</a></li>
					<li><a href="listEmployees.php">EMPLOYEE LIST</a></li>
					<li><a href="crystReport.php">REPORT</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
				</ul>
				<hr class="noscreen" />
			</div>-->
			<!-- Navbar end   -->
		<?php } else { ?>
		<table border="0" width="98%">
			<tr>
				<td width="60"><div id="welcome">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome </div></td>
				<td width="30%"><div class="time"> <?php print date('D, d M Y H:i:s'); ?></div></td>
			</tr>
		</table>
		<?php } ?>
      </div>
     
      <hr class="noscreen" />

<!-- Header End -->
