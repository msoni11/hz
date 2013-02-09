<?php
include 'includes/_incHeader1.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>
<?php 
	$db = new cDB();
		//$flag = true;
		$deptflag = false;
		$unitflag = false;
		$hwflag = false;
		//$flag = true;
	if (isset($_POST['dosearch']) && $_POST['dosearch'] != 'dosearch') {
		$WHERE   = '';
		$FROM    = '';
		$ORDERBY = '';
		$GROUPBY = '';
		if ($_POST['txtdepartment'] == '-1' && $_POST['txtunit'] == '-1') {
			$deptflag = true;
			$unitflag = true;
			$hwflag = true;
			$FROM  = "hh.id hwid,hh.name hardware,hs.department, hs.unit";
			$ORDERBY  = 'ORDER BY department';
			$GROUPBY  = 'GROUP BY department,unit,hardware';
		}

		if (isset($_POST['txtdepartment']) && $_POST['txtdepartment'] != '-1') {
			$deptflag = true;
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "department = '".$_POST['txtdepartment']."' ";
			$FROM  = "hh.id hwid,hh.name hardware,hs.department";
			$ORDERBY  = 'ORDER BY department';
			$GROUPBY  = 'GROUP BY department';
		}

		if (isset($_POST['txtunit']) && $_POST['txtunit'] != '-1') {
			$unitflag = true;
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "unit = '".$_POST['txtunit']."' ";
			if ($deptflag) {
				$FROM  .= ",hs.unit";
				$ORDERBY  .= ',unit';
				$GROUPBY  .= ',unit';
				//$flag = false;
			} else {
				$FROM  = "hh.id hwid,hh.name hardware, hs.unit";
				$ORDERBY  = 'ORDER BY unit';
				$GROUPBY  = 'GROUP BY unit';
			}
		}

		if (isset($_POST['txthardware']) && $_POST['txthardware'] != '-1') {
			$hwflag = true;
			if ($WHERE == '') {
				$WHERE = 'WHERE ';
			} else {
				$WHERE .= ' AND ';
			}
			$WHERE .= "hardware = '".$_POST['txthardware']."' ";
			if (($unitflag) || ($deptflag) || ($deptflag && $unitflag)) {
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
			if (($unitflag) || ($deptflag) || ($deptflag && $unitflag)) {
			} else {
				$FROM  = "hh.id hwid,hh.name hardware,hs.department,hs.unit";
				$deptflag = true;
				$unitflag = true;
				$hwflag   = true;
			}
		}

		if ($WHERE == '') {
			$WHERE = 'WHERE ';
		} else {
			$WHERE .= ' AND ';
		}
		$WHERE .= "hr.activestatus IN('A','T')";

		$myquery = "SELECT a.*, count(hardware) total FROM (
		SELECT $FROM
				FROM `hz_registration` hr
				LEFT OUTER JOIN hz_employees hs ON ( hr.empid = hs.empid )
				LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
				$WHERE )a $GROUPBY $ORDERBY";
	} else {
		$deptflag = true;
		$unitflag = true;
		$hwflag   = true;
		$myquery = "SELECT a.*, count(hardware) total FROM (
		SELECT hh.id hwid,hh.name hardware,hs.department, hs.unit
				FROM `hz_registration` hr
				LEFT OUTER JOIN hz_employees hs ON ( hr.empid = hs.empid )
				LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
				WHERE hr.activestatus IN('A','T')
				)a GROUP BY department,unit,hardware ORDER BY department";
	}
	$db->Query($myquery);
?>
<script type="text/javascript">
$(document).ready( function () {

	$(document).ready( function () {
	$("#txtadddepartment").change(function(){
		document.forms["mform"].submit();
	});
});

	var oTable = $('#ListStockByDept').dataTable( {
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

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div id="stockbydeptlist" style="padding:50px 0 0 0;display:block;">
		<form name="searchdept" action="stockreportbydepartment.php" method="post">
		<table border="0" id="test">
		<tr>
			<th rowspan="2" width="10%">Filter By Department:</th>
			<th rowspan="2" width="20%">Filter By Unit:</th>
			<th rowspan="2" width="20%">Filter By hardware:</th>
			<th colspan="2" width="50%" >Months between:</th>
		</tr>
		<tr>
			<th>Start:</th>
			<th>End:</th>
		</tr>
		<tr>
			<td>
				<select name="txtdepartment" id = "txtdepartment" >
				<option value='-1'>----Select Department----</option>
				<?php 
				$dbDept = new cDB();
				$dbDept->Query("SELECT * FROM hz_departments");
				if ($dbDept->RowCount) { 
					while ($dbDept->ReadRow()) {
						if (isset($_POST['txtdepartment']) && $_POST['txtdepartment'] != '-1') {
							$selected = ($_POST['txtdepartment'] == $dbDept->RowData['name']) ? 'selected' : '';
						}							
						echo '<option value="'.mysql_real_escape_string($dbDept->RowData['name']).'" '.$selected.'>'.$dbDept->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</td>
			<td>
				<select name="txtunit" id = "txtunit" >
				<option value='-1'>----Select Unit----</option>
				<?php 
				$dbUnit = new cDB();
				$dbUnit->Query("SELECT * FROM hz_units");
				if ($dbUnit->RowCount) { 
					while ($dbUnit->ReadRow()) {
						if (isset($_POST['txtunit']) && $_POST['txtunit'] != '-1') {
							$selected = ($_POST['txtunit'] == $dbUnit->RowData['name']) ? 'selected' : '';
						}							
						echo '<option value="'.mysql_real_escape_string($dbUnit->RowData['name']).'" '.$selected.'>'.$dbUnit->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</td>
			<td>
				<select name="txthardware" id = "txthardware" >
				<option value='-1'>----Select Hardware----</option>
				<?php 
				$dbHW = new cDB();
				$dbHW->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$hardware)."')");
				if ($dbHW->RowCount) { 
					while ($dbHW->ReadRow()) {
						if (isset($_POST['txthardware']) && $_POST['txthardware'] != '-1') {
							$selected = ($_POST['txthardware'] == $dbHW->RowData['id']) ? 'selected' : '';
						}							
						echo '<option value="'.mysql_real_escape_string($dbHW->RowData['id']).'" '.$selected.'>'.$dbHW->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</td>
			<td>
					<select name="txtstartday" id = "txtstartday" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							if (isset($_POST['txtstartday']) && $_POST['txtstartday'] != '-1') {
								$selected = ($_POST['txtstartday'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtstartmonth" id = "txtstartmonth">
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							if (isset($_POST['txtstartmonth']) && $_POST['txtstartmonth'] != '-1') {
								$selected = ($_POST['txtstartmonth'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtstartyear" id = "txtstartyear">
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							if (isset($_POST['txtstartyear']) && $_POST['txtstartyear'] != '-1') {
								$selected = ($_POST['txtstartyear'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
						}
						?>
					</select>

			</td>
			<td>
					<select name="txtendday" id = "txtendday" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							if (isset($_POST['txtendday']) && $_POST['txtendday'] != '-1') {
								$selected = ($_POST['txtendday'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtendmonth" id = "txtendmonth">
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							if (isset($_POST['txtendmonth']) && $_POST['txtendmonth'] != '-1') {
								$selected = ($_POST['txtendmonth'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtendyear" id = "txtendyear" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							if (isset($_POST['txtendyear']) && $_POST['txtendyear'] != '-1') {
								$selected = ($_POST['txtendyear'] == $i) ? 'selected' : '';
							}							
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
						}
						?>
					</select>

			</td>
		</tr>
		<tr><td colspna="4">&nbsp;</td></tr>
		<tr>
			<td colspan="4"><input type="submit" name="dosearch" id="dosearch" value="Search" >&nbsp;<input type="button" name="remfilter" id="remfilter" value="Remove Filter" onclick="window.location='stockreportbydepartment.php';" ></td>
		</tr>
		</table>
		</form>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListStockByDept" style="text-align:center">
			<thead>
				<tr>
					<?php if ($deptflag) { ?>
					<th >Department</th>
					<?php } ?>
					<?php if ($unitflag) { ?>
					<th >Unit</th>
					<?php } ?>
					<?php if ($hwflag) { ?>
					<th >Hardware</th>
					<?php } ?>
					<th >Total</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($db->RowCount) {
				while ($db->ReadRow()) {
					echo '<tr>';
					if ($deptflag) {
						echo '<td>'.$db->RowData['department'].'</td>';
					}
					if ($unitflag) { 
						echo '<td>'.$db->RowData['unit'].'</td>';
					} 
					if ($hwflag) { 
						echo '<td>'.$db->RowData['hardware'].'</td>';
					}
					
					echo '<td><a href="#" onclick="window.open(\'shortwindow.php?hwid='.$db->RowData['hwid'].'&dept='.$db->RowData['department'].'&unitid='.$db->RowData['unit'].'&datefrom='.$startdate.'&dateto='.$enddate.'\',\'\',\'height=800,width=800\')">'.$db->RowData['total'].'</td>';
					echo '</tr>';
				}
			}
			?>

			</tbody>

		</table>
	</div>

</div>
<script>
</script>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
