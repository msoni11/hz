<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}

$admin = ($_SESSION["adminid"]) ? $_SESSION["adminid"]: "6";
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
                <input type="text" disabled="disabled" value="IT" class="form-text" /> 
					<select name="txtadddepartment" id = "txtadddepartment"  class="form-text" style="width:91%;display: none;" >
						<option value='2'>----Select Department----</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name NOT IN('".str_replace(',','\',\'',$otherhardware)."')");
				?>
				<div class="text-box-field">
					<select name="txtaddhardware" id = "txtaddhardware"  class="form-text" style="width:91%" >
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

				<div class="text-box-name">Type:</div>
				<div class="text-box-field">
					<select name="txtaddprintertype" id = "txtaddprintertype"  class="form-text" style="width:91%" >
					</select>
				</div>
				<div class="text-box-field"><div id="addprintertypetext" style="display:none"><input type="text" name="txtaddprintertypetext" id="txtaddprintertypetext" value="" class="form-text" size="30" maxlength="2048"></div></div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtaddmake" id = "txtaddmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="addmaketext" style="display:none"><input type="text" name="txtaddmaketext" id="txtaddmaketext" value="" class="form-text" size="30" maxlength="2048"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="txtaddmodel" id = "txtaddmodel"  class="form-text" style="width:91%" >
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
				<div class="text-box-field"></div>

				<div class="text-box-name">Other Status:</div>
				<div class="text-box-field">
					<input type="text" name="txtaddotherstatus" id="txtaddotherstatus" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Entry Type:</div>
				<div class="text-box-field">
					<select name="txtaddentrytype" id = "txtaddentrytype"  class="form-text" style="width:91%" >
						<option value='NEW'>NEW</option>
						<option value='TRANSFER'>TRANSFER</option>
					</select>
				</div>
				<div class="text-box-field"></div>
                <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin; ?>" /> 
				<input type="button" name="newentry" id="newentry" value="Submit" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtstockreset" id="txtstockreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->
                <div id="form-container">
                <div id="space_for_table"></div>
                <div style="clear:both;text-align:center;"><input id="continue" type="button" name="continue" value="Continue" style="width:80px; height:30px;"/>
                <input id="cancel" type="button" name="cancel" value="Cancel" style="width:80px; height:30px;" onclick="hide_popup();"/></div>
                
                
                </div>
			</form>
		</div>
	</div>
</div>
<div id="black_bg"></div>
<!-- Content End -->

<?php
include '../includes/_incFooter.php';
?>
