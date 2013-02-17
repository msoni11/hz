<?php
include 'includes/_incHeader.php';
$db = new cDB();
if (!isset($_SESSION['username']) || !$_SESSION['isadmin'] == 1) {
	header("Location:logout.php");
}
?>
<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->
<script>
$("#trackSer").live('click', function() {
	$("#loader").show();
	$serno = encodeURIComponent($('#txtserno').val());
	$.ajax({
		url:'trackAsset.php',
		data:'serno='+$serno,
		type:'POST',
		success: function(val){
			if (val == 104){
				$("#loader").hide();
				alert('Form field not receiver! Try again later');
				window.location.reload
			} else if (val == 103) {
				$("#loader").hide();
				alert('No record(s) found with this serial number');
				$("#hideDetails").empty();				
			} else if (val == 101) {
				$("#loader").hide();
				alert('Session expired! Login again');
				window.location = 'logout.php';
			} else {
				$("#loader").hide();
				$("#hideDetails").empty().append(val);
			}
		}

	});
});
</script>

<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="assetVerification" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Asset Verification</legend>
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Enter Serial Number:</div>
				<div class="text-box-field">
					<input type="text" name="txtserno" id="txtserno" value="" class="form-text" size="30" maxlength="2048" />
				</div>
				<div class="text-box-field"></div>

				<input type="button" name="trackSer" id="trackSer" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="trackSerreset" id="trackSerreset" value="Reset" style="width:80px; height:30px;" />

				</fieldset>
				<div id="hideDetails">
				</div>
			</form>
		</div>
	</div>
</div>
<?php 
include 'includes/_incFooter.php';
?>