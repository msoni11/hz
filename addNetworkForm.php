<?php
$ntwmake_array = explode(",", $ntwmake);
$amcwar_array = explode(',', $amcwar);
?>
<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="newnetworkform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add Network</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
				<?php 
				$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<select name="txtntwrkdept" id = "txtntwrkdept"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.strtoupper($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="ntwrkdepttext"></div></div>

				<div class="text-box-name">Item:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrkitem" id="txtntwrkitem" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>


				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtntwrkmake" id = "txtntwrkmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>

						<?php 
						foreach ( $ntwmake_array as $ntwmarray ) { 
							echo  '<option value="'.strtoupper($ntwmarray).'">'.strtoupper($ntwmarray).'</option>';
						}
						?>
						<option value='0'>other</option>
					</select>
				</div>
				<div class="text-box-field"><div id="ntwrkmaketext"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrkmodel" id="txtntwrkmodel" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Serial no:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrkserial" id="txtntwrkserial" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Quantity:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrkquantity" id="txtntwrkquantity" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Type:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrktype" id="txtntwrktype" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">AMC/WAR:</div>
				<div class="text-box-field">
					<select name="txtamc" id = "txtamc"  class="form-text" style="width:91%" >
						<option value="-1">---Select AMC/WAR---</option>
						<?php
						foreach ($amcwar_array as $aw){
							echo '<option value="'.$aw.'">'.$aw.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
		
				<div id="warrdate" style="display:none;">
				<div class="text-box-name">Warranty date:</div>
				<div class="text-box-field">
					<select name="txtntwrkwarnday" id = "txtntwrkwarnday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtntwrkwarnmonth" id = "txtntwrkwarnmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtntwrkwarnyear" id = "txtntwrkwarnyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
				</div>

				<div id="vendor" style="display:none;">
				<div class="text-box-name">vendor:</div>
				<div class="text-box-field">
					<input type="text" name="txtntwrkvendor" id="txtntwrkvendor" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				</div>

				<input type="button" name="newnetworkbtn" id="newnetworkbtn" value="Submit" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtntwrkreset" id="txtntwrkreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>

			</form>
		</div>
	</div>
</div>
<!-- Content End -->