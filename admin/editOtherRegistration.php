<?php
include 'includes/_incHeader.php';
$db = new cDB();

$hardware_array = explode(',', $hardware);
$make_array = explode(',', $make);
$monitor_array = explode(',', $monitor);
$unitcode = 'HZL/CZ/';
$assetcode = explode(',', $assetcode);
$msoffice_array = explode(',', $msoffice);
$amcwar_array = explode(',', $amcwar);

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != '1' ) {
	header("Location:logout.php");
}
$id = base64_decode($_REQUEST['id']);
$db->Query("SELECT hze.*,hzr.* FROM hz_employees hze LEFT OUTER JOIN hz_otherregistration hzr ON (hze.empid = hzr.empid)  WHERE hzr.id=".$id." LIMIT 1");
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$empid          = $db->RowData['empid'];
		$empname        = $db->RowData['empname'];
		$unit       	= $db->RowData['unit'];
		$department     = $db->RowData['department'];
		$designation    = $db->RowData['designation'];
		$edithardware   = $db->RowData['hardware'];
		$editmake       = $db->RowData['make'];
		$model          = $db->RowData['model'];
		$receivername   = $db->RowData['receivername'];
		$date      = getdate($db->RowData['issuedate']);
		$issuedby       = $db->RowData['issuedby'];
		$otherstatus    = $db->RowData['otherstatus'];
	}
}
?>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="regeditform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Edit Registration</legend>
				<input type="hidden" name="txtregid" id="txtregid" value="<?php echo $id; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC"/>				
				
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Employee ID:</div>
				<div class="text-box-field">
					<input type="text" name="txtregempid" id="txtregempid" value="<?php echo $empid?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC"/>				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtempname" id="edittxtempname" value="<?php echo $empname?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Unit:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtunit" id="edittxtunit" value="<?php echo $unit?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtdepartment" id="edittxtdepartment" value="<?php echo $department?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC" />				
				</div>
				<div class="text-box-field"></div>


				<div class="text-box-name">Designation:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtdesignation" id="edittxtdesignation" value="<?php echo $designation?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Hardware:</div>
				<?php
				$otherselected = false;
				$db->Query("SELECT * FROM hz_hardware WHERE name IN ('".str_replace(',','\',\'',$otherhardware)."')");
				?>
				<div class="text-box-field">
					<select name="txtotherithardware" id = "txtotherithardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php
						$hwtemp = true;
						if (isset($edithardware)) {
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($edithardware)) {
										$hwselected = 'selected';
										$hwtemp = false;
									} else {
										$hwselected = '';
									}
									echo '<option value="'.($db->RowData['id']).'" '.$hwselected.'>'.$db->RowData['name'].'</option>';
								} 
							}
						}

						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtotheritmake" id = "txtotheritmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select----</option>
						<?php 
						$maketemp = true;
						if (isset($editmake)) {
							$db->Query("SELECT * FROM hz_make WHERE hw_id=".$edithardware);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($editmake)) {
										$makeselected = 'selected';
										$maketemp = false;
									} else {
										$makeselected = '';
									}
									echo '<option value="'.($db->RowData['id']).'" '.$makeselected.'>'.$db->RowData['name'].'</option>';
								}
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="txtotheritmodel" id = "txtotheritmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<?php 
						$modelotherselected = false;
						$modeltemp = true;
						if (isset($model)) {
							$db->Query("SELECT * FROM hz_model WHERE make_id=".$editmake);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($model)) {
										$modelselected = 'selected';
										$modeltemp = false;
									} else {
										$modelselected = '';
									}
									echo '<option value="'.($db->RowData['id']).'" '.$modelselected.'>'.$db->RowData['modelname'].'</option>';
								}
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field">
				</div>
				
				<div class="text-box-name">Receiver Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtotheritreceivername" id="txtotheritreceivername" value="<?php if(isset($receivername)) { echo $receivername; } ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issue Date:</div>
				<div class="text-box-field">
					<select name="txtotheritday" id = "txtotheritday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) {
							$dayselected = ($date['mday']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$dayselected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtotheritmonth" id = "txtotheritmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							$monthselected = ($date['mon']==$i) ? 'selected = selected' : '';
							echo '<option value="'.$i.'" '.$monthselected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtotherityear" id = "txtotherityear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							$yearselected = ($date['year']==$i) ? 'selected = selected' : '';
							echo '<option value="'.$i.'" '.$yearselected.'>'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issued By:</div>
				<div class="text-box-field">
					<input type="text" name="txtotheritissuedby" id="txtotheritissuedby" value="<?php if (isset($issuedby)) { echo $issuedby; }?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Other Status:</div>
				<div class="textarea-box-field">
					<textarea name="txtotheritstatus" id="txtotheritstatus" class="form-text" size="30" maxlength="2048" rows="5" /><?php if(isset($otherstatus)) { echo $otherstatus; } ?></textarea>				
				</div>
				<div class="textarea-box-field" ></div>
				
				<?php 
				if (!$hwotherselected) {
					if ($hwidselected == 3) { 
						echo "<script>$('#editcartagediv').show();</script>";
						echo "<script>$('#editprintertypediv').show();</script>";
					} else {
						echo "<script>$('#editcartagediv').hide();</script>";
						echo "<script>$('#editprintertypediv').hide();</script>";
					}
				}
				?>

				<input type="button" name="editotherregbtn" id="editotherregbtn" value="Update" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:80px; height:30px;margin-left:5px" onclick="window.location = 'lists/listConsumable.php'" /> 
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
