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
						<th >Name</th>
						<th >Unit</th>
						<th >IP</th>
						<th >Internet</th>
						<th >Reporting Person</th>
						<th >Reporting Person's Email</th>
						<th >Mobile</th>
						<th >Duration from</th>
						<th >Duration to</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				$db = new cDB();
				$db->Query('SELECT * FROM hz_ip hi,hz_units hu,hz_ip_address hia WHERE hi.unit = hu.id AND hi.ip = hia.IpAddressID AND hi.ldapID='.$_SESSION['ldapid']);
				if ($db->RowCount) {
					while ($db->ReadRow()) {
						$dateFrom = getdate($db->RowData['durationFrom']);
						$dateTo   = getdate($db->RowData['durationTo']);
						$dateF = $dateFrom['mday'].'/'.$dateFrom['mon'].'/'.$dateFrom['year'];
						$dateT = $dateTo['mday'].'/'.$dateTo['mon'].'/'.$dateTo['year'];
						echo "<tr>";
							echo "<td >".$db->RowData['auditorName']."</td>";
							echo "<td >".$db->RowData['name']."</td>";
							echo "<td >".$db->RowData['Address']."</td>";
							echo "<td >".$db->RowData['internet']."</td>";
							echo "<td >".$db->RowData['repPerson']."</td>";
							echo "<td >".$db->RowData['repPersonEmail']."</td>";
							echo "<td >".$db->RowData['mobile']."</td>";
							echo "<td >".$dateF."</td>";
							echo "<td >".$dateT."</td>";
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
