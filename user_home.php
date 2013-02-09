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
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="REQUEST ASSET" onclick="window.location='request_asset.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="TRANSFER ASSET"  onclick="window.location='transfer_request.php'"></li>
		<li><input style="width:200px; height:50px; cursor:pointer" type="button" value="ASSER LIST" onclick="window.location='asset_list.php'"></li>
	</ul>
	</div>
	</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>
