<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
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

				<div class="text-box-name">User type:</div>
				<div class="text-box-field">
					<select name="txtusertype" id = "txtusertype"  class="form-text" style="width:91%" >
						<option value='anmuser' selected >Anonymous</option>
						<option value='admin'>admin</option>
					</select>
				</div>
				<div class="text-box-field"></div>

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
