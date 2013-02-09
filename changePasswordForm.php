<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="changePasswordForm" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Update profile</legend>
				<input type="hidden" name="txtchangeuname" id="txtchangeuname" value="<?php echo $_SESSION['username']; ?>">
				<input type="hidden" name="txtchangeadmin" id="txtchangeadmin" value="<?php echo $_SESSION['isadmin']; ?>">
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Old Password:</div>
				<div class="text-box-field">
					<input type="password" name="txtoldpassword" id="txtoldpassword" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">New Password:</div>
				<div class="text-box-field">
					<input type="password" name="txteditpassword" id="txteditpassword" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
				
				<div class="text-box-name">Confirm Password:</div>
				<div class="text-box-field">
					<input type="password" name="txtconfirmpassword" id="txtconfirmpassword" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
				
				<input type="button" name="newchangepwdbtn" id="newchangepwdbtn" value="Update" style="width:80px; height:30px;margin-left:90px" /> 
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
