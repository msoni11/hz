<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}

include '../userassetForm.php';
include 'includes/_incFooter.php';
if (isset($_REQUEST['uname'])){
	echo '<script type="text/javascript">hz_getEmployeeDetails();</script>';
}
?>
