<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}

include '../otherUserassetForm.php';
include 'includes/_incFooter.php';
?>