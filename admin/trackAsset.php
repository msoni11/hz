<?php
include '../includes/Application.php';

$serno = $_REQUEST['serno'];
if (!isset($_SESSION['username'])) {
	echo "101"; // Session expires! Login again
	die;
} else if (isset($serno) && $serno != '') {
	$db= new cDB();
	$db1= new cDB();
	$db->Query("SELECT * FROM hz_products hp,hz_stock hs WHERE hp.stockID=hs.id AND hp.serial='".$serno."'");
	if ($db->RowCount) {
		if ($db->ReadRow()) {
			$resultarr = $db->RowData;
		}
		$db1->Query("SELECT * FROM hz_registration WHERE cpuno=".$resultarr['productID']." OR monitorno=".$resultarr['productID']." ORDER by id ASC");
		if ($db1->RowCount) {
			while ($db1->ReadRow()){
				$regarrs[] = $db1->RowData;
			}
		}
	} else {
		echo '103'; //No records found		
	}
} else {
	echo "104"; //Reload Page
}
$orderdate = getdate($resultarr['orderdate']);
$viewOrderDate = $orderdate['mday'].'/'.$orderdate['mon'].'/'.$orderdate['year'];
?>
<?php if ($resultarr) {
	echo "<fieldset><legend>Asset Verification</legend>";
		echo "<table style='text-align:left;width:98%' border=1 bordercolor='#c0c0c0'>";
			echo "<tr><th>Stock Entry Date : </th><th colspan='2'>".$viewOrderDate."</th></tr>";
			$i = 1;
			if ($regarrs) {
				foreach ($regarrs as $regarr) {
					$issuedate = getdate($resultarr['orderdate']);
					$viewIssueDate = $issuedate['mday'].'/'.$issuedate['mon'].'/'.$issuedate['year'];
					echo "<tr><th colspan='3' style='text-align:center'> <img src='images/collection_hover.png'></th></tr>";
					echo "<tr><th>".$i."'st Allotment</th><th>".$regarr['empid']."</th><th>".$viewIssueDate."</th></tr>";
					$i++;
				}
			}
			if ($resultarr['status'] == 1 && empty($regarrs)) {
				echo "<tr><th colspan='3' style='text-align:center'> <img src='images/collection_hover.png'></th></tr>";
				echo "<tr><th colspan='3'>Asset never alloted to any employee!</th></tr>";
			} else if ($resultarr['status'] == 2) {
				echo "<tr><th colspan='3' style='text-align:center'> <img src='images/collection_hover.png'></th></tr>";
				echo "<tr><th colspan='3'>Asset available in store!</th></tr>";
			} else if ($resultarr['status'] == 3) {
				echo "<tr><th colspan='3' style='text-align:center'> <img src='images/collection_hover.png'></th></tr>";
				echo "<tr><th colspan='3'>Asset sent to scrap!</th></tr>";
			}
		echo "</table>";
	echo "</fieldset>";
}
?>