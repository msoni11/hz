<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>
<!-- Content start -->
<div id="container" class="box1">
	<div id="centralImage">
		<img src="../images/logo.gif" /><h1>INVENTORY MANAGEMENT SYSTEM</h1>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>
