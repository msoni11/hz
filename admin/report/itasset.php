<?php
include '../includes/_incHeader2.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
		$('#crystreglist').show();
		$('#crystListReg').dataTable( {
			"sDom": 'T<"clear">lfrtip',
					"bProcessing": false,
					"bServerSide":true,
					"bFilter":false,
					"iDisplayStart":0,
					"iDisplayLength":10,
					"sPaginationType": "full_numbers",
					"sAjaxSource": "../ajax/ajax_reg.php",
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		} );
	} );
</script>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">

	<div id="crystreglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="crystListReg">
				<thead>
				<tr>
					<th colspan ="24" align="center"><table align="center"><tr><td><img src="../images/logo.gif" height = "130" width = "130" class="imgset" /></td><td><h2>Hindustan Zinc Limited</h2><br />smelter, chanderia</td></tr></table></th>
				</tr>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
						<th >Hardware</th>
						<th >Printer Type</th>
						<th >Make</th>
						<th >Model</th>
						<th >CPU no.</th>
						<th >Monitor</th>
						<th >CRT/TFT no.</th>
						<th >configuration</th>
						<th >Cartage</th>
						<th >Asset code</th>
						<th >IP</th>
						<th >MS Office</th>
						<th >License software</th>
						<th >Internet</th>
						<th >type</th>
						<th >Warn/Vendor</th>
						<th >Date</th>
						<th >Other IT asset</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>
</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
