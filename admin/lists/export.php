<?php
include '../includes/Application.php';

    $filename = "PPE_Report_" . date('d/m/y') . ".xls"; 

    //header("Content-Disposition: attachment; filename=\"$filename\""); 

    //header("Content-Type: application/vnd.ms-excel"); 

   
    
$db = new cDB();
$db->Query('SELECT * FROM hz_employees');    
$c=0;
 echo "<table border>
		<tr bgcolor=brown style=color:white>
			<th>Emp id</th>
			<th>Emp name</th>
			<th>Unit</th>
			<th>Department</th>
			<th>Designation</th></tr>";

    while($db->ReadRow()) {

        $c++;   
        $empid = $db->RowData['empid'];
        $empname = $db->RowData['empname']; 
        $unit = $db->RowData['unit'];;
        $department = $db->RowData['department'];;
        $designation = $db->RowData['designation'];;

        echo "<tr>
				<td>$empid</td>
				<td>$empname</td>
				<td>$unit</td>
				<td>$department</td>
				<td>$designation</td></tr>";
	}
echo"</table>";
?>











