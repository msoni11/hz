<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
	$('#reglist').show();
	$('#ListReg').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"aButtons": [
				{
					"sExtends": "copy",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
				},
				{
					"sExtends": "csv",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
				},
				{
					"sExtends": "xls",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
				},
				{
					"sExtends": "pdf",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
				},
				{
					"sExtends": "print",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23]
				}
			]
		},									
		"bProcessing": false,
		//"bServerSide":true,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"sPaginationType": "full_numbers",
		//"sAjaxSource": "../ajax/ajax_reg.php",
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
	} );
});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div id="reglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListReg">
				<thead>
					<tr>
						<th >Employee username</th>
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
						<th >Internet</th>
						<th >type</th>
						<th >Warn/Vendor</th>
						<th >Date</th>
						<th >Current Location</th>
						<th >Status</th>
						<th >Edit</th>
					</tr>
				</thead>
			<?php 
				$db = new cDB();
				$db1 = new cDB();
				$sql = "SELECT hr.* FROM 
						hz_registration hr LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid) WHERE hr.activestatus='A' and hr.ldapID=".$_SESSION['ldapid'];
				$db1->Query($sql);
				if ($db1->RowCount) {
					while ($db1->ReadRow()) {
						$empid      = $db1->RowData['empid'];
						$assetID    = $db1->RowData['id'];
						$hardware   = $db1->RowData['hardware'];
						$cartage    = $db1->RowData['cartage'];
						$pritertype = $db1->RowData['printertype'];
						$make       = $db1->RowData['make'];
						$model      = $db1->RowData['model'];
						$cpuno      = $db1->RowData['cpuno'];
						$monitortype= $db1->RowData['monitortype'];
						$monitorno  = $db1->RowData['monitorno'];
						$sysconfig  = $db1->RowData['sysconfig'];
						$assetcode  = $db1->RowData['assetcode'];
						$ipaddr     = $db1->RowData['ipaddr'];
						$internet   = $db1->RowData['internet'];
						$internettype= $db1->RowData['internettype'];
						$warnorvendor= $db1->RowData['warnorvendor'];
						$date       = $db1->RowData['date'];
						$location   = $db1->RowData['location'];
						$status     = $db1->RowData['status'];

						$db->Query("SELECT * FROM hz_employees WHERE empid='".$empid."'");
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$empdetails = $db->RowData;
							}
						}
						$db->Query("SELECT name FROM hz_hardware WHERE id=".$hardware);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$hwname = $db->RowData['name'];
							}
						}
						$db->Query("SELECT name FROM hz_make WHERE id=".$make);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$make = $db->RowData['name'];
							}
						}
						$db->Query("SELECT modelname FROM hz_model WHERE id=".$model);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$model = $db->RowData['modelname'];
							}
						}
						$db->Query("SELECT serial FROM hz_products WHERE productID=".$cpuno);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$cpuno = $db->RowData['serial'];
							}
						}
						if ($hardware == 1) {
							$db->Query("SELECT serial FROM hz_products WHERE productID=".$monitorno);
							if ($db->RowCount) {
								if ($db->ReadRow()) {
									$monitorno= $db->RowData['serial'];
								}
							}
						}
						if ($hardware == 3) {
							$db->Query("SELECT cartage FROM hz_printertype WHERE id=".$pritertype);
							if ($db->RowCount) {
								if ($db->ReadRow()) {
									$cartage = $db->RowData['printertype'];
								}
							}
							
							$db->Query("SELECT printertype FROM hz_printertype WHERE id=".$pritertype);
							if ($db->RowCount) {
								if ($db->ReadRow()) {
									$pritertype = $db->RowData['printertype'];
								}
							}
						}
						
						$db->Query("SELECT config FROM hz_configuration WHERE id=".$sysconfig);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$sysconfig = $db->RowData['config'];
							}
						}

						$db->Query("SELECT LocationName FROM hz_locations WHERE LocationID=".$location);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$location = $db->RowData['LocationName'];
							}
						}

						$db->Query("SELECT Address FROM hz_ip_address WHERE IpAddressID=".$ipaddr);
						if ($db->RowCount) {
							if ($db->ReadRow()) {
								$ipaddr = $db->RowData['Address'];
							}
						}
					$pritertype = $pritertype == 0 ? 'NONE' : $pritertype;
					$monitorno  = $monitorno == -1 ? 'NONE' : $monitorno;
					if ($internettype != 'AMC') {
						$worv         = getdate($warnorvendor);
						$warnorvendor = $worv['mday'].'/'.$worv['mon'].'/'.$worv['year'];
					}
					$datets = getdate($date);
					$date = $datets['mday'].'/'.$datets['mon'].'/'.$datets['year'];
									
					echo "<tr>";
						echo "<td >".$empdetails['empid'] ."</td>";
						echo "<td >".$empdetails['empiddescr'] ."</td>";
						echo "<td >".$empdetails['empname'] ."</td>";
						echo "<td >".$empdetails['unit'] ."</td>";
						echo "<td >".$empdetails['department'] ."</td>";
						echo "<td >".$empdetails['designation'] ."</td>";
						echo "<td >".$hwname ."</td>";
						echo "<td >".$pritertype ."</td>";
						echo "<td >".$make ."</td>";
						echo "<td >".$model ."</td>";
						echo "<td >".$cpuno ."</td>";
						echo "<td >".$monitortype ."</td>";
						echo "<td >".$monitorno ."</td>";
						echo "<td >".$sysconfig ."</td>";
						echo "<td >".$cartage ."</td>";
						echo "<td >".$assetcode ."</td>";
						echo "<td >".$ipaddr ."</td>";
						echo "<td >".$internet ."</td>";
						echo "<td >".$internettype ."</td>";
						echo "<td >".$warnorvendor ."</td>";
						echo "<td >".$date ."</td>";
						echo "<td >".$location ."</td>";
						echo "<td >".$status ."</td>";
						echo "<td ><input type='hidden' name='assetID' id='assetID' value='".$assetID."' /><a href='#'><img src='../images/delete-icon.png'' id='moveToS' alt='Click to move it to store' title='Click to move it to store' /></a></td>";
					echo "</tr>";
						
					}
				}
			?>
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
