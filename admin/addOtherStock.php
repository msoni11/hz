<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="newhardareentry" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add Stock</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="txtadddepartment" id = "txtadddepartment"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'" >'.$db->RowData['name'].'</option>';
							} 
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$otherhardware)."')");
				?>
				<div class="text-box-field">
					<select name="txtaddotherhardware" id = "txtaddotherhardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php 
						/*foreach ( $hardware_array as $harray ) { 
							echo  '<option value="'.strtoupper($harray).'">'.strtoupper($harray).'</option>';
						}*/
						?>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="addhardwaretext" style="display:none"><input type="text" name="txtaddhardwaretext" id="txtaddhardwaretext" value="" class="form-text" size="30" maxlength="2048"></div></div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtaddothermake" id = "txtaddothermake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="addmaketext" style="display:none"><input type="text" name="txtaddmaketext" id="txtaddmaketext" value="" class="form-text" size="30" maxlength="2048"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="txtaddothermodel" id = "txtaddothermodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="addmodeltext" style="display:none"><input type="text" name="txtaddmodeltext" id="txtaddmodeltext" value="" class="form-text" size="30" maxlength="2048"></div></div>
				
				<div class="text-box-name">Invoice number:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddinvoice" id="txtaddinvoice" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Date:</div>
				<div class="text-box-field">
					<select name="txtaddday" id = "txtaddday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtaddmonth" id = "txtaddmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtaddyear" id = "txtaddyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Party Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddpartyname" id="txtaddpartyname" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Name of receiver:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddreceivername" id="txtaddreceivername" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Quantity:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddquantity" id="txtaddquantity" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Rate:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddrate" id="txtaddrate" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field">Ex.: 45622.22</div>

				<div class="text-box-name">Other Status:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddotherstatus" id="txtaddotherstatus" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<input type="button" name="newotherentry" id="newotherentry" value="Submit" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtstockreset" id="txtstockreset" value="Reset" style="width:80px; height:30px;" />
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
