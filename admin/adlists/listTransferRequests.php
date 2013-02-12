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
						<th >Requestor Username</th>
						<th >Receiver Username</th>
						<th >Hardware</th>
						<th >Asset Code</th>
						<th >Reason</th>
						<th >Status</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				$options = getLdapOU($_SESSION['ldapid']);
				$db = new cDB();
				for ($i=0;$i<count($options);$i++) {
			        $adldap = initializeLDAP($options[$i]);
			        $users = $adldap->user()->all();
			        foreach ($users as $key=>$user) {
						$db->Query("SELECT * FROM hz_transfer_requests htr, hz_hardware hh, hz_products hp WHERE htr.HardwareID=hh.id AND htr.ProductID=hp.productID AND htr.RequestorID='".$user."'");
						if ($db->RowCount) {
							while ($db->ReadRow()) {
								$status = $db->RowData['Status'];
								$fmStatus = $db->RowData['FirstManagerRejected'];
								$empStatus= $db->RowData['ReceiverRejected'];
								$smStatus = $db->RowData['SecondManagerRejected'];
								$hStatus  = $db->RowData['HodRejected'];
								if ($status == 0) {
									if ($fmStatus == 1) {
										$printMsg = 'Rejected By Requestor\'s Manager';
									} else {
										$printMsg = 'Waiting for Requestor\'s Manager\'s Approval';
									}
								} else if ($status == 1) {
									if ($empStatus == 1) {
										$printMsg = 'Rejected By Employee';
									} else {
										$printMsg = 'Waiting for Employee\'s Approval';
									}
								} else if ($status == 2) {
									if ($smStatus == 1) {
										$printMsg = 'Rejected By Receiver\'s Manager';
									} else {
										$printMsg = 'Waiting for Receiver\'s Manager\'s Approval';
									}
								} else if ($status == 3) {
									if ($hStatus == 1) {
										$printMsg = 'Rejected By HOD';
									} else {
										$printMsg = 'Waiting for HOD\'s Approval';
									}
								} else {
									$printMsg = "<a href='../userasset.php?uname=".$db->RowData['EmployeeID']."'>Approved</a>";
								}
								echo "<tr>";
									echo "<td >".$db->RowData['RequestorID']."</td>";
									echo "<td >".$db->RowData['EmployeeID']."</td>";
								    echo "<td >".$db->RowData['name']."</td>";
								    echo "<td >".$db->RowData['asset_code']."</td>";
								    echo "<td >".$db->RowData['TransferReason']."</td>";
								    echo "<td >".$printMsg."</td>";
								echo "</tr>";
							}
						}
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
