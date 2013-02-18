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
						<th >Make</th>
						<th >Model</th>
						<th >Serial Number</th>
						<th >Configuration</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				$db = new cDB();
				$db1 = new cDB();
				$db->Query("SELECT * FROM hz_products hp,hz_stock hs WHERE hs.id=hp.stockID AND hs.adminID=".$_SESSION['ldapid']." AND hp.status = 2");
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						$db1->Query("SELECT name FROM hz_hardware WHERE id=".$db->RowData['hardware']);
						if ($db1->RowCount) {
							if ($db1->ReadRow()) {
								$hwname = $db1->RowData['name'];
							}
						}
						$db1->Query("SELECT name FROM hz_make WHERE id=".$db->RowData['make']);
						if ($db1->RowCount) {
							if ($db1->ReadRow()) {
								$make = $db1->RowData['name'];
							}
						}
						$db1->Query("SELECT modelname FROM hz_model WHERE id=".$db->RowData['model']);
						if ($db1->RowCount) {
							if ($db1->ReadRow()) {
								$model = $db1->RowData['modelname'];
							}
						}
						$db1->Query("SELECT config FROM hz_configuration WHERE id=".$db->RowData['configurationID']);
						if ($db1->RowCount) {
							if ($db1->ReadRow()) {
								$sysconfig = $db1->RowData['config'];
							}
						} else {
							$sysconfig = 'NONE';
						}
						
					echo "<tr>";
						echo "<td >".$hwname."</th>";
						echo "<td >".$make."</th>";
						echo "<td >".$model."</th>";
						echo "<td >".$db->RowData['serial']."</th>";
						echo "<td >".$sysconfig ."</th>";
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
