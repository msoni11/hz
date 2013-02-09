<?php
include '../includes/_incHeader2.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}

	$db = new cDB();
		//$flag = true;
		$deptflag = false;
		//$unitflag = false;
		$hwflag = false;
		//$flag = true;
	if (isset($_POST['dosearch']) && $_POST['dosearch'] != 'dosearch') {
		$WHERE   = '';
		$FROM    = '';
		$ORDERBY = '';
		$GROUPBY = '';
		if ($_POST['txtdepartment'] == '-1' ) {
			$deptflag = true;
			$hwflag = true;
			$FROM  = "hh.id hwid,hh.name hardware,hd.name department";
			$ORDERBY  = 'ORDER BY department';
			$GROUPBY  = 'GROUP BY department,hardware';
		}

		if (isset($_POST['txtdepartment']) && $_POST['txtdepartment'] != '-1') {
			$deptflag = true;
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "hd.name = '".$_POST['txtdepartment']."' ";
			$FROM  = "hh.id hwid,hh.name hardware,hd.name department";
			$ORDERBY  = 'ORDER BY department';
			$GROUPBY  = 'GROUP BY department';
		}

		if (isset($_POST['txthardware']) && $_POST['txthardware'] != '-1') {
			$hwflag = true;
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "hardware = '".$_POST['txthardware']."' ";
			if ($deptflag) {
				$ORDERBY  .= ',hardware';
				$GROUPBY  .= ',hardware';
			} else {
				$FROM  = "hh.id hwid,hh.name hardware";
				$ORDERBY  = 'ORDER BY hardware';
				$GROUPBY  = 'GROUP BY hardware';
			}
		}

		if (((isset($_POST['txtstartday']) && $_POST['txtstartday'] != '-1') && (isset($_POST['txtstartmonth']) && $_POST['txtstartmonth'] != '-1') && (isset($_POST['txtstartyear']) && $_POST['txtstartyear'] != '-1'))
			&& ((isset($_POST['txtendday']) && $_POST['txtendday'] != '-1') && (isset($_POST['txtendmonth']) && $_POST['txtendmonth'] != '-1') && (isset($_POST['txtendyear']) && $_POST['txtendyear'] != '-1'))) {
			$startdate = mktime(0,0,0,$_POST['txtstartmonth'],$_POST['txtstartday'],$_POST['txtstartyear']);
			$enddate   = mktime(0,0,0,$_POST['txtendmonth'],$_POST['txtendday'],$_POST['txtendyear']);
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "date BETWEEN '$startdate' AND '$enddate' ";
			if (($deptflag)) {
			} else {
				$FROM  = "hh.id hwid,hh.name hardware,hd.name department";
				$deptflag = true;
				$hwflag   = true;
			}
		}

		/*if ($WHERE == '') {
			$WHERE = 'WHERE ';
		} else {
			$WHERE .= ' AND ';
		}
		$WHERE .= "hr.activestatus IN('A','T')";
		*/
		$myquery = "SELECT a.*, count(hardware) total FROM (
		SELECT $FROM
				FROM `hz_criticalregistration` hr
				LEFT OUTER JOIN hz_departments hd ON ( hr.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
				$WHERE )a $GROUPBY $ORDERBY";
	} else {
		$deptflag = true;
		$unitflag = true;
		$hwflag   = true;
		$myquery = "SELECT a.*, count(hardware) total FROM (
		SELECT hh.id hwid,hh.name hardware,hd.name department
				FROM `hz_criticalregistration` hr
				LEFT OUTER JOIN hz_departments hd ON ( hr.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
				)a GROUP BY department,hardware ORDER BY department";
	}
	$db->Query($myquery);

?>
<script type="text/javascript">
$(document).ready( function () {
	$('#crystemplist').show();
	$('#crystListEmployees').dataTable( {
		"sDom": 'T<"clear">lfrtip',
				"bProcessing": false,
				"bServerSide":true,
				"bFilter":false,
				"iDisplayStart":0,
				"iDisplayLength":10,
				"sPaginationType": "full_numbers",
				"sAjaxSource": "../ajax/ajax_emp.php",
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
	} );
} );
</script>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div id="crystemplist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="crystListEmployees">
				<thead>
				<tr>
					<th colspan ="5" align="center"><table align="center"><tr><td><img src="../images/logo.gif" height = "130" width = "130" class="imgset" /></td><td><h2>Hindustan Zinc Limited</h2><br />smelter, chanderia</td></tr></table></th>
				</tr>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>
</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
