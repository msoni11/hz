<?php
include 'includes/_incHeader.php';
?>
<!-- Content start -->

<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div style="padding: 0px 0 0 250px;">
			<div id="login-box">
				<H2>Login</H2>
				<br />
				<div class="error" style="display:block">
				<?php foreach ($_SESSION['status'] as $sesserror) { 
					echo $sesserror;
				} ?>
				</div>
				<br />
				<form name="login" action="redirect.php" method="post">
					<div class="login-box-name" style="margin-top:20px;">User type:</div>
					<div class="login-box-field" style="margin-top:20px;">
						<?php $db->Query('SELECT id,location FROM config_ldap'); ?>
						<select name="txtusertype" id = "txtusertype"  class="form-login" style="width:93%" />
							<option value="anuser" selected="selected">Anonymous user</option>
							<?php 
							if ($db->RowCount) {
								while ($db->ReadRow()) {
									echo "<option value=".$db->RowData['id']." >".$db->RowData['location']."</option>";
								}
							}
							?>
						</select>
					</div>
					
					<div class="login-box-name">Username:</div>
					<div class="login-box-field">
						<input name="txtusername" id="txtusername" type="text" class="form-login" title="username" value="" size="30" maxlength="2048" />
					</div>
					
					<div class="login-box-name">Password:</div>
					<div class="login-box-field">
						<input name="txtpassword" id="txtpassword" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" />
					</div>
					<br />
					<br />
					<br />
					<input type="submit" name="txtsubmit" id="txtsubmit" value="Login" style="width:80px; height:40px;margin-left:90px;" />
					<input type="reset" name="txtreset" id="txtreset" value="Reset" style="width:80px; height:40px;" />
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Content End -->
<?php
include 'includes/_incFooter.php';
session_destroy();
?>