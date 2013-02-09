<?php 
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
<!--<link href="styles/style.css" rel="stylesheet" type="text/css" />-->
<!--<link href="styles/demo_page.css" rel="stylesheet" type="text/css" />-->
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src='../js/jquery-1.7.2.min.js'></script>
<script type=text/javascript src='../js/jquery.dataTables.js'></script>
<script type=text/javascript src='../js/ZeroClipboard.js'></script>
<script type=text/javascript src='../js/TableTools.js'></script>
<script type=text/javascript src='../js/validate.js'></script>
<script type=text/javascript src='../js/editvalidate.js'></script>
<!--<script type=text/javascript src='../js/common.js'></script>-->
<script type=text/javascript src='../js/filterresult.js'></script>
<script type=text/javascript src='../js/authenticate.js'></script>
<title>Hindustan Zinc Limited</title>
</head>
<body>
<!-- Header start -->
<div class="layout-2">
      
      <div id="header">
        
        <h1 id="logo">
		<a href="#" title=""><img src="../images/logo.gif" height = "130" width = "130" class="imgset" />Hindustan Zinc Limited <span></span></a>
		<br ><div class="textsmall" style="position:absolute; top :24px; left:134px; font-size:0.6em">Smelter, Chanderiya</div>
        </h1>
		<div id="showTopLeft"><a href="admin_home.php">HOME</a> | <a href="updateProfile.php">CHANGE PASSWORD</a> | <a href="logout.php">LOGOUT</a></div>
		<hr class="noscreen" />
		<!-- Show only if user is login-->
		<?php if (isset($_SESSION['username'])) { ?>
			<!-- Navbar start -->
			<div id="nav" class="box1">
				<ul>
					<li><a href="admin_home.php">HOME</a></li>
					<?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == '1') { ?>
					<li><a href="addUser.php">LOGIN USER</a></li>
					<?php } ?>
					<li><a href="addEmployee.php">EMPLOYEE</a></li>
					<li><a href="userasset.php">IT ASSET</a></li>
					<li><a href="addNetwork.php">NETWORK</a></li>
					<li><a href="addStock.php">STOCK ENTRY</a></li>
					<li><a href="criticalasset.php">CRITICAL ASSET</a></li>
					<li><a href="listEmployees.php">EMPLOYEE LIST</a></li>
					<li><a href="crystReport.php">REPORT</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
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
</div>  
      <hr class="noscreen" />

<!-- Header End -->