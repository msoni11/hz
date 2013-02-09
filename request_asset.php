<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 0) {
	header("Location:logout.php");
}

//accesing session data or dumping sample data
$username = ($_SESSION["adldapinfo"][0]["description"][0]) ? $_SESSION["adldapinfo"][0]["description"][0] : "444444";
$name = ($_SESSION["adldapinfo"][0]["cn"][0]) ? $_SESSION["adldapinfo"][0]["cn"][0] : "John Doe";
$dept = ($_SESSION["adldapinfo"][0]["physicaldeliveryofficename"][0]) ? $_SESSION["adldapinfo"][0]["physicaldeliveryofficename"][0] : "CES-IT";
$desi = ($_SESSION["adldapinfo"][0]["title"][0]) ? $_SESSION["adldapinfo"][0]["title"][0] : "CEO";
$manager= ($_SESSION["managermail"][0]["mail"][0]) ? $_SESSION["managermail"][0]["mail"][0] : "him.developer@gmail.com";
?>
<script src="js/request.js"></script>
<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>

<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="empform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Request Asset</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Employee ID:</div>
				<div class="text-box-field">
					<input type="text" name="txtempid" id="txtempid" value="<?php echo $username; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" />
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtempname" id="txtempname" value="<?php echo $name; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" />				
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<input type="text" name="txtempdept" id="txtempdept" value="<?php echo $dept; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" />				
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">Desination:</div>
				<div class="text-box-field">
					<input type="text" name="txtempdesi" id="txtempdesi" value="<?php echo $desi; ?>" class="form-text" size="30" maxlength="2048" disabled="disabled" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN ('".str_replace(',','\',\'',$hardware)."')");
				?>
				<div class="text-box-field">
					<select name="txthardware" id = "txthardware"  class="form-text" style="width:91%" >
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
						<!--<option value='0'>Other</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="hardwaretext"></div></div>
				
                <div class="text-box-name">Reason/Purpose:</div>
				<div class="textarea-box-field" >
					<textarea name="txtreason" id="txtreason"  class="form-text" rows="4" ></textarea> 				
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name" style="clear: left;">Have Assets?:</div>
                <div class="text-box-field">
					<input type="radio" name="have_assets" value="1" id="have_assets_yes" class="have_assets" /> Yes	
                    <input type="radio" name="have_assets" value="0" id="have_assets_no" class="have_assets" /> No			
				</div>
				<div class="text-box-field"></div>
                <div class="text-box-name" style="clear: left;">Type:</div>
                <div class="text-box-field">
					<input type="radio" name="executive" value="1" id="executive"  class="executive"/> Executive	
                    <input type="radio" name="executive" value="0" id="nonexecutive" class="executive" /> Non Executive			
				</div>
				<div class="text-box-field"></div>
                
                <div style="clear: both;">
                <input type="hidden" name="manager"  id="manager" value="<?php echo $manager; ?>"/>
				<input type="button" name="newrequest" id="newrequest" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtempreset" id="txtempreset" value="Reset" style="width:80px; height:30px;" />
				</div>
                </fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
