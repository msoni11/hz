<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
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
					<input type="text" name="txtempid" id="txtempid" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
				
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
				
				<input type="button" name="newempbtn" id="newempbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtempreset" id="txtempreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
