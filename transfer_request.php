<?php
include 'includes/_incHeader.php';
$db = new cDB();

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 0) {
	header("Location:logout.php");
}

//accesing session data or dumping sample data
$username = ($_SESSION["adldapinfo"][0]["description"][0]) ? $_SESSION["adldapinfo"][0]["description"][0] : "444444";
$name = ($_SESSION["adldapinfo"][0]["cn"][0]) ? $_SESSION["adldapinfo"][0]["cn"][0] : "John Doe";
$dept = ($_SESSION["adldapinfo"][0]["department"][0]) ? $_SESSION["adldapinfo"][0]["department"][0] : "CES-IT";
$desi = ($_SESSION["adldapinfo"][0]["title"][0]) ? $_SESSION["adldapinfo"][0]["title"][0] : "CEO";
$manager= ($_SESSION["adldapinfo"]["managermail"][0]["mail"][0]) ? $_SESSION["adldapinfo"]["managermail"][0]["mail"][0] : "him.developer@gmail.com";

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
				<fieldset><legend>Transfer Asset</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Emp Username:</div>
				<div class="text-box-field">
					<input type="text" name="txtempid" id="txtempid" value="" class="form-text" size="30" maxlength="2048"  />
				</div>
				<div class="text-box-field"></div>
				
				<div id="hideEmpDetails" style="display:none">
				<div class="text-box-name">Employee ID:</div>
				<div class="text-box-field">
					<input type="text" name="txtempiddesc" id="txtempiddesc" value="" class="form-text" size="30" maxlength="2048"  />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtempname" id="txtempname" value="" class="form-text" size="30" maxlength="2048"  />				
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<input type="text" name="txtempdept" id="txtempdept" value="" class="form-text" size="30" maxlength="2048"  />				
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">Designation:</div>
				<div class="text-box-field">
					<input type="text" name="txtempdesi" id="txtempdesi" value="" class="form-text" size="30" maxlength="2048"  />				
				</div>
				<div class="text-box-field"></div>
				</div>
                
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
                
                <div class="text-box-name">Sr No:</div>
				<div class="text-box-field">
					<select name="txtserial" id = "txtserial"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Serial Number----</option>
					</select>
				</div>
				<div class="text-box-field"><div id="serialtext"></div></div>
                
                
                <div class="text-box-name" style="clear: left;">Mail Id:</div>
                <div class="text-box-field">
					<input type="text" name="txtempemailid" id="txtempemailid" value="" class="form-text" size="30" maxlength="2048"  />				
				
                    
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">Reason for transfer:</div>
				<div class="textarea-box-field" >
					<textarea name="txtreason" id="txtreason"  class="form-text" rows="4" ></textarea> 				
				</div>
				<div class="text-box-field"></div>
                
                
                
                
                <input type="hidden" name="receiverManager"  id="receiverManager" value=""/>
                <input type="hidden" name="receiverMail"  id="receiverMail" value=""/>
                
                <div style="clear: both;">
                <input type="hidden" name="manager"  id="manager" value="<?php echo $manager; ?>"/>
                <input type="hidden" name="requestor" id="requestor" value="<?php echo $username; ?>" />
                <input type="hidden" name="requestorname" id="requestorname" value="<?php echo $name; ?>" />
                <input type="hidden" name="requestordept" id="requestordept" value="<?php echo $dept; ?>" />
                <input type="hidden" name="requestordesi" id="requestordesi" value="<?php echo $desi; ?>" />
				<input type="button" name="newTrequest" id="newTrequest" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtempreset" id="txtempreset" value="Reset" style="width:80px; height:30px;" />
				</div>
                </fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
