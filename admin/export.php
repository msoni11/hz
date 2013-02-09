<?php 
if (isset($_POST['excelimport']) && $_POST['excelimport'] != '') {
    $filename = "PPE_Report_" . date('d/m/y') . ".xls"; 

    header("Content-Disposition: attachment; filename=\"$filename\""); 

    header("Content-Type: application/vnd.ms-excel"); 

	$array = json_decode($_REQUEST['tabledata']);   
	$headarray = json_decode($_REQUEST['tableheaddata']);   

	if (is_array($headarray) && is_array($array)) {
		echo   "<table border='1'>";
		foreach ($headarray as $arr) {
			echo   "<tr style=color:white>";
				for ($i=0;$i<count($arr);$i++){
					echo  "<th bgcolor=brown>".$arr[$i]."</th>";
				}
			echo   "</tr>";
		}
		foreach ($array as $arr) {
			echo "<tr>";
			for ($i=0;$i<count($arr);$i++){
				echo  "<td>".$arr[$i]."</td>";
			}
			echo "</tr>";
		}
		}
}
?>