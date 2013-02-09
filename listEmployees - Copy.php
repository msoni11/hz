<?php 
include 'includes/Application.php';
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
<script type=text/javascript src='js/common.js'></script>
<script type=text/javascript src='js/authenticate.js'></script>
<title>Hindustan Zinc Limited - <?=$page?></title>
</head>
<body>
<!-- Header start -->
<div class="layout-2">
      
      <div id="header">
        
        <h1 id="logo">
		<a href="./" title="Company"><img src="images/logo.gif" height = "130" width = "130" class="imgset" />Hindustan Zinc Limited <span></span></a>
		<br ><div class="textsmall" style="position:absolute; top :20px; left:134px; font-size:0.6em">Smelter, Chanderiya</div>
        </h1>
		<hr class="noscreen" />
		<!-- Show only if user is login-->
		<?php if (isset($_SESSION['username'])) { ?>
			<!-- Navbar start -->
			<div id="nav" class="box1">
				<ul>
					<?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == '1') { ?>
					<li><a href="addUser.php">ADD USER</a></li>
					<?php } ?>
					<li><a href="addEmployee.php">EMPLOYEE</a></li>
					<li><a href="userasset.php">IT ASSET</a></li>
					<li><a href="addNetwork.php">NETWORK</a></li>
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
				<td width="30%"><div class="time"> 25 JULY 2012 03:13:00 PM</></div></td>
			</tr>
		</table>
		<?php } ?>
      </div>
</div>  
      <hr class="noscreen" />

<!-- Header End -->

<?php
/*if (!isset($_SESSION['username'])) {
header("Location:logout.php");
}*/
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 0) {
	header("Location:logout.php");
}
?>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div style = "padding:10px 0 30px 400px">
		<div class="text-box-name">Select:</div>
		<div class="text-box-field">
			<select name="txtselectsort" id = "txtselectsort"  class="form-text" style="width:91%" >
				<option value='-1'>--Select--</option>
				<option value='emplist'>Employee</option>
				<option value='reglist'>Registration</option>
				<option value='combined'>Combined</option>
				<option value='network'>Network</option>
			</select>
		</div>
	</div>

	<div id="emplist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="listEmployees">
				<thead>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

	<div id="reglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="listReg">
				<thead>
					<tr>
						<th >Employee ID</th>
						<th >Hardware</th>
						<th >Make</th>
						<th >Model</th>
						<th >CPU no.</th>
						<th >Monitor</th>
						<th >CRT/TFT no.</th>
						<th >configuration</th>
						<th >Asset code</th>
						<th >IP</th>
						<th >MS Office</th>
						<th >License software</th>
						<th >Internet</th>
						<th >type</th>
						<th >Date</th>
						<th >Other IT asset</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

	<!--<div id="combinedlist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="listCombined">
				<thead>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
						<th >Hardware</th>
						<th >Make</th>
						<th >Model</th>
						<th >CPU no.</th>
						<th >Monitor</th>
						<th >CRT/TFT no.</th>
						<th >configuration</th>
						<th >Asset code</th>
						<th >IP</th>
						<th >MS Office</th>
						<th >License software</th>
						<th >Internet</th>
						<th >type</th>
						<th >Date</th>
						<th >Other IT asset</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				</tbody>
			</table>
	</div>-->
	<div id="networklist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="listNetwork">
				<thead>
					<tr>
						<th >Serial</th>
						<th >Department</th>
						<th >Item</th>
						<th >Make</th>
						<th >Model</th>
						<th >Serial</th>
						<th >Quantity</th>
						<th >Type</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
