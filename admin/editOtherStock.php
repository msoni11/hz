<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != '1' ) {
	header("Location:logout.php");
}
$id = base64_decode($_REQUEST['id']);
$db->Query("SELECT * FROM hz_otherstock WHERE id=".$id);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$department     = $db->RowData['department'];
		$hardware       = $db->RowData['hardware'];
		$make           = $db->RowData['make'];
		$model          = $db->RowData['model'];
		$invoiceno      = $db->RowData['invoiceno'];
		$orderdate      = getdate($db->RowData['orderdate']);
		$partyname      = $db->RowData['partyname'];
		$receivername   = $db->RowData['receivername'];
		$quantity       = $db->RowData['quantity'];
		$rate           = $db->RowData['rate'];
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
			<form name="editnetworkform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add Network</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
				<input type="hidden" name="editotherstockhiddenid" id="editotherstockhiddenid" value="<?php echo $id; ?>" class="form-text" size="30" maxlength="2048" />

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="editotherstockdept" id = "editotherstockdept"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						$depttemp = true;
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								if (strtoupper($department) == strtoupper($db->RowData['id'])) {
									$deptselected = 'selected';
									$depttemp = false;
								} else {
									$deptselected = '';
								}
								echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'" '. $deptselected.'>'.$db->RowData['name'].'</option>';
							} 
						}
							/*if ($depttemp) {
								echo "<option value='0' selected>Other</option>";
							} else {
								echo "<option value='0'>Other</option>";
							}*/
						
						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php //if ($depttemp) { ?>
					<!--<div id = "editntwrkdepttext">
						<input type="text" name="editntwrktxtdepttext" id="editntwrktxtdepttext" value="<?php echo $department?>" class="form-text" size="30" maxlength="2048">
					</div>-->
					<?php //} else {?>
					<!--<div id = "editntwrkdepttext" style="display:none">
						<input type="text" name="editntwrktxtdepttext" id="editntwrktxtdepttext" value="" class="form-text" size="30" maxlength="2048">
					</div>-->
					<?php //} ?>
				</div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$otherhardware)."')");
				?>
				<div class="text-box-field">
					<select name="editotherstockhardware" id = "editotherstockhardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php 
						if (isset($hardware)) {
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($hardware)) {
										$hwselected = 'selected';
										$hwidselected = $db->RowData['id'];
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
				<div class="text-box-field"><div id="addhardwaretext" style="display:none"><input type="text" name="txtaddhardwaretext" id="txtaddhardwaretext" value="" class="form-text" size="30" maxlength="2048"></div></div>

				<!--<div class="text-box-name">Type:</div>
				<div class="text-box-field">
					<select name="editotherstockprintertype" id = "editotherstockprintertype"  class="form-text" style="width:91%" >
					<option value='-1'>----Select Printer Type----</option>
					<?php
					if (isset($type) &&  !$hwotherselected) {
						$db->Query("SELECT * FROM hz_printertype WHERE hw_id=".$hwidselected);
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								if (strtoupper($db->RowData['id']) == strtoupper($type)) {
									$printtypeselected = 'selected';
									$printertypeidselected = $db->RowData['id'];
								} else {
									$printtypeselected = '';
								}
								echo '<option value="'.($db->RowData['id']).'" '.$printtypeselected.'>'.$db->RowData['printertype'].'</option>';
							} 
						}
					}

					?>
					</select>
				</div>
				<div class="text-box-field"></div>-->

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="editotherstockmake" id = "editotherstockmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<?php 
						if (isset($make)) {
							$db->Query("SELECT * FROM hz_make WHERE hw_id=".$hwidselected);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($make)) {
										$makeselected = 'selected';
										$mkidselected = $db->RowData['id'];
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
				<div class="text-box-field">
				</div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="editotherstockmodel" id = "editotherstockmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<?php 

						if (isset($model)) {
							if ($hwidselected == 3) {
								$db->Query("SELECT * FROM hz_printermodel WHERE printertype_id=".$printertypeidselected);
								if ($db->RowCount) { 
									while ($db->ReadRow()) {
										if (strtoupper($db->RowData['id']) == strtoupper($model)) {
											$modelselected = 'selected';
											$modelidselected = $db->RowData['id'];
											$modeltemp = false;
										} else {
											$modelselected = '';
										}
										echo '<option value="'.($db->RowData['id']).'" '.$modelselected.'>'.$db->RowData['printermodel'].'</option>';
									}
								}
							} else {
								$db->Query("SELECT * FROM hz_model WHERE make_id=".$mkidselected);
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
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Invoice number:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockinvoice" id="editotherstockinvoice" value="<?php echo $invoiceno; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Date:</div>
				<div class="text-box-field">
					<select name="editotherstockday" id = "editotherstockday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) {
							$dayselected = ($orderdate['mday']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$dayselected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="editotherstockmonth" id = "editotherstockmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							$monthselected = ($orderdate['mon']==$i) ? 'selected = selected' : '';
							echo '<option value="'.$i.'" '.$monthselected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="editotherstockyear" id = "editotherstockyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							$yearselected = ($orderdate['year']==$i) ? 'selected = selected' : '';
							echo '<option value="'.$i.'" '.$yearselected.'>'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>


				<div class="text-box-name">Party Name:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockpartyname" id="editotherstockpartyname" value="<?php echo $partyname; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Name of receiver:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockreceivername" id="editotherstockreceivername" value="<?php echo $receivername; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Quantity:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockquantity" id="editotherstockquantity" value="<?php echo $quantity; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Rate:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockrate" id="editotherstockrate" value="<?php echo $rate; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Other Status:</div>
				<div class="text-box-field">
					<input type="text" name="editotherstockotherstatus" id="editotherstockotherstatus" value="<?php echo $otherstatus; ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<!--<div class="text-box-name">Entry Type:</div>
				<div class="text-box-field">
					<select name="editotherstockentrytype" id = "editotherstockentrytype"  class="form-text" style="width:91%" >
						<?php 
						if (isset($entrytype)) { 
							if ($entrytype == 'NEW'){
								echo '<option value="NEW" selected>NEW</option>';
								echo '<option value="TRANSFER">TRANSFER</option>';
							} else {
								echo '<option value="NEW">NEW</option>';
								echo '<option value="TRANSFER" selected>TRANSFER</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>-->	
				<?php
				if ($hwidselected == 3) { 
					echo "<script>$('#editotherstockprintertype').removeAttr('disabled','disabled');</script>";
				} else {
					echo "<script>";
					echo "$('#editotherstockprintertype').attr('disabled','disabled');";
					echo "$('#editotherstockprintertype').append('<option value=\"0\" selected>NONE</option>')";
					echo "</script>";
				}
				?>

				<input type="button" name="editotherstockbtn" id="editotherstockbtn" value="Update" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:120px; height:30px;margin-left:5px" onclick="window.location = 'lists/listConsumableStock.php'" /> 
				</fieldset>

			</form>
		</div>
	</div>
</div>
<!-- Content End -->

	
<?php
include '../includes/_incFooter.php';
?>
