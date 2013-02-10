<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 2) {
	header("Location:logout.php");
}
?>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="newuserform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add User</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Username:</div>
				<div class="text-box-field">
					<input type="text" name="txtusername" id="txtusername" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Password:</div>
				<div class="text-box-field">
					<input type="password" name="txtpassword" id="txtpassword" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">AD Location:</div>
				<?php $db->Query('SELECT id,location FROM config_ldap'); ?>
				<div class="text-box-field">
					<select name="txtlocation" id = "txtlocation"  class="form-text" style="width:91%;height:150px" multiple>
						<?php 
						if ($db->RowCount) {
							while ($db->ReadRow()) {
								echo "<option value=".$db->RowData['id']." >".$db->RowData['location']."</option>";
							}
						}
						?>
					</select>
				</div>
				<div class="text-box-field" style="height:150px;"></div>

				<input type="button" name="newuserbtn" id="newuserbtn" value="Create Account" style="width:120px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtreset" id="txtreset" value="Reset" style="width:80px; height:30px;" />
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
