<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || !$_SESSION['isadmin'] == 1) {
	header("Location:logout.php");
}
?>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<script src="../js/extra.js"></script>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="ipform" id="ipform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Add IP Address</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">From:</div>
				<div class="text-box-field">
					<input type="text" name="start" id="start" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
                
                <div class="text-box-name">To:</div>
				<div class="text-box-field">
					<input type="text" name="end" id="end" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>
                
                
                <input type="button" name="newIP" id="newIP" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtempreset" id="txtempreset" value="Reset" style="width:80px; height:30px;" />
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