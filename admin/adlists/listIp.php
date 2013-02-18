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
					"mColumns": [0,1,2,3]
				},
				{
					"sExtends": "csv",
					"mColumns": [0,1,2,3]
				},
				{
					"sExtends": "xls",
					"mColumns": [0,1,2,3]
				},
				{
					"sExtends": "pdf",
					"mColumns": [0,1,2,3]
				},
				{
					"sExtends": "print",
					"mColumns": [0,1,2,3]
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
						<th style="display:none">ID</th>
						<th >IP</th>
						<th >Emp Username</th>
						<th >Employeed ID</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				$db = new cDB();
				$db1 = new cDB();
				$db->Query("SELECT * FROM hz_ip_address WHERE LdapID=".$_SESSION['ldapid']." ORDER BY IpAddressID " );
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						echo "<tr>";
						echo "<td style='display:none' >".$db->RowData['IpAddressID']."</td>";
						echo "<td>".$db->RowData['Address']."</td>";
						$db1->Query("SELECT hr.empid, hr.ipaddr,he.empiddescr FROM hz_registration hr, hz_employees he WHERE ipaddr=".$db->RowData['IpAddressID']." AND activestatus='A'");
						if($db1->RowCount) {
							if($db1->ReadRow()) {
								echo "<td>".$db1->RowData['empid']."</td>";
								echo "<td>".$db1->RowData['empiddescr']."</td>";
								echo "<td>Reserved</td>";
							}
						} else {
							echo "<td>NONE</td>";
							echo "<td>NONE</td>";
							echo "<td>Free</td>";
						}
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
