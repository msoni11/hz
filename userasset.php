<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 0) {
	header("Location:logout.php");
}

include 'userassetForm.php';
include 'includes/_incFooter.php';
?>
