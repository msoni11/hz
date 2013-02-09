<?php
include '../includes/_incHeader2.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}

	$tdb = new cDB();
	$tdb->Query("
		SELECT 
		a.empid empid,
		a.empname empname,
		a.unit unit,
		a.department department,
		a.designation designation,
		a.hardware hardware,
		if (a.printertype='0','NONE', a.printertype) printertype,
		a.make make, 
		a.model model, 
		a.cpuno cpuno, 
		a.monitortype monitortype, 
		a.monitorno monitorno, 
		a.sysconfig sysconfig, 
		a.cartage cartage, 
		a.assetcode assetcode, 
		a.ipaddr ipaddr, 
		a.officever officever, 
		a.licensesoft licensesoft, 
		a.internet internet, 
		a.internettype internettype, 
		a.warnorvendor warnorvendor, 
		a.date date, 
		a.otheritasset otheritasset, 
		a.status status, 
		a.id id	FROM 
		((SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, printertype, hm.name make, hmo.modelname model, cpuno, monitortype, monitorno, hc.config sysconfig, cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
			FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_model hmo ON ( hr.model = hmo.id ) WHERE hardware != 3 AND activestatus='T')
		UNION 
		(SELECT he.empid as empid, empname, unit, department, designation, hh.name hardware, hpt.printertype printertype, hm.name make, hpmo.printermodel model, cpuno, monitortype, monitorno, sysconfig, hcar.cartage cartage, assetcode, ipaddr, officever, licensesoft, internet, internettype, warnorvendor, date, otheritasset, status, hr.id as id
		FROM hz_registration hr 
			LEFT OUTER JOIN hz_employees he ON (hr.empid = he.empid)
			LEFT OUTER JOIN hz_hardware hh ON ( hr.hardware = hh.id )
			LEFT OUTER JOIN hz_cartage hcar ON ( hr.cartage = hcar.id )
			LEFT OUTER JOIN hz_printertype hpt ON ( hr.printertype = hpt.id )
			LEFT OUTER JOIN hz_make hm ON ( hr.make = hm.id )
			LEFT OUTER JOIN hz_configuration hc ON ( hr.make = hc.id )
			LEFT OUTER JOIN hz_printermodel hpmo ON ( hr.model = hpmo.id ) WHERE hardware = 3 AND activestatus='T'))a
		
	");

?>
<script type="text/javascript">
$(document).ready( function () {
	$("#transferreglist").show();
	var oTable = $('#ListTransferReg').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"bFilter":true,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );

	var AoH = $('#ListTransferReg thead tr:gt(1)').map(function(){
    return [
        $('th',this).map(function(){
            return $(this).text();
        }).get()
    ];
	}).get();
	var jsonH = JSON.stringify(AoH);
	$("#tableheaddata").val(jsonH);

	var AoA = $('#ListTransferReg tr:gt(2)').map(function(){
    return [
        $('td',this).map(function(){
            return $(this).text();
        }).get()
    ];
	}).get();
	var json = JSON.stringify(AoA);
	$("#tabledata").val(json);

} );
</script>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
		<form name="exportExcel" method="post" action="../export.php">
		<input type="hidden" name="tabledata" id="tabledata">
		<input type="hidden" name="tableheaddata" id="tableheaddata">
		<tr><td><input type="submit" name="excelimport" value="Export to excel"></td></tr>
		</form>
	<div id="transferreglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListTransferReg">
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
				<?php 
				if ($tdb->RowCount){
					while ($tdb->ReadRow()) {
					$dateArray = getdate($tdb->RowData['date']);
					$warnArray = getdate($tdb->RowData['warnorvendor']);
					echo "<tr>";
						echo "<td>".$tdb->RowData['empid']."</td>";
						echo "<td>".$tdb->RowData['empname']."</td>";
						echo "<td>".$tdb->RowData['unit']."</td>";
						echo "<td>".$tdb->RowData['department']."</td>";
						echo "<td>".$tdb->RowData['designation']."</td>";
						echo "<td>".$tdb->RowData['hardware']."</td>";
						echo "<td>".$tdb->RowData['printertype']."</td>";
						echo "<td>".$tdb->RowData['make']."</td>";
						echo "<td>".$tdb->RowData['model']."</td>";
						echo "<td>".$tdb->RowData['cpuno']."</td>";
						echo "<td>".$tdb->RowData['monitortype']."</td>";
						echo "<td>".$tdb->RowData['monitorno']."</td>";
						echo "<td width='10%'>".$tdb->RowData['sysconfig']."</td>";
						echo "<td>".$tdb->RowData['cartage']."</td>";
						echo "<td>".$tdb->RowData['assetcode']."</td>";
						echo "<td>".$tdb->RowData['ipaddr']."</td>";
						echo "<td>".$tdb->RowData['officever']."</td>";
						echo "<td>".$tdb->RowData['licensesoft']."</td>";
						echo "<td>".$tdb->RowData['internet']."</td>";
						echo "<td>".$tdb->RowData['internettype']."</td>";
						echo "<td>".$warnArray['mday'].'/'.$warnArray['mon'].'/'.$warnArray['year']."</td>";
						echo "<td>".$dateArray['mday'].'/'.$dateArray['mon'].'/'.$dateArray['year']."</td>";
						echo "<td>".$tdb->RowData['otheritasset']."</td>";
						echo "<td>".$tdb->RowData['status']."</td>";
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
