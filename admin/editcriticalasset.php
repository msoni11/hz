<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
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
								echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
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
									echo "<option value='".strtoupper($db->RowData['id'])."'>".strtoupper($db->RowData['name'])."</option>";
								}
							}
						?>
						<!--<option value='0'>OTHER</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="criticalhardwaretext"></div></div>

				
				<div class="text-box-name">Name:</div>
				<div class="text-box-field">
					<select name="criticalhwname" id = "criticalhwname"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Name----</option>
						<option value='0'>OTHER</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalnametext"></div></div>

				<div class="text-box-name">Asset Code:</div>
				<div class="text-box-field">
					<select name="criticalasset" id = "criticalasset"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Asset Code----</option>
						<?php 
						foreach ($assetcode as $ac){
							echo '<option value="'.$unitcode.$ac.'">'.$unitcode.$ac.'/</option>';
						}
						?>
						<option value='other'>Other</option>
						<!--<option value="NONE">NONE</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="criticalassettext"></div></div>

				<div class="text-box-name">Location:</div>
				<div class="text-box-field">
					<select name="criticallocation" id = "criticallocation"  class="form-text" style="width:91%" >
					<option value='-1'>----Select Location----</option>
					<?php  
						foreach ($location as $loc) {
							echo "<option value='".$loc."'>".$loc."</option>";
						}
					?>					
						<option value="0">Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticallocationtext"></div></div>

				<div class="text-box-name">Asset Owner:</div>
				<div class="text-box-field">
					<input type="text" name="criticalassetowner" id="criticalassetowner" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="criticalmake" id = "criticalmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<?php 
							/*$db->Query("SELECT hcm.name name FROM hz_critical_hardware hch LEFT OUTER JOIN hz_critical_make hcm ON (hch.id = hcm.criticalhw_id)");
							if ($db->RowCount) {
								while ($db->ReadRow()) {
									echo "<option value='".$db->RowData['name']."'>".$db->RowData['name']."</option>";
								}
							}*/
						?>
						<!--<option value='HP(SERVER)'>HP(SERVER)</option>
						<option value='CISCO(ROUTER)'>CISCO(ROUTER)</option>
						<option value='SYMANTEC(FIREWALL)'>SYMANTEC(FIREWALL)</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="criticalmaketext"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="criticalmodel" id = "criticalmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<!--<option value="HP PROLIANT DL-380-G5">HP PROLIANT DL-380-G5</option>
						<option value="PROLIANT DL-380-G4">PROLIANT DL-380-G4</option>
						<option value="1751 V">1751 V</option>
						<option value="CATALYST 3750G, C3550 SERIES">CATALYST 3750G, C3550 SERIES</option>
						<option value="5420">5420</option>
						<option value="IBM SYSTEM X3650 M3">IBM SYSTEM X3650 M3</option>
						<option value='0'>Other</option>-->
					</select>
					<!--<input type="text" name="txtmodel" id="txtmodel" value="" class="form-text" size="30" maxlength="2048" />-->
				</div>
				<div class="text-box-field"><div id="criticalmodeltext"></div></div>
				
				<div class="text-box-name">Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalserialno" id="criticalserialno" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">IP Addr/Subnet:</div>
				<div class="text-box-field">
					<select name="criticalipsubnet" id = "criticalipsubnet"  class="form-text" style="width:91%" >
						<option value='-1'>Select IP Address/ Subnet Mask</option>
						<?php  
							foreach ($ipsubnet as $ipsubnet) {
								echo "<option value='".$ipsubnet."'>".$ipsubnet."</option>";
							}
						?>					
						<option value="0">OTHER</option>
						<option value="NONE">NONE</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalipsubnettext"></div></div>

				<div class="text-box-name">Configuration:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalconfig" id="criticalconfig" value="" style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>
				
				<div id="hiddenconfig" style="display:none">
				<div class="text-box-name">Processor:</div>
				<div class="text-box-field">
					<select name="criticalprocessor" id = "criticalprocessor"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Processor----</option>
						<?php  
							foreach ($configprocessor as $configprocessor) {
								echo "<option value='".$configprocessor."'>".$configprocessor."</option>";
							}
						?>					
						<option value="0">OTHER</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalprocessortext"></div></div>
				
				<div class="text-box-name">RAM:</div>
				<div class="text-box-field">
					<select name="criticalram" id = "criticalram"  class="form-text" style="width:91%" >
						<option value='-1'>----Select RAM----</option>
						<?php  
							foreach ($configram as $configram) {
								echo "<option value='".$configram."'>".$configram."</option>";
							}
						?>					
						<option value="0">OTHER</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalramtext"></div></div>

				<!--<div class="text-box-name">FDD:</div>
				<div class="text-box-field">
					<input type="text" name="criticalfdd" id="criticalfdd" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>-->

				<div class="text-box-name">HDD:</div>
				<div class="text-box-field">
					<select name="criticalhdd" id = "criticalhdd"  class="form-text" style="width:91%" >
						<option value='-1'>----Select HDD----</option>
						<?php  
							foreach ($confighdd as $confighdd) {
								echo "<option value='".$confighdd."'>".$confighdd."</option>";
							}
						?>					
						<option value="0">OTHER</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalhddtext"></div></div>

				<div class="text-box-name">CDROM:</div>
				<div class="text-box-field">
					<select name="criticalcdrom" id = "criticalcdrom"  class="form-text" style="width:91%" >
						<option value='-1'>----Select CDROM----</option>
						<?php  
							foreach ($configcdrom as $configcdrom) {
								echo "<option value='".$configcdrom."'>".$configcdrom."</option>";
							}
						?>					
						<option value="0">OTHER</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalcdromtext"></div></div>

				</div>

				<div class="text-box-name">N/w Card Details:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalntwrkcard" id="criticalntwrkcard" value="" style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>

				<div id="hiddenntwrkcard" style="display:none">

				<div class="text-box-name">Network Make:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkmake" id="criticalntwrkmake" value="" class="form-text" size="30" maxlength="2048" />				
					<!--<select name="criticalntwrkmake" id = "criticalntwrkmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<option value='-1'>----Select Make----</option>
						<option value="HP NC373i MULTIFUNCTION GIGABIT SERVER ADAPTER(#2)">HP NC373i MULTIFUNCTION GIGABIT SERVER ADAPTER(#2)</option>
						<option value="0">OTHER</option>
						<option value="NONE">NONE</option>
					</select>-->
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Speed:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkspeed" id="criticalntwrkspeed" value="" class="form-text" size="30" maxlength="2048" />				
					<!--<select name="criticalntwrkipsubnet" id = "criticalntwrkipsubnet"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Speed----</option>
						<option value="1000 MBPS">1000 MBPS</option>
						<option value="0">OTHER</option>
						<option value="NONE">NONE</option>
					</select>-->
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Gateway:</div>
				<div class="text-box-field">
					<input type="text" name="criticalntwrkgateway" id="criticalntwrkgateway" value="" class="form-text" size="30" maxlength="2048" />				
					<!--<select name="criticalntwrkgateway" id = "criticalntwrkgateway"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Gateway----</option>
						<option value="10.101.23.10">10.101.23.10</option>
						<option value="0">OTHER</option>
						<option value="NONE">NONE</option>
					</select>-->
				</div>
				<div class="text-box-field"></div>

				</div>
				
				<div class="text-box-name">Peripherals:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalperipheral" id="criticalperipheral" value="" style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>

				<div id="hiddenperipheral" style="display:none">

				<div class="text-box-name">Peripheral Make:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralmake" id="criticalperipheralmake" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Peripheral Model:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralmodel" id="criticalperipheralmodel" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Peripheral Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalperipheralsrno" id="criticalperipheralsrno" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				</div>
				
				<div class="text-box-name">Software:</div>
				<div class="text-box-field">
					<input type="checkbox" name="criticalsoftware" id="criticalsoftware" value="" style="margin:8px 0 0 0;"/>				
				</div>
				<div class="text-box-field"></div>

				<div id="hiddensoftware" style="display:none">

				<div class="text-box-name">Oerating System:</div>
				<div class="text-box-field">
					<select name="criticalsoftwareos" id = "criticalsoftwareos"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Operating System----</option>
						<?php  
							foreach ($swOs as $swOs) {
								echo "<option value='".$swOs."'>".$swOs."</option>";
							}
						?>					
						<option value="0">Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="criticalsoftwareostext"></div></div>
				
				<div class="text-box-name">Application:</div>
				<div class="text-box-field">
					<input type="text" name="criticalsoftwareapp" id="criticalsoftwareapp" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Serial No:</div>
				<div class="text-box-field">
					<input type="text" name="criticalsoftwaresrno" id="criticalsoftwaresrno" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				</div>

				<div class="text-box-name">Other Configuration:</div>
				<div class="text-box-field">
					<input type="text" name="criticalotherconfig" id="criticalotherconfig" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Issue Date:</div>
				<div class="text-box-field">
					<select name="criticalday" id = "criticalday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="criticalmonth" id = "criticalmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="criticalyear" id = "criticalyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<input type="button" name="newcriticalassetbtn" id="newcriticalassetbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtcriticalassetreset" id="txtcriticalassetreset" value="Reset" style="width:80px; height:30px;" />
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