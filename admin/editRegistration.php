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
$db->Query("SELECT hze.*,hzr.* FROM hz_employees hze LEFT OUTER JOIN hz_registration hzr ON (hze.empid = hzr.empid)  WHERE hzr.id=".$id." LIMIT 1");
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$empid          = $db->RowData['empid'];
		$empname        = $db->RowData['empname'];
		$unit       	= $db->RowData['unit'];
		$department     = $db->RowData['department'];
		$designation    = $db->RowData['designation'];
		$edithardware   = $db->RowData['hardware'];
		$editcartage    = $db->RowData['cartage'];
		$editprintertype = $db->RowData['printertype'];
		$editmake       = $db->RowData['make'];
		$model          = $db->RowData['model'];
		$cpuno          = $db->RowData['cpuno'];
		$editmonitor    = $db->RowData['monitortype'];
		$monitorno      = $db->RowData['monitorno'];
		$sysconfig      = $db->RowData['sysconfig'];
		$editassetcode  = explode('/',$db->RowData['assetcode']);
		$ipaddr		    = $db->RowData['ipaddr'];
		$editmsoffice   = $db->RowData['officever'];
		$licensesoft    = $db->RowData['licensesoft'];
		$internet       = $db->RowData['internet'];
		$editamcwar     = $db->RowData['internettype'];
		if ( $editamcwar == 'AMC') {
			$warvendor      = $db->RowData['warnorvendor'];
		} else if ( $editamcwar == 'WAR') {
			$warvendor      = getdate($db->RowData['warnorvendor']);
		}
		$date           = getdate($db->RowData['date']);
		$otheritasset   = $db->RowData['otheritasset'];
		$status         = $db->RowData['status'];
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
				$db->Query("SELECT * FROM hz_hardware WHERE name IN ('".str_replace(',','\',\'',$hardware)."')");
				?>
				<div class="text-box-field">
					<select name="edittxthardware" id = "edittxthardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php
						$hwtemp = true;
						if (isset($edithardware)) {
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($edithardware)) {
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

						/*if ($hwtemp) {
							$hwotherselected = true;
							echo "<option value='0' selected>Other</option>";
						} else {
							echo "<option value='0'>Other</option>";
						}*/

						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php if ($hwtemp) {?>
					<div id="edithwtext">
						<input type="text" name="edittxthwtext" id="edittxthwtext" value="<?php echo $edithardware; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id="edithwtext" style="display:none">
						<input type="text" name="edittxthwtext" id="edittxthwtext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>
				<?php 
				if (!$hwotherselected) {
					if($hwidselected != 3) {
						$noneselected = true;
					} else {
						$noneselected = false;
					}
				}
				?>

				<div id="editprintertypediv" style="display:none" >
					<div class="text-box-name">Type:</div>
					<div class="text-box-field">
						<select name="edittxtprintertype" id = "edittxtprintertype"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Printer Type----</option>
						<?php
						$printtypeotherselected = false;
						$printtypetemp = true;
						if (isset($editprintertype) &&  !$hwotherselected) {
							$db->Query("SELECT * FROM hz_printertype WHERE hw_id=".$hwidselected);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($editprintertype)) {
										$printtypeselected = 'selected';
										$printertypeidselected = $db->RowData['id'];
										$printtypetemp = false;
									} else {
										$printtypeselected = '';
									}
									echo '<option value="'.($db->RowData['id']).'" '.$printtypeselected.'>'.$db->RowData['printertype'].'</option>';
								} 
							}
						}

						if ($printtypetemp) {
							if ($editprintertype == '0' || $noneselected) {
								//echo "<option value='0'>Other</option>";
								echo "<option value='0' selected>NONE</option>";
								$printtypetemp = false;
							} else {
								$printtypeotherselected = true;
								//echo "<option value='0' selected>Other</option>";
								//echo "<option value='NONE'>NONE</option>";
							}
						} else {
							//echo "<option value='0'>Other</option>";
							//echo "<option value='NONE'>NONE</option>";
						}

						?>
						</select>
					</div>
					<div class="text-box-field">
					<?php if ($printtypetemp) {?>
					<div id="editprintertypetext">
						<input type="text" name="edittxtprintertypetext" id="edittxtprintertypetext" value="<?php echo $editprintertype; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id="editprintertypetext" style="display:none">
						<input type="text" name="edittxtprintertypetext" id="edittxtprintertypetext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
					</div>
				</div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="edittxtmake" id = "edittxtmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select----</option>
						<?php 
						$makeotherselected = false;
						$maketemp = true;
						if (isset($editmake) && !$hwotherselected) {
							$db->Query("SELECT * FROM hz_make WHERE hw_id=".$hwidselected);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($editmake)) {
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
						if ($maketemp) {
							$makeotherselected = true;
							if (strtoupper($editmake) == 'NONE') {
								$maketemp = false;
								//echo "<option value='0'>Other</option>";
								//echo "<option value='NONE' selected>NONE</option>";
							} else {
								//echo "<option value='0' selected>Other</option>";
								//echo "<option value='NONE'>NONE</option>";
							}
						} else {
							//echo "<option value='0'>Other</option>";
							//echo "<option value='NONE'>NONE</option>";
						}
						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php if ($maketemp) {?>
					<div id="editmaketext">
						<input type="text" name="edittxtmaketext" id="edittxtmaketext" value="<?php echo $editmake; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else { ?>
					<div id="editmaketext" style="display:none">
						<input type="text" name="edittxtmaketext" id="edittxtmaketext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="edittxtmodel" id = "edittxtmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<?php 
						$modelotherselected = false;
						$modeltemp = true;
						if (isset($model)) {
							if ($hwidselected == 3 && !$printtypeotherselected) {
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
							} else if (!$makeotherselected) {
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
							if ($modeltemp) {
								$modelotherselected = true;
								if (strtoupper($model) == 'NONE') {
									$modeltemp = false;
									//echo "<option value='0'>Other</option>";
									//echo "<option value='NONE' selected>NONE</option>";
								} else {
									//echo "<option value='0' selected>Other</option>";
									//echo "<option value='NONE'>NONE</option>";
								}
							} else {
								//echo "<option value='0'>Other</option>";
								//echo "<option value='NONE'>NONE</option>";
							}
						?>
					</select>
					<!--<input type="text" name="txtmodel" id="txtmodel" value="<?php echo $model?>" class="form-text" size="30" maxlength="2048" />-->
				</div>
				<div class="text-box-field">
				<?php if ($modeltemp) {?>
				<div id="editmodeltext">
					<input type="text" name="edittxtmodeltext" id="edittxtmodeltext" value="<?php echo $model; ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else {?>
				<div id="editmodeltext" style="display:none">
					<input type="text" name="edittxtmodeltext" id="edittxtmodeltext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>
				
				<div class="text-box-name">CPU/P/S Sr. No.:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtcpuno" id="edittxtcpuno" value="<?php echo $cpuno?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Monitor:</div>
				<div class="text-box-field">
					<?php if ($edithardware == 'LAPTOP' || $edithardware == 'PRINTER') {
						$monitordisabled = 'disabled';
					} else {
						$monitordisabled = '';
					}
					?>
					<select name="edittxtmonitor1" id = "edittxtmonitor1"  class="form-text" style="width:91%" <?php echo $monitordisabled; ?> >
						<option value='-1'>----Select Monitor----</option>
						<?php 
						$monitortemp = true;
						if (isset($editmonitor)) {
							foreach ( $monitor_array as $monitorarray ) { 
								if (strtoupper($monitorarray) == strtoupper($editmonitor) ) {
									$monitortemp = false;
									$moselected = 'selected';
								} else {
									$moselected = '';
								}
								echo  '<option value="'.strtoupper($monitorarray).'" '.$moselected.'>'.strtoupper($monitorarray).'</option>';
							}
								if($monitortemp ) {
									echo "<option value='NONE' selected>NONE</option>";
								} else {
									echo "<option value='NONE'>NONE</option>";
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">CRT/TFT Sr. No.:</div>
				<div class="text-box-field">
					<?php 
					if (isset($monitorno)) {
						if (strtoupper($monitorno) == 'NONE') {
							$monitordisabled = 'disabled';
						} else {
							$monitordisabled = '';
						}
					}
					?>
					<input type="text" name="edittxtcrtno" id="edittxtcrtno" value="<?php echo $monitorno ?>" class="form-text" size="30" maxlength="2048" <?php echo $monitordisabled; ?> />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Configuration:</div>
				<div class="text-box-field">
					<select name="edittxtconfig" id = "edittxtconfig"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Configuration----</option>
						<?php
						$configtemp = true;
						if (isset($sysconfig) && !$modelotherselected) {
							$db->Query("SELECT * FROM hz_configuration WHERE make_id=".$mkidselected);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['config']) == strtoupper($sysconfig)) {
										$configselected = 'selected';
										$configtemp = false;
									} else {
										$configselected = '';
									}
									echo '<option value="'.($db->RowData['config']).'" '.$configselected.'>'.$db->RowData['config'].'</option>';
								}
							}
						}
						if ($configtemp) { 
							if (strtoupper($sysconfig) == 'NONE') {
								echo "<option value='0' selected >Other</option>";
								echo "<option value='NONE' selected >NONE</option>";
								$configtemp = false;
							} else {
								echo "<option value='0' selected >Other</option>";
								echo "<option value='NONE'>NONE</option>";
							}
						} else {
							echo "<option value='0'>Other</option>";
							echo "<option value='NONE'>NONE</option>";
						}
						?>
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($configtemp) {?>
				<div id="editconfigtext">
					<input type="text" name="edittxtconfigtext" id="edittxtconfigtext" value='<?php echo $sysconfig; ?>' class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else {?>
				<div id="editconfigtext" style="display:none">
					<input type="text" name="edittxtconfigtext" id="edittxtconfigtext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>

				<div id="editcartagediv" style="display:none">
					<div class="text-box-name">Cartage No.:</div>
					<div class="text-box-field">
						<select name="edittxtcartage" id = "edittxtcartage"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Cartage----</option>
						<?php
						$cartagetemp = true;
						if (isset($editcartage) && !$hwotherselected) {
							$db->Query("SELECT * FROM hz_cartage WHERE hw_id=".$hwidselected);
							if ($db->RowCount) { 
								while ($db->ReadRow()) {
									if (strtoupper($db->RowData['id']) == strtoupper($editcartage)) {
										$cartageselected = 'selected';
										$cartagetemp = false;
									} else {
										$cartageselected = '';
									}
									echo '<option value="'.($db->RowData['id']).'" '.$cartageselected.'>'.$db->RowData['cartage'].'</option>';
								} 
							}
						}

						if ($cartagetemp) {
							if ($editcartage == 'NONE' || $noneselected) {
								echo "<option value='0'>Other</option>";
								echo "<option value='NONE' selected>NONE</option>";
								$cartagetemp = false;
							} else {
								echo "<option value='0' selected>Other</option>";
								echo "<option value='NONE'>NONE</option>";
							}
						} else {
							echo "<option value='0'>Other</option>";
							echo "<option value='NONE'>NONE</option>";
						}

						?>
						</select>
					</div>
					<div class="text-box-field">
					<?php if ($cartagetemp) {?>
					<div id="editcartagetext">
						<input type="text" name="edittxtcartagetext" id="edittxtcartagetext" value="<?php echo $editcartage; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id="editcartagetext" style="display:none">
						<input type="text" name="edittxtcartagetext" id="edittxtcartagetext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
					</div>
				</div>

				<!--<div class="text-box-name">Asset Code:</div>
				<div class="text-box-field">
					<input type="text" name="txtasset" id="txtasset" value="<?php echo $assetcode?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>-->
				<div class="text-box-name">Asset Code:</div>
				<div class="text-box-field">
					<select name="edittxtasset" id = "edittxtasset"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Asset Code----</option>
						<?php
						$assettemp = true;
						$actemp = false;
						if ($editassetcode) {
							foreach ($assetcode as $ac){
								if (strtoupper($ac) == strtoupper($editassetcode[2])) {
									$acselected = 'selected';
									$actemp = true;
									$assettemp = false;
								} else {
									$acselected = '';
								}
								//$acselected = strtoupper($ac) == strtoupper($editassetcode[2]) ? 'selected': '' ;
								echo '<option value="'.$unitcode.$ac.'" '.$acselected.'>'.$unitcode.$ac.'/ </option>';
							}
							
							if ($assettemp) {
								echo "<option value='other' selected>Other</option>";
							} else {
								echo "<option value='other'>Other</option>";
							}

						}
						?>
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($actemp) { ?>
					<div id="editassettext">
						<input type="text" name="edittxtassettext" id="edittxtassettext" 
							value="<?php for($j=3; $j<(count($editassetcode)); $j++) {
							$count = count($editassetcode)-1;
							if ($j<$count) {
								$slash = "/";
							} else {
								$slash = "";
							} 
							echo $editassetcode[$j].$slash; } ?>" class="form-text" size="30" maxlength="2048">	
					</div>
					<?php } else if ($assettemp) {?>
					<div id="editassettext">
						<input type="text" name="edittxtassettext" id="edittxtassettext" value="<?php echo implode('/', $editassetcode)?>" class="form-text" size="30" maxlength="2048">	
					</div>
					
					<?php } ?>
				</div>
				<div class="text-box-name">IP Address:</div>
				<div class="text-box-field">
				<?php	if (isset($ipaddr)) {
						if ($hwidselected == 3 && !$printtypeotherselected) {
							$db->Query("SELECT hasnetwork FROM hz_printertype WHERE id=".$printertypeidselected);
							if ($db->RowCount) { 
								if ($db->ReadRow()) {
									if ($db->RowData['hasnetwork'] == 0) {
										$disabled = 'disabled';
									} else {
										$disabled = '';
									}
								}
							}
						} else if ($hwidselected == 4){
							$disabled = 'disabled';
						} else {
							$disabled = '';
						}
					}
				?>
				<input type="text" name="editipaddress" id="editipaddress" value="<?php echo $ipaddr?>" class="form-text" size="30" maxlength="2048" <?php echo $disabled?> />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">MS Office:</div>
				<div class="text-box-field">
					<?php $msdisabled = strtoupper($editmsoffice) == 'NONE' ? 'disabled' : ''; ?>
					<select name="edittxtoffice" id = "edittxtoffice"  class="form-text" style="width:91%" <?php echo $msdisabled ?>>
						<option value="-1">---Select---</option>
						<?php 
						if (isset($editmsoffice)) {
							foreach ( $msoffice_array as $mso ) { 
								$msselected = strtoupper($mso) == strtoupper($editmsoffice) ? 'selected' : '';
								echo  '<option value="'.strtoupper($mso).'" '.$msselected.'>'.strtoupper($mso).'</option>';
							}
						}
						
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Any License Soft:</div>
				<div class="text-box-field">
					<?php $licensedisabled = strtoupper($licensesoft) == 'NONE' ? 'disabled' : ''; ?>
					<input type="text" name="edittxtlicense" id="edittxtlicense" value="<?php echo $licensesoft?>" class="form-text" size="30" maxlength="2048" <?php echo $licensedisabled; ?> />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Internet:</div>
				<div class="text-box-field">
					<?php $nonedisabled = strtoupper($internet) == 'NONE' ? 'disabled' :''; ?>
					<select name="edittxtinternet" id = "edittxtinternet"  class="form-text" style="width:91%" <?php echo $nonedisabled ?> >
						<?php 
						$yesselected = strtolower($internet) == 'yes' ? 'selected' :'';
						$noselected = strtolower($internet) == 'no' ? 'selected' :'';
						$noneselected = strtoupper($internet) == 'NONE' ? 'selected' :'';
						?>
						<option value="YES" <?php echo $yesselected; ?> >YES</option>
						<option value="NO" <?php echo $noselected; ?> >NO</option>
						<option value="NONE" <?php echo $noneselected; ?> >NONE</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">AMC/WAR:</div>
				<div class="text-box-field">
					<select name="edittxtamc" id = "edittxtamc"  class="form-text" style="width:91%" >
						<option value="-1">---SELECT---</option>
						<?php
						if (isset($editamcwar)) {
							foreach ( $amcwar_array as $aw ) { 
								$awselected = strtoupper($aw) == strtoupper($editamcwar) ? 'selected' : '';
								echo  '<option value="'.strtoupper($aw).'" '.$awselected.'>'.strtoupper($aw).'</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
				
				<div id="editwarrdate" style="display:none;">
				<div class="text-box-name">Warranty date:</div>
				<div class="text-box-field">
					<select name="txteditwarnday" id = "txteditwarnday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							$wardayselected = ($warvendor['mday']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$wardayselected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="txteditwarnmonth" id = "txteditwarnmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							$warmonthselected = ($warvendor['mon']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$warmonthselected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txteditwarnyear" id = "txteditwarnyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							$waryearselected = ($warvendor['year']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$waryearselected.'>'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
				</div>
				<div id="editvendor" style="display:none;">
				<div class="text-box-name">vendor:</div>
				<div class="text-box-field">
					<input type="text" name="txteditvendor" id="txteditvendor" value="<?php if ($editamcwar == 'AMC') { echo $warvendor; } else { echo ''; } ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				</div>

				<?php 
				if ($editamcwar == 'WAR') { 
					echo '<script>$("#editwarrdate").show()</script>';
				} else if ($editamcwar == 'AMC') {
					echo '<script>$("#editvendor").show()</script>';
				}
				?>

				<div class="text-box-name">Date:</div>
				<div class="text-box-field">
					<select name="edittxtday" id = "edittxtday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) {
							$dayselected = ($date['mday']==$i) ? 'selected = selected' :'';
							echo '<option value="'.$i.'" '.$dayselected.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="edittxtmonth" id = "edittxtmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							$monthselected = ($date['mon']==$i) ? 'selected = selected' : '';
							echo '<option value="'.$i.'" '.$monthselected.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="edittxtyear" id = "edittxtyear"  class="form-text" style="width:30%" >
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

				<div class="text-box-name">Other IT Asset:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtotheritasset" id="edittxtotheritasset" value="<?php echo $otheritasset?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Status:</div>
				<div class="textarea-box-field">
					<textarea name="edittxtregstatus" id="edittxtregstatus" class="form-text" size="30" maxlength="2048" rows="5" /><?php echo $status?></textarea>				
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

				<input type="button" name="editregbtn" id="editregbtn" value="Update" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:80px; height:30px;margin-left:5px" onclick="window.location = 'lists/listAsset.php'" /> 
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
