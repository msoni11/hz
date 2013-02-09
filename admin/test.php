<?php
$date = getdate(1337452200);
print_r($date);
die;
include '../includes/Application.php';
$db = new cDB();
$db->Query("SELECT SUM( quantity ) total
FROM hz_stock hs
LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
GROUP BY hardware, make, model");

if ($db->RowCount) {
	while ($db->ReadRow()) {
		echo $db->RowData['total'];
		echo "<br />";
	} 
} else {
}
die;
$mktim = mktime(0,0,0,1,2,2012);
$date = getdate(1337452200);
print_r($date);
die;
$regasset = "abc/dv/dc";
$regassettext = "adsf/dsf/adf";
echo $regasset = $regasset.'/'.$regassettext;
die;
include '../includes/Application.php';
$db = new cDB();
$regempid = 112233;
echo $sqlselect = "SELECT * FROM hz_employees WHERE empid=".$regempid;
$db->Query($sqlselect);
if ($db->RowCount){
	if ($db->ReadRow()) {
		echo $db->RowData['empname'];
	}
}
echo			$sql = "INSERT INTO hz_users(username,password,isadmin) 
					VALUES('".$uname."','".$password."')";

?>