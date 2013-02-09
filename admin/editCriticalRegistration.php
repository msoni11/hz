<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}

$unitcode = 'HZL/CZ/';
$assetcodearray = explode(',', $criticalassetcode);
$locationarray = explode('#', $criticallocation);
$ipsubnet = explode(',', $ipsubnet);
$configprocessorarray = explode(',',$configprocessor);
$configramarray = explode(',',$configram);
$confighddarray = explode('#',$confighdd);
$configcdromarray = explode(',',$configcdrom);
$swOs = explode(',',$swOs);

$id = base64_decode($_REQUEST['id']);
$db->Query("SELECT * FROM hz_criticalregistration WHERE id=".$id." LIMIT 1");
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$department         = $db->RowData['department'];
		$hardware           = $db->RowData['hardware'];
		$hwname             = $db->RowData['hwname'];
		$assetcode          = explode('/',$db->RowData['assetcode']);
		$location           = $db->RowData['location'];
		$assetowner         = $db->RowData['assetowner'];
		$make               = $db->RowData['make'];
		$model              = $db->RowData['model'];
		$serialno           = $db->RowData['serialno'];
		$ipaddr             = $db->RowData['ipaddr'];
		$hasconfig          = $db->RowData['hasconfig'];
		$configprocessor    = $db->RowData['configprocessor'];
		$configram          = $db->RowData['configram'];
		$confighdd          = $db->RowData['confighdd'];
		$configcdrom        = $db->RowData['configcdrom'];
		$hasnetwork         = $db->RowData['hasnetwork'];
		$nwmake             = $db->RowData['nwmake'];
		$nwspeed            = $db->RowData['nwspeed'];
		$nwgateway          = $db->RowData['nwgateway'];
		$hasperipheral      = $db->RowData['hasperipheral'];
		$peripheralmake     = $db->RowData['peripheralmake'];
		$peripheralmodel    = $db->RowData['peripheralmodel'];
		$peripheralserialno = $db->RowData['peripheralserialno'];
		$hassoftware        = $db->RowData['hassoftware'];
		$swoperatingsystem  = $db->RowData['swoperatingsystem'];
		$swapplication      = $db->RowData['swapplication'];
		$swserialno         = $db->RowData['swserialno'];
		$otherconfig        = $db->RowData['otherconfig'];
		$issuedate          = getdate($db->RowData['issuedate']);
	}
}
?>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="editcriticalform" action="#" method="post" onSubmit="return false;">				<fieldset><legend>Registration</legend>
				
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
				<input type="hidden" name="txtcriticalid" id="txtcriticalid" value="<?php echo $id; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" style="background:#CCCCCC"/>				

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="criticaldept" id = "criticaldept"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								if (isset($department) && $department!=''){
									$selected = ($department == $db->RowData['id']) ? 'selected':'';
								}
								echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'" '.$selected.'>'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<!--<option value='0'>Other</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id = "criticaldepttext"></div></div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN ('".str_replace(',','\',\'',$criticalhardware)."')");
				?>
				<div class="text-box-field">
					<select name="criticalhardware" id = "criticalhardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php 
							if ($db->RowCount) {
								while ($db->ReadRow()) {
									if (isset($hardware) && $hardware!=''){
										$selected = ($hardware == $db->RowData['id']) ? 'selected':'';
									}
									echo "<option value='".strtoupper($db->RowData['id'])."' ".$selected.">".strtoupper($db->RowData['name'])."</option>";
								}
							}
						?>
						<!--<option value='0'>OTHER</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="criticalhardwaretext"></div></div>

				
				<?php 
				$db->Query("SELECT hchn.* FROM hz_critical_hardware_name hchn LEFT OUTER JOIN hz_hardware hh ON (hh.id = hchn.hardware_id) WHERE hchn.hardware_id=".$hardware);
				?>
				<div class="text-box-name">Name:</div>
				<div class="text-box-field">
					<select name="editcriticalhwname" id = "editcriticalhwname"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Name----</option>
						<?php
						$hwnametemp = true;
						if ($db->RowCount) {
							while ($db->ReadRow()) {
								if (isset($hwname) && $hwname != ''){
										if (strtoupper($hwname) == strtoupper($db->RowData['name'])){
											$selected = 'selected';
											$hwnametemp = false;
										} else {
											$selected = '';
										}
								}
								echo "<option value='".strtoupper($db->RowData['name'])."' ".$selected.">".strtoupper($db->RowData['name'])."</option>";
							}
						}
						if ($hwnametemp) {
							echo "<option value='0' selected>OTHER</option>";
						} else {
							echo "<option value='0'>OTHER</option>";
						}
						?>
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($hwnametemp) { ?>
					<div id="editcriticalnametext">
						<input type="text" name="txtcriticalnametext" id="txtcriticalnametext" value="<?php echo $hwname; ?>" class="form-text" size="30" maxlength="2048">
					</div>
				<?php } else { ?>
					<div id="editcriticalnametext" style="display:none">
						<input type="text" name="txtcriticalnametext" id="txtcriticalnametext" value="" class="form-text" size="30" maxlength="2048">
					</div>
				<?php } ?>
				</div>

				<div class="text-box-name">Asset Code:</div>
				<div class="text-box-field">
					<select name="editcriticalasset" id = "editcriticalasset"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Asset Code----</option>
						<?php 
						$assettemp = true;
						if (isset($assetcode) && $assetcode != ''){
							foreach ($assetcodearray as $ac){
								if (strtoupper($ac) == strtoupper($assetcode[2])) {
									$assettemp = false;
									$selected = 'selected';
								} else {
									$selected = '';
								}
								echo '<option value="'.$unitcode.$ac.'" '.$selected.'>'.$unitcode.$ac.'/</option>';
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
				<?php if (!$assettemp) { ?>
					<div id="editcriticalassettext">
						<input type="text" name="txtcriticalassettext" id="txtcriticalassettext" 
							value="<?php for($j=3; $j<(count($assetcode)); $j++) {
							$count = count($assetcode)-1;
							if ($j<$count) {
								$slash = "/";
							} else {
								$slash = "";
							} 
							echo $assetcode[$j].$slash; } ?>" class="form-text" size="30" maxlength="2048">	
					</div>
					<?php } else {?>
					<div id="editcriticalassettext">
						<input type="text" name="txtcriticalassettext" id="txtcriticalassettext" value="<?php echo implode('/', $assetcode)?>" class="form-text" size="30" maxlength="2048">	
					</div>
					<?php } ?>
				</div>

				<div class="text-box-name">Location:</div>
				<div class="text-box-field">
					<select name="editcriticallocation" id = "editcriticallocation"  class="form-text" style="width:91%" >
					<option value='-1'>----Select Location----</option>
					<?php  
					$locationtemp = true;
					if (isset($location) && $location != '') {
						foreach ($locationarray as $loc) {
							if (strtoupper($location) == strtoupper($loc)) {
								$selected = 'selected';
								$locationtemp = false;
							} else {
								$selected = '';
							}
							echo "<option value='".$loc."' ".$selected.">".$loc."</option>";
						}
					}
					if ($locationtemp) {
						echo '<option value="0" selected>Other</option>';
					} else {
						echo '<option value="0">Other</option>';
					}
					?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($locationtemp) { ?>
					<div id="editcriticallocationtext">
						<input type="text" name="txtcriticallocationtext" id="txtcriticallocationtext" value="<?php echo $location ?>" class="form-text" size="30" maxlength="2048">
					</div>
				<?php } else { ?>
					<div id="editcriticallocationtext" style="display:none;">
						<input type="text" name="txtcriticallocationtext" id="txtcriticallocationtext" value="" class="form-text" size="30" maxlength="2048">
					</div>
				<?php } ?>
				</div>

				<div class="text-box-name">Asset Owner:</div>
				<div class="text-box-field">
					<input type="text" name="criticalassetowner" id="criticalassetowner" value="<?php if(isset($assetowner)) { echo $assetowner; }  ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="criticalmake" id = "criticalmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<?php 
							if (isset($make) && $make != '') {
								$db->Query("SELECT hcm.* FROM hz_hardware hch LEFT OUTER JOIN hz_make hcm ON (hch.id = hcm.hw_id) WHERE hcm.hw_id='".$hardware."'");
								if ($db->RowCount) {
									while ($db->ReadRow()) {
										if (strtoupper($make) == strtoupper($db->RowData['id'])) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='".$db->RowData['id']."' ".$selected.">".$db->RowData['name']."</option>";
									}
								}
							}
						?>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalmaketext"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="criticalmodel" id = "criticalmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<?php 
							if (isset($model) && $model != '') {
								$db->Query("SELECT hcm.* FROM hz_make hm LEFT OUTER JOIN hz_model hcm ON (hm.id = hcm.make_id) WHERE hcm.make_id='".$make."'");
								if ($db->RowCount) {
									while ($db->ReadRow()) {
										if (strtoupper($model) == strtoupper($db->RowData['id'])) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo "<option value='".$db->RowData['id']."' ".$selected.">".$db->RowData['modelname']."</option>";
									}
								}
							}
						?>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalmodeltext"></div></div>
				
				<div class="text-box-name">Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalserialno" id="criticalserialno" value="<?php if (isset($serialno)) { echo $serialno; } ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">IP Addr/Subnet:</div>
				<div class="text-box-field">
					<select name="editcriticalipsubnet" id = "editcriticalipsubnet"  class="form-text" style="width:91%" >
						<option value='-1'>Select IP Address/ Subnet Mask</option>
						<?php  
							$ipaddrtemp = true;
							if (isset($ipaddr) && $ipaddr != '') {
								foreach ($ipsubnet as $ipsubnet) {
									if (strtoupper($ipsubnet) == strtoupper($ipaddr)) {
										$selected = 'selected';
										$ipaddrtemp = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$ipsubnet."' ".$selected.">".$ipsubnet."</option>";
								}
							}
							if ($ipaddrtemp) {
								if (strtoupper($ipaddr) == 'NONE') {
									$ipaddrtemp = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">OTHER</option>';
								echo '<option value="NONE">NONE</option>';
							}
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($ipaddrtemp) { ?>
				<div id="editcriticalipsubnettext">
					<input type="text" name="txtcriticalipsubnettext" id="txtcriticalipsubnettext" value="<?php if(isset($ipaddr)) { echo $ipaddr; } ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else {?>
				<div id="editcriticalipsubnettext" style="display:none;">
					<input type="text" name="txtcriticalipsubnettext" id="txtcriticalipsubnettext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>

				<?php 
				if (isset($hasconfig) && $hasconfig != '') { 
					if ($hasconfig == '1') {
						$checked = 'checked';
						$style   = 'display:block';
					} else {
						$checked = '';
						$style   = 'display:none';
					}
				}
				?>
				<div class="text-box-name">Configuration:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalconfig" id="criticalconfig" value="" <?php echo $checked; ?> style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>
				
				<div id="hiddenconfig" style="<?php echo $style;?>">
				<div class="text-box-name">Processor:</div>
				<div class="text-box-field">
					<select name="editcriticalprocessor" id = "editcriticalprocessor"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Processor----</option>
						<?php  
							$confprocessor = true;
							if (isset($configprocessor) && $configprocessor != ''){
								foreach ($configprocessorarray as $cprocessor) {
									if (strtoupper($configprocessor) == strtoupper($cprocessor)) {
										$selected = 'selected';
										$confprocessor = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$cprocessor."' ".$selected.">".$cprocessor."</option>";
								}
							}
							if($confprocessor) {
								if (strtoupper($configprocessor) == 'NONE') {
									$confprocessor = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">OTHER</option>';
							}
							
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if($confprocessor) { ?>
				<div id="editcriticalprocessortext">
					<input type="text" name="txtcriticalprocessortext" id="txtcriticalprocessortext" value="<?php if(isset($configprocessor)) { echo $configprocessor; } ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else { ?>
				<div id="editcriticalprocessortext" style="display:none;">
					<input type="text" name="txtcriticalprocessortext" id="txtcriticalprocessortext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>
				
				<div class="text-box-name">RAM:</div>
				<div class="text-box-field">
					<select name="editcriticalram" id = "editcriticalram"  class="form-text" style="width:91%" >
						<option value='-1'>----Select RAM----</option>
						<?php  
							$confram = true;
							if (isset($configram) && $configram != '') {
								foreach ($configramarray as $cram) {
									if (strtoupper($configram) == strtoupper($cram)) {
										$selected = 'selected';
										$confram = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$cram."' ".$selected.">".$cram."</option>";
								}
							}
							if($confram) {
								if (strtoupper($configram) == 'NONE') {
									$confram = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">OTHER</option>';
							}
							
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if($confram) { ?>
				<div id="editcriticalramtext">
					<input type="text" name="txtcriticalramtext" id="txtcriticalramtext" value="<?php if(isset($configram)) { echo $configram; } ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else { ?>
				<div id="editcriticalramtext" style="display:none;">
					<input type="text" name="txtcriticalramtext" id="txtcriticalramtext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>

				<div class="text-box-name">HDD:</div>
				<div class="text-box-field">
					<select name="editcriticalhdd" id = "editcriticalhdd"  class="form-text" style="width:91%" >
						<option value='-1'>----Select HDD----</option>
						<?php  
							$confhdd = true;
							if (isset($confighdd) && $confighdd != '') {
								foreach ($confighddarray as $chdd) {
									if (strtoupper($confighdd) == strtoupper($chdd)) {
										$selected = 'selected';
										$confhdd = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$chdd."' ".$selected.">".$chdd."</option>";
								}
							}
							if($confhdd) {
								if (strtoupper($confighdd) == 'NONE') {
									$confhdd = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">OTHER</option>';
							}
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if($confhdd) { ?>
				<div id="editcriticalhddtext">
					<input type="text" name="txtcriticalhddtext" id="txtcriticalhddtext" value="<?php if(isset($confighdd)) { echo $confighdd;} ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else { ?>
				<div id="editcriticalhddtext" style="display:none">
					<input type="text" name="txtcriticalhddtext" id="txtcriticalhddtext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>

				<div class="text-box-name">CDROM:</div>
				<div class="text-box-field">
					<select name="editcriticalcdrom" id = "editcriticalcdrom"  class="form-text" style="width:91%" >
						<option value='-1'>----Select CDROM----</option>
						<?php  
							$confcdrom = true;
							if (isset($configcdrom) && $configcdrom != '') {
								foreach ($configcdromarray as $ccdrom) {
									if (strtoupper($configcdrom) == strtoupper($ccdrom)) {
										$selected = 'selected';
										$confcdrom = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$ccdrom."' ".$selected.">".$ccdrom."</option>";
								}
							}
							if($confcdrom) {
								if (strtoupper($configcdrom) == 'NONE') {
									$confcdrom = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">OTHER</option>';
							}
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if($confcdrom) { ?>
				<div id="editcriticalcdromtext">
					<input type="text" name="txtcriticalcdromtext" id="txtcriticalcdromtext" value="<?php if(isset($configcdrom)) { echo $configcdrom; } ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else {?>
				<div id="editcriticalcdromtext" style="display:none;">
					<input type="text" name="txtcriticalcdromtext" id="txtcriticalcdromtext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php }?>
				</div>

				</div>

				<?php 
				if (isset($hasnetwork) && $hasnetwork != '') { 
					if ($hasnetwork == '1') {
						$checked = 'checked';
						$style   = 'display:block';
					} else {
						$checked = '';
						$style   = 'display:none';
					}
				}
				?>
				<div class="text-box-name">N/w Card Details:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalntwrkcard" id="criticalntwrkcard" value="" <?php echo $checked; ?> style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>

				<div id="hiddenntwrkcard" style="<?php echo $style; ?>">

				<div class="text-box-name">Network Make:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkmake" id="criticalntwrkmake" value="<?php if(isset($nwmake)) {echo $nwmake;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Speed:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkspeed" id="criticalntwrkspeed" value="<?php if(isset($nwspeed)) {echo $nwspeed;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Gateway:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkgateway" id="criticalntwrkgateway" value="<?php if(isset($nwgateway)) {echo $nwgateway;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				</div>
				
				<?php 
				if (isset($hasperipheral) && $hasperipheral != '') { 
					if ($hasperipheral == '1') {
						$checked = 'checked';
						$style   = 'display:block';
					} else {
						$checked = '';
						$style   = 'display:none';
					}
				}
				?>
				<div class="text-box-name">Peripherals:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalperipheral" id="criticalperipheral" <?php echo $checked; ?> value="" style="margin:8px 0 0 0;"/>
				</div>
				<div class="text-box-field"></div>

				<div id="hiddenperipheral" style="<?php echo $style; ?>">

				<div class="text-box-name">Peripheral Make:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralmake" id="criticalperipheralmake" value="<?php if(isset($peripheralmake)) {echo $peripheralmake;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Peripheral Model:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralmodel" id="criticalperipheralmodel" value="<?php if(isset($peripheralmodel)) {echo $peripheralmodel;} ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Peripheral Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralsrno" id="criticalperipheralsrno" value="<?php if(isset($peripheralserialno)) {echo $peripheralserialno;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				</div>
				
				<?php 
				if (isset($hassoftware) && $hassoftware != '') { 
					if ($hassoftware == '1') {
						$checked = 'checked';
						$style   = 'display:block';
					} else {
						$checked = '';
						$style   = 'display:none';
					}
				}
				?>
				<div class="text-box-name">Software:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalsoftware" id="criticalsoftware" <?php echo $checked; ?> value="" style="margin:8px 0 0 0;"/>
				</div>
				<div class="text-box-field"></div>

				<div id="hiddensoftware" style="<?php echo $style; ?>">

				<div class="text-box-name">Oerating System:</div>
				<div class="text-box-field">
					<select name="editcriticalsoftwareos" id = "editcriticalsoftwareos"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Operating System----</option>
						<?php  
							$swostemp = true;
							if (isset($swoperatingsystem) && $swoperatingsystem !='') {
								foreach ($swOs as $swOs) {
									if (strtoupper($swoperatingsystem) == strtoupper($swOs)) {
										$selected = 'selected';
										$swostemp = false;
									} else {
										$selected = '';
									}
									echo "<option value='".$swOs."' ".$selected.">".$swOs."</option>";
								}
							}
							
							if ($swostemp) {
								if (strtoupper($swoperatingsystem) == 'NONE') {
									$swostemp = false;
									echo '<option value="NONE" selected>NONE</option>';
									echo '<option value="0">OTHER</option>';
								} else {
									echo '<option value="NONE">NONE</option>';
									echo '<option value="0" selected>OTHER</option>';
								}
							} else {
								echo '<option value="0">Other</option>';
							}
						?>					
					</select>
				</div>
				<div class="text-box-field">
				<?php if ($swostemp) { ?>
				<div id="editcriticalsoftwareostext">
					<input type="text" name="txtcriticalsoftwareostext" id="txtcriticalsoftwareostext" value="<?php if (isset($swoperatingsystem)) { echo $swoperatingsystem;} ?>" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } else { ?>
				<div id="editcriticalsoftwareostext" style="display:none;">
					<input type="text" name="txtcriticalsoftwareostext" id="txtcriticalsoftwareostext" value="" class="form-text" size="30" maxlength="2048">
				</div>
				<?php } ?>
				</div>
				
				<div class="text-box-name">Application:</div>
				<div class="text-box-field">
					<input type="text" name="criticalsoftwareapp" id="criticalsoftwareapp" value="<?php if(isset($swapplication)) { echo $swapplication; } ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralsrno" id="criticalperipheralsrno" value="<?php if(isset($swserialno)) { echo $swserialno; } ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				</div>

				<div class="text-box-name">Other Configuration:</div>
				<div class="text-box-field">
					<input type="text" name="criticalotherconfig" id="criticalotherconfig" value="<?php if(isset($otherconfig)) { echo $otherconfig;} ?>" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issue Date:</div>
				<div class="text-box-field">
					<select name="criticalday" id = "criticalday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							$dayseleted = ($issuedate['mday'] == $i) ? 'selected':'';
							echo '<option value="'.$i.'" '.$dayseleted.'>'.$i.'</option>';
						}
						?>
					</select>
					<select name="criticalmonth" id = "criticalmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							$monseleted = ($issuedate['mon'] == $i) ? 'selected': '';
							echo '<option value="'.$i.'" '.$monseleted.'>'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="criticalyear" id = "criticalyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							$yearselected = ($issuedate['year'] == $i) ? 'selected': '';
							echo '<option value="'.$i.'" '.$yearselected.'>'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<input type="button" name="editcriticalassetbtn" id="editcriticalassetbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:80px; height:30px;margin-left:5px" onclick="window.location = 'lists/listCriticalAsset.php'" /> 
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>