<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != '1' ) {
	header("Location:logout.php");
}

if (isset($_REQUEST['id'])) {
	$empid = base64_decode($_REQUEST['id']);
	$db->Query("SELECT * FROM hz_employees WHERE empid=".$empid);
	if ($db->RowCount) {
		if ($db->ReadRow()) {
			$empname        = $db->RowData['empname'];
			$unit           = $db->RowData['unit'];
			$department     = $db->RowData['department'];
			$designation    = $db->RowData['designation'];
		}
	}
} else {
	echo "<br />";
	echo "ID parameter is missing! <a href='listEmployees.php' >Go back </a>";
	die();
}
?>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="empform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add Employee</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Employee ID:</div>
				<div class="text-box-field">
					<input type="text" name="editxtempid" id="edittxtempid" value="<?php echo $empid; ?>" class="form-text" size="30" maxlength="2048" style="background:#CCCCCC" disabled="disabled" />
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtempname" id="edittxtempname" value="<?php echo $empname; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Unit:</div>
				<?php 
				$db->Query("SELECT * FROM hz_units");
				?>
				<div class="text-box-field">
					<select name="edittxtunit" id = "edittxtunit"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Unit----</option>
						<?php
						$unittemp = true;
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								if (strtoupper($unit) == strtoupper($db->RowData['name'])) {
									$unitselected = 'selected';
									$unittemp = false;
								} else {
									$unitselected = '';
								}
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'" '.$unitselected.'>'.$db->RowData['name'].'</option>';
							} 
						}
							if ($unittemp) {
								echo "<option value='0' selected>Other</option>";
							} else {
								echo "<option value='0'>Other</option>";
							}
						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php if ($unittemp) {?>
					<div id="editunittext">
						<input type="text" name="edittxtunittext" id="edittxtunittext" value="<?php echo $unit; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id="editunittext" style="display:none">
						<input type="text" name="edittxtunittext" id="edittxtunittext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="edittxtdepartment" id = "edittxtdepartment"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						$depttemp = true;
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								if (strtoupper($department) == strtoupper($db->RowData['name'])) {
									$deptselected = 'selected';
									$depttemp = false;
								} else {
									$deptselected = '';
								}
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'" '.$deptselected.'>'.$db->RowData['name'].'</option>';
							} 
						}
							if ($depttemp) {
								echo "<option value='0' selected>Other</option>";
							} else {
								echo "<option value='0'>Other</option>";
							}
						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php if ($depttemp) { ?>
					<div id = "editdepartmenttext">
						<input type="text" name="edittxtdepartmenttext" id="edittxtdepartmenttext" value="<?php echo $department?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id = "editdepartmenttext" style="display:none">
						<input type="text" name="edittxtdepartmenttext" id="edittxtdepartmenttext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>

				<div class="text-box-name">Designation:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtdesignation" id="edittxtdesignation" value="<?php echo $designation?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				
				<input type="button" name="editempbtn" id="editempbtn" value="update" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:80px; height:30px;margin-left:5px" onclick="window.location = 'lists/listEmployee.php'" /> 
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->

	
<?php
include '../includes/_incFooter.php';
?>
