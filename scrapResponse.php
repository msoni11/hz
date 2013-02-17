<?php
include 'includes/_incHeader.php';
$db = new cDB();
$db1 = new cDB();
$db2 = new cDB();
$db3 = new cDB();
$resultarr = array();
$db1->Query('SELECT * FROM hz_scraps WHERE ScrapID='.$_REQUEST['request_id']);
if ($db1->RowCount) {
	if ($db1->ReadRow()) {
		$scraparr = $db1->RowData;
	}
}
$db1->Query('SELECT * FROM hz_products WHERE ProductID='.$scraparr['ProductID']);
if ($db1->RowCount) {
	if ($db1->ReadRow()) {
		$productarr = $db1->RowData;
	}
}
if(isset($_REQUEST['gmScrapApproved']) && isset($_REQUEST['request_id']) && $_REQUEST['request_id'] >0 ) {
	if ($_REQUEST['gmScrapApproved'] == 0) { //Rejected
		if ($scraparr['status'] !=1) {
			if ($scraparr['status'] != 2) {
				if ($db2->Query('UPDATE hz_scraps SET status=2 WHERE ScrapID='.$scraparr['ScrapID'])){
					echo "<div style='text-align:center;min-height:300px;'><h2>You have rejected to move asset to scrap.</p></div>";
				}
			} else {
				echo "<div style='text-align:center;min-height:300px;'><h2>You have already rejected this asset to move to scrap.</p></div>";
			}
		} else {
			echo "<div style='text-align:center;min-height:300px;'><h2>You can't reject now as you have already accepted this asset to move to scrap.</p></div>";
		}
	} else if ($_REQUEST['gmScrapApproved'] == 1) {
		if ($scraparr['status'] !=2) {
			if ($scraparr['status'] != 1) {
				if($db2->Query('UPDATE hz_scraps SET status=1 WHERE ScrapID='.$scraparr['ScrapID'])){
					if ($productarr['status'] != 3) {
						if($db2->Query('UPDATE hz_products SET status=3 WHERE productID='.$productarr['productID'])){
							echo "<div style='text-align:center;min-height:300px;'><h2>You have acceptd to move asset to scrap.</p></div>";
						}
					} else {
						echo "<div style='text-align:center;min-height:300px;'><h2>You have already accepted this asset to move to scrap.</p></div>";
					}
				}
			} else {
				echo "<div style='text-align:center;min-height:300px;'><h2>You have already accepted this asset to move to scrap.</p></div>";
				if ($productarr['status'] != 3) {
					$db2->Query('UPDATE hz_products SET status=3 WHERE productID='.$productarr['productID']);
				}
			}
		} else {
			echo "<div style='text-align:center;min-height:300px;'><h2>You can't accept now as you have already rejected this asset to move to scrap.</p></div>";
		}
	}
}
?>