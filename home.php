<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 0) {
	header("Location:logout.php");
}
?>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
	<div id="center">
	<div style="padding:0px 0px 0px 210px">
	<ul style="list-style-type:none">
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="EMPLOYEE" onclick="window.location='addEmployee.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="IT ASSET"  onclick="window.location='userasset.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="NETWORK" onclick="window.location='addNetwork.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="EMPLOYEE LIST" onclick="window.location='listEmployees.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="CHANGE PASSWORD" onclick="window.location='updateProfile.php'"></li>
	</ul>
	</div>
	</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>
