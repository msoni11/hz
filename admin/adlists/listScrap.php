<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
	$('#emplist').show();
	oTable=$('#ListEmployees').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"aButtons": [
				{
					"sExtends": "copy",
					"mColumns": [0,1,2,3,4]
				},
				{
					"sExtends": "csv",
					"mColumns": [0,1,2,3,4]
				},
				{
					"sExtends": "xls",
					"mColumns": [0,1,2,3,4]
				},
				{
					"sExtends": "pdf",
					"mColumns": [0,1,2,3,4]
				},
				{
					"sExtends": "print",
					"mColumns": [0,1,2,3,4]
				}
			]
		},									
		"bProcessing": false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"sPaginationType": "full_numbers",
//		"sAjaxSource": "../ajax/ajax_emp.php",
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"oLanguage": {
		"sSearch": "Enter ID/NAME to restrict result for:",
		"sInfoEmpty": "No Records Found",
		},
	} );

});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div id="emplist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListEmployees">
				<thead>
					<tr>
						<th >Hardware</th>
						<th >Type</th>
						<th >Serial Number</th>
						<th >Reason</th>
						<th >Approved</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				$db = new cDB();
				$db->Query("SELECT hs.*,hh.name,hp.serial,hp.ConfigurationID FROM hz_scraps hs, hz_hardware hh, hz_products hp WHERE hs.HardwareID=hh.id AND hs.ProductID=hp.ProductID AND hs.ldapID=".$_SESSION['ldapid']);
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						if ($db->RowData['HardwareID']==1) {
							$type = $db->RowData['ConfigurationID']==0?'TFT':'CPU';
						} else {
							$type = 'NONE';
						}
					if ($db->RowData['status'] == 0) {
						$status = 'Waiting for GM\'s Approval';
					} else if ($db->RowData['status'] == 1) {
						$status = 'Accepted';
					} else if ($db->RowData['status'] == 2) {
						$status = 'Rejected';
					}
					echo "<tr>";
						echo "<td >".$db->RowData['name']."</th>";
						echo "<td >".$type."</th>";
						echo "<td >".$db->RowData['serial']."</th>";
						echo "<td >".$db->RowData['Reason']."</th>";
						echo "<td >".$db->RowData['Apporved']."</th>";
						echo "<td >".$status."</th>";
					echo "</tr>";
					}
				}
				?>
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
