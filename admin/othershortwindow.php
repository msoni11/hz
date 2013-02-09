<?php 
include '../includes/Application.php';
	$db = new cDB();
		if ((isset($_GET['dept'])) && (isset($_GET['hwid'])) && (isset($_GET['unitid'])) && (isset($_GET['datefrom'])) && (isset($_GET['dateto']))) {
			$dept      = $_GET['dept'];
			$hwid      = $_GET['hwid'];
			$unit      = $_GET['unitid'];
			$startdate = $_GET['datefrom'];
			$enddate   = $_GET['dateto'];
		}
		$db->Query("SELECT name FROM hz_hardware WHERE id=".$hwid);
		if ($db->RowCount) {
			if ($db->ReadRow()) {
				$hwname = $db->RowData['name'];
			}
		}
		$WHERE = '';
		if ($dept != '') {
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "department='$dept'";
		}
		if ($unit != '') {
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "unit='$unit'";
		}
		if ($hwid != '') {
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "hardware='$hwid'";
		}
		if (($startdate != '') && ($enddate != '')) {
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "date BETWEEN '$startdate' AND '$enddate' ";
		}
		
		$myQuery = "SELECT hr.hardware hardware, hs.department department, hs.unit unit, hs.empname,hs.empid,hs.designation
						FROM `hz_otherregistration` hr
						LEFT OUTER JOIN hz_employees hs ON ( hr.empid = hs.empid )
						LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
						$WHERE";
		
		$db->Query($myQuery);


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
		"sDom": 'T<"clear">lrtip',
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
<body style="background:#e5e5e5">

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
	<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListAvailStock" style="text-align:center">
		<thead>
			<tr>
				<td></td>
				<td></td>
				<td align="center">
					<?php echo 'Unit: <b>'.$unit.'</b>'; ?>
				</td>
				<td></td>
				<td></td>
			</tr>		
			<?php if ($dept != '') { ?>
			<tr>
				<td></td>
				<td></td>
				<td align="center">
					<?php echo 'Department: <b>'.$dept.'</b>'; ?>
				</td>
				<td></td>
				<td></td>
			</tr>
			<?php } ?>			
			<tr>
				<td></td>
				<td></td>
				<td align="center">
					<?php echo 'Hardware: <b>'.$hwname.'</b>'; ?>
				</td>
				<td></td>
				<td></td>
			</tr>		
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>		
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