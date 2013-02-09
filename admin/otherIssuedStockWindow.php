<?php 
include '../includes/Application.php';
	$db = new cDB();
	$hwid    = $_GET['hwid'];
	$makeid  = $_GET['makeid'];
	$modelid = $_GET['modelid'];
	$db->Query("
	SELECT he.empid empid, he.empname empname, he.unit unit, he.department department, he.designation designation
	FROM `hz_otherregistration` hs
	LEFT OUTER JOIN hz_employees he ON ( hs.empid = he.empid )
	WHERE hs.hardware = $hwid AND hs.make = $makeid AND hs.model = $modelid AND activestatus = 'A'
	");
?>
<!DOCTYPE html PUBLIC '//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta name="description" />
<meta name="keywords" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="../styles/TableTools.css" rel="stylesheet" type="text/css" />
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src='../js/jquery-1.7.2.min.js'></script>
<script type=text/javascript src='../js/jquery.dataTables.js'></script>
<script type=text/javascript src='../js/ZeroClipboard.js'></script>
<script type=text/javascript src='../js/TableTools.js'></script>
<title>Hindustan Zinc Limited</title>
<script type="text/javascript">
$(document).ready( function () {
	var oTable = $('#ListAvailStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
});

</script>
</head>
<body>

<?php
/*if (!isset($_SESSION['username'])) {
header("Location:logout.php");
}*/
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>


<!-- Content start -->
<div id="container-2" class="box1">
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListAvailStock">
		<thead>
			<tr>
				<th >Empid</th>
				<th >Empname</th>
				<th >Unit</th>
				<th >Department</th>
				<th >Designation</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		if ($db->RowCount){
			while ($db->ReadRow()) {
				echo "<tr>";
				echo "<td>".$db->RowData['empid']."</td>";
				echo "<td>".$db->RowData['empname']."</td>";
				echo "<td>".$db->RowData['unit']."</td>";
				echo "<td>".$db->RowData['department']."</td>";
				echo "<td>".$db->RowData['designation']."</td>";
				echo "</tr>";
			}
		}

		?>

		</tbody>

	</table>
</div>
 </body>
</html>
