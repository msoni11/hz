<?php
include 'includes/_incHeader.php';
$db = new cDB();
$ntwmake_array = explode(",", $ntwmake);
$amcwar_array = explode(',', $amcwar);
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != '1' ) {
	header("Location:logout.php");
}
$id = base64_decode($_REQUEST['uid']);
$db->Query("SELECT * FROM hz_network WHERE id=".$id);
if ($db->RowCount) {
	if ($db->ReadRow()) {
		$department     = $db->RowData['location'];
		$item           = $db->RowData['item'];
		$make           = $db->RowData['make'];
		$model          = $db->RowData['model'];
		$serial         = $db->RowData['serial'];
		$quantity       = $db->RowData['quantity'];
		$type           = $db->RowData['type'];
		$editamcwar     = $db->RowData['amcwar'];
		if ( $editamcwar == 'AMC') {
			$warvendor      = $db->RowData['warnorvendor'];
		} else if ( $editamcwar == 'WAR') {
			$warvendor      = getdate($db->RowData['warnorvendor']);
		}
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
				<input type="hidden" name="edittxtntwrkhiddenid" id="edittxtntwrkhiddenid" value="<?php echo $id; ?>" class="form-text" size="30" maxlength="2048" />

				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="edittxtntwrkdept" id = "edittxtntwrkdept"  class="form-text" style="width:91%" >
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
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'" '. $deptselected.'>'.$db->RowData['name'].'</option>';
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
					<div id = "editntwrkdepttext">
						<input type="text" name="editntwrktxtdepttext" id="editntwrktxtdepttext" value="<?php echo $department?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else {?>
					<div id = "editntwrkdepttext" style="display:none">
						<input type="text" name="editntwrktxtdepttext" id="editntwrktxtdepttext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>

				<div class="text-box-name">Item:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtntwrkitem" id="edittxtntwrkitem" value="<?php echo $item; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>


				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="edittxtntwrkmake" id = "edittxtntwrkmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<?php 
						$maketemp = true;
						if (isset($make)) {
							foreach ( $ntwmake_array as $ntwmarray ) { 
								if (strtoupper($ntwmarray) == strtoupper($make)) {
									$ntwmakeselected = 'selected';
									$maketemp = false;
								} else {
									$ntwmakeselected = '';
								}
								echo  '<option value="'.strtoupper($ntwmarray).'" '.$ntwmakeselected.' >'.strtoupper($ntwmarray).'</option>';
							}
						}
							if ($maketemp) {
								echo "<option value='0' selected>Other</option>";
							} else {
								echo "<option value='0'>Other</option>";
							}
						?>
					</select>
				</div>
				<div class="text-box-field">
					<?php if ($maketemp) {?>
					<div id="editntwrkmaketext">
						<input type="text" name="edittxtntwrkmaketext" id="edittxtntwrkmaketext" value="<?php echo $make; ?>" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } else { ?>
					<div id="editntwrkmaketext" style="display:none">
						<input type="text" name="edittxtntwrkmaketext" id="edittxtntwrkmaketext" value="" class="form-text" size="30" maxlength="2048">
					</div>
					<?php } ?>
				</div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtntwrkmodel" id="edittxtntwrkmodel" value="<?php echo $model; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Serial no:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtntwrkserial" id="edittxtntwrkserial" value="<?php echo $serial; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Quantity:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtntwrkquantity" id="edittxtntwrkquantity" value="<?php echo $quantity; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Type:</div>
				<div class="text-box-field">
					<input type="text" name="edittxtntwrktype" id="edittxtntwrktype" value="<?php echo $type; ?>" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">AMC/WAR:</div>
				<div class="text-box-field">
					<select name="edittxtamc" id = "edittxtamc"  class="form-text" style="width:91%" >
						<option value="-1">---Select AMC/WAR---</option>
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

				<input type="button" name="editnetworkbtn" id="editnetworkbtn" value="Update" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="button" name="editcancel" id="editcancel" value="Cancel" style="width:80px; height:30px;margin-left:5px" onclick="window.location = 'lists/listNetwork.php'" /> 
				</fieldset>

			</form>
		</div>
	</div>
</div>
<!-- Content End -->

	
<?php
include '../includes/_incFooter.php';
?>
