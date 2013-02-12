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
			<form name="ipform" id="ipform" action="#" method="post" onSubmit="return false;">				
			<fieldset><legend>Auditor Form</legend>
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtipname" id="txtipname" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field" ></div>

				<div class="text-box-name">Unit:</div>
				<?php 
				$db->Query("SELECT * FROM hz_units");
				?>
				<div class="text-box-field">
					<select name="txtipunit" id = "txtipunit"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Unit----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<!-- <option value='0'>Other</option>-->
						<option value='0'>None</option>
					</select>
				</div>
				<div class="text-box-field"><div id="unittext"></div></div>

				<div class="text-box-name">IP Address:</div>
				<div class="text-box-field">
					<input type="text" name="txtipaddress" id="txtipaddress" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Internet:</div>
				<div class="text-box-field">
					<select name="txtipinternet" id = "txtipinternet"  class="form-text" style="width:91%" >
						<option value="YES">YES</option>
						<option value="NO">NO</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Reporting Person:</div>
				<div class="text-box-field">
					<input type="text" name="txtiprepperson" id="txtiprepperson" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
	
				<div class="text-box-name">RP's Email:</div>
				<div class="text-box-field">
					<input type="text" name="txtipreppersonmail" id="txtipreppersonmail" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Mobile:</div>
				<div class="text-box-field">
					<input type="text" name="txtipmobile" id="txtipmobile" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Duration From:</div>
				<div class="text-box-field">
					<select name="txtipdurationfromday" id = "txtipdurationfromday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtipdurationfrommonth" id = "txtipdurationfrommonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtipdurationfromyear" id = "txtipdurationfromyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Duration To:</div>
				<div class="text-box-field">
					<select name="txtipdurationtoday" id = "txtipdurationtoday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtipdurationtomonth" id = "txtipdurationtomonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtipdurationtoyear" id = "txtipdurationtoyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<input type="button" name="newipbtn" id="newipbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtipreset" id="txtipreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- Content End -->

<?php include 'includes/_incFooter.php';?>