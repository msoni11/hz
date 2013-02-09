<?php
$hardware_array = explode(',', $hardware);
$make_array = explode(',', $make);
$monitor_array = explode(',', $monitor);
$unitcode = 'HZL/CZ/';
$assetcode = explode(',', $assetcode);
$msoffice_array = explode(',', $msoffice);
$amcwar_array = explode(',', $amcwar);
?>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="regform" action="#" method="post" onSubmit="return false;">				<fieldset><legend>Registration</legend>
				
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Employee ID:</div>
				<div class="text-box-field">
					<input type="text" name="txtregempid" id="txtregempid" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				<div id="hideEmpDetails" style="display:none">
				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtempname" id="txtempname" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Unit:</div>
				<?php 
				$db->Query("SELECT * FROM hz_units");
				?>
				<div class="text-box-field">
					<select name="txtunit" id = "txtunit"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Unit----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="unittext"></div></div>

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="txtdepartment" id = "txtdepartment"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id = "departmenttext"></div></div>

				<div class="text-box-name">Designation:</div>
				<div class="text-box-field">
					<input type="text" name="txtdesignation" id="txtdesignation" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				</div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$otherhardware)."')");
				?>
				<div class="text-box-field">
					<select name="txtotherithardware" id = "txtotherithardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<!--<option value='0'>Other</option>-->
					</select>
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtotheritmake" id = "txtotheritmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="txtotheritmodel" id = "txtotheritmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
					</select>
				</div>
				<div class="text-box-field"><div id="modeltext"></div></div>
				
				<div class="text-box-name">Receiver Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtotheritreceivername" id="txtotheritreceivername" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issue Date:</div>
				<div class="text-box-field">
					<select name="txtotheritday" id = "txtotheritday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtotheritmonth" id = "txtotheritmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtotherityear" id = "txtotherityear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issued By:</div>
				<div class="text-box-field">
					<input type="text" name="txtotheritissuedby" id="txtotheritissuedby" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Other Status:</div>
				<div class="textarea-box-field">
					<textarea name="txtotheritstatus" id="txtotheritstatus" value="" class="form-text" size="30" maxlength="2048" rows="5" /></textarea>				
				</div>
				<div class="textarea-box-field" ></div>
				
				<input type="button" name="newotherregbtn" id="newotherregbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtregreset" id="txtregreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- Content End -->