<?php
include 'includes/_incHeader1.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>
<?php 
if (isset($_GET['type']) && $_GET['type'] == 'otherstock') {
	$db4 = new cDB();
	$db4->Query("
		SELECT hd.name department, hh.name hardware, hm.name make, hmo.modelname model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
				FROM `hz_otherstock` hs
				LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
				LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
				LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
	");

} else if (isset($_GET['type']) && $_GET['type'] == 'availstock') {
	$db = new cDB();
	$db->Query("
	SELECT a.department department, a.hwid hwid, a.hardware hardware,a.printertypeid printertypeid, if(a.type='0','NONE',a.type) type,a.makeid makeid, a.make make, a.modelid modelid, a.model model, a .total Total, if(b.issued,b.issued,'0') Issued,if(b.issued,(a .total - b.issued),a .total) AS available
	FROM (
	(

	SELECT hd.name department, hh.id hwid, hh.name hardware,
	type printertypeid, TYPE , hm.id makeid, hm.name make, hmo.id modelid, hmo.modelname model, SUM( quantity ) total
	FROM `hz_stock` hs
	LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
	WHERE hardware !=3
	GROUP BY hardware, make, model
	)
	UNION (

	SELECT hd.name department, hh.id hwid, hh.name hardware, ht.id printertypeid, ht.printertype
	TYPE , hm.id makeid, hm.name make, hpmo.id modelid, hpmo.printermodel model, SUM( quantity ) total
	FROM `hz_stock` hs
	LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_printertype ht ON ( hs.type = ht.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id )
	WHERE hardware =3
	GROUP BY hardware, make, model
	)
	)a LEFT OUTER JOIN
	(
	(

	SELECT hh.name hardware,
	printertype TYPE, hm.name make, hmo.modelname model, hs.activestatus activestatus, COUNT( * ) issued
	FROM `hz_registration` hs
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
	WHERE hardware !=3 AND activestatus IN('A','T')
	GROUP BY hardware, make, model
	)
	UNION (

	SELECT hh.name hardware, ht.printertype
	TYPE , hm.name make, hpmo.printermodel model, hs.activestatus activestatus, count( * ) issued
	FROM `hz_registration` hs
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_printertype ht ON ( hs.printertype = ht.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id )
	WHERE hardware =3 AND activestatus IN('A','T')
	GROUP BY hardware, make, model
	)
	)b ON a.hardware = b.hardware AND a.make = b.make AND a.model = b.model
	WHERE a.hardware IN('".str_replace(',','\',\'',$hardware)."') GROUP BY a.hardware, a.make, a.model
	");
} else if (isset($_GET['type']) && $_GET['type'] == 'otheravailstock') {
	$odb = new cDB();
	$odb->Query("
	SELECT a.department department, a.hwid hwid, a.hardware hardware,a.makeid makeid, a.make make, a.modelid modelid, a.model model, a .total Total, if(b.issued,b.issued,'0') Issued,if(b.issued,(a .total - b.issued),a .total) AS available
	FROM (
		SELECT hd.name department, hh.id hwid, hh.name hardware,
		hm.id makeid, hm.name make, hmo.id modelid, hmo.modelname model, SUM( quantity ) total
		FROM `hz_otherstock` hs
		LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
		LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
		LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
		LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
		GROUP BY hardware, make, model
	)a LEFT OUTER JOIN
	(
		SELECT hh.name hardware,
		hm.name make, hmo.modelname model, COUNT( * ) issued
		FROM `hz_otherregistration` hs
		LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
		LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
		LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
		WHERE activestatus='A' GROUP BY hardware, make, model
	)b ON a.hardware = b.hardware AND a.make = b.make AND a.model = b.model
	WHERE a.hardware IN('".str_replace(',','\',\'',$otherhardware)."') GROUP BY a.hardware, a.make, a.model
	");
} else if (isset($_GET['type']) && $_GET['type'] == 'availcriticalstock') {
	$critdb = new cDB();
	$critdb->Query("
	SELECT a.department department, a.hwid hwid, a.hardware hardware,a.makeid makeid, a.make make, a.modelid modelid, a.model model, a .total Total, if(b.issued,b.issued,'0') Issued,if(b.issued,(a .total - b.issued),a .total) AS available
	FROM (
		SELECT hd.name department, hh.id hwid, hh.name hardware,
		hm.id makeid, hm.name make, hmo.id modelid, hmo.modelname model, SUM( quantity ) total
		FROM `hz_stock` hs
		LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
		LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
		LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
		LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
		GROUP BY hardware, make, model
	)a LEFT OUTER JOIN
	(
		SELECT hh.name hardware,
		hm.name make, hmo.modelname model, COUNT( * ) issued
		FROM `hz_criticalregistration` hs
		LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
		LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
		LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
		WHERE activestatus='A' GROUP BY hardware, make, model
	)b ON a.hardware = b.hardware AND a.make = b.make AND a.model = b.model
	WHERE a.hardware IN('".str_replace(',','\',\'',$criticalhardware)."') GROUP BY a.hardware, a.make, a.model
	");
} else if (isset($_GET['type']) && $_GET['type'] == 'stock') {
	$db1 = new cDB();
	$db1->Query("SELECT c.department department , c.hardware hardware , 
	if(c.type='0','NONE',c.type) type  ,  
	c.make make , 
	c.model model , 
	c.invoiceno invoiceno , 
	c.orderdate orderdate , 
	c.partyname  partyname  , 
	c.receivername  receivername  ,  
	c.quantity quantity  ,  
	c.rate rate  ,  
	c.otherstatus otherstatus  ,
	c.entrytype entrytype  ,
	c.id id  

	FROM ((SELECT hd.name department, hh.name hardware, type , hm.name make, hmo.modelname model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.entrytype entrytype, hs.id id
				FROM `hz_stock` hs
				LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
				LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
				LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id ) where hardware != 3)
			UNION
			(SELECT hd.name department, hh.name hardware, hpt.printertype type , hm.name make, hpmo.printermodel model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.entrytype entrytype, hs.id id
				FROM `hz_stock` hs
				LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
				LEFT OUTER JOIN hz_printertype hpt ON ( hs.type = hpt.id )
				LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
				LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id ) where hardware = 3))c
	");
} else if (isset($_GET['type']) && $_GET['type'] == 'transferasset') {
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

}
?>
<script type="text/javascript">
$(document).ready( function () {
	$("#stock").click(function(){
		window.location = 'stockreport.php?type=stock';
	});
	$("#otherstock").click(function(){
		window.location = 'stockreport.php?type=otherstock';
	});
	$("#availstock").click(function(){
		window.location = 'stockreport.php?type=availstock';
	});
	$("#otheravailstock").click(function(){
		window.location = 'stockreport.php?type=otheravailstock';
	});
	$("#transferasset").click(function(){
		window.location = 'stockreport.php?type=transferasset';
	});
	$("#availcriticalstock").click(function(){
		window.location = 'stockreport.php?type=availcriticalstock';
	});
	<?php if (isset($_GET['type']) && $_GET['type'] == 'stock') { ?>
	$("#stocklist").show();
	var oTable = $('#ListStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
				"aButtons": [
					{
						"sExtends": "copy",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
					},
					{
						"sExtends": "csv",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
					},
					{
						"sExtends": "xls",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
					},
					{
						"sExtends": "print",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12]
					}
				]
			},									
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	<?php } ?>
	<?php if (isset($_GET['type']) && $_GET['type'] == 'otherstock') { ?>
	$("#otherstocklist").show();
	var oTable = $('#ListOtherStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
				"aButtons": [
					{
						"sExtends": "copy",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10]
					},
					{
						"sExtends": "csv",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10]
					},
					{
						"sExtends": "xls",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10]
					},
					{
						"sExtends": "print",
						"mColumns": [0,1,2,3,4,5,6,7,8,9,10]
					}
				]
			},									
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	<?php } ?>
	<?php if (isset($_GET['type']) && $_GET['type'] == 'availstock') { ?>
	$("#filter").show();
	$("#availstocklist").show();
	var oTable = $('#ListAvailStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	$("tfoot th").each( function ( i ) {
		$('select', this).change( function () {
		  // alert("ok");
		   oTable.fnFilter( $(this).val(), i );
		});
	});
	<?php } ?>

	<?php if (isset($_GET['type']) && $_GET['type'] == 'otheravailstock') { ?>
	$("#filter").show();
	$("#otheravailstocklist").show();
	var oTable = $('#ListOtherAvailStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	$("tfoot th").each( function ( i ) {
		$('select', this).change( function () {
		  // alert("ok");
		   oTable.fnFilter( $(this).val(), i );
		});
	});
	<?php } ?>

	<?php if (isset($_GET['type']) && $_GET['type'] == 'availcriticalstock') { ?>
	$("#filter").show();
	$("#availcriticalstocklist").show();
	var oTable = $('#ListAvailCriticalStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	$("tfoot th").each( function ( i ) {
		$('select', this).change( function () {
		  // alert("ok");
		   oTable.fnFilter( $(this).val(), i );
		});
	});
	<?php } ?>

	<?php if (isset($_GET['type']) && $_GET['type'] == 'transferasset') { ?>
	$("#transferreglist").show();
	var oTable = $('#ListTransferReg').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
		"aoColumns": [ 
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null, 
				 null,
				 null,
				 null,
				 null,
				 null, 
				 null,
				 null,
				 null,
				 null,
				 { "bSortable": false },
				 null, 
				 null, 
				 null, 
			] 
	} );
	<?php } ?>
});

</script>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div style = "padding:10px 0 30px 400px">
		<div class="text-box-name"><input type="button" id="stock" value="Stock" style="width:120px;height:40px;cursor:pointer;"></div>
		<div class="text-box-name"><input type="button" id="otherstock" value="Other Stock" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="availstock" value="Available Stock" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="otheravailstock" value="Other Avail Stock" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="availcriticalstock" value="Available Critical Stock" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="transferasset" value="Transferred Asset" style="width:120px;height:40px;cursor:pointer;" ></div>
	</div>
	<div id="filter" style="padding:50px 0 0 0;display:none;">
		<?php 
		$ptype = true;
		if (isset($_GET['type']) && $_GET['type'] == 'availstock') {
			$hwlist = $hardware;
		} else if (isset($_GET['type']) && $_GET['type'] == 'otheravailstock') {
			$hwlist = $otherhardware;
			$ptype = false;
		} else {
			$hwlist = $criticalhardware;
			$ptype = false;
		}
		?>
		<table>
			<tbody>
			<tr><td><button onclick="window.location.reload();">Remove Filter</button></td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr><td><b>Filter Result</b> : </td></tr>
			</tbody>
			<tfoot>
			<th>
				<select name="txtadddepartment" id = "txtadddepartment" >
				<option value=''>----Select Department----</option>
				<?php 
				$db3 = new cDB();
				$db3->Query("SELECT * FROM hz_departments");
				if ($db3->RowCount) { 
					while ($db3->ReadRow()) {
						echo '<option value="'.mysql_real_escape_string($db3->RowData['name']).'" >'.$db3->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</th>
			<th>
				<select name="txtaddhardware" id = "txtaddhardware"  >
				<option value=''>----Select Hardware----</option>
				<?php 
				$db3->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$hwlist)."')");
				if ($db3->RowCount) { 
					while ($db3->ReadRow()) {
						echo '<option value="'.($db3->RowData['name']).'">'.$db3->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</th>
			<?php if ($ptype) { ?>
			<th>
				<select name="txtaddprintertype" id = "txtaddprintertype" >
				</select>
			</th>
			<?php } ?>
			<th>
				<select name="txtaddmake" id = "txtaddmake"  >
				</select>
			</th>
			<th>
				<select name="txtaddmodel" id = "txtaddmodel">
				</select>
			</th>
			</tfoot>
		</table>
	</div>

	<div id="availstocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListAvailStock">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Type</th>
					<th >Make</th>
					<th >Model</th>
					<th >Total</th>
					<th >Issued</th>
					<th >Available stock</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($db->RowCount){
				while ($db->ReadRow()) {
					if ($db->RowData['Issued'] !='0') {
						$issued = '<a href="#" onclick="window.open(\'issuedStockWindow.php?hwid='.$db->RowData['hwid'].'&printertypeid='.$db->RowData['printertypeid'].'&makeid='.$db->RowData['makeid'].'&modelid='.$db->RowData['modelid'].'\',\'\',\'width=800,height=800\')">'.$db->RowData['Issued'].'</a>';
					} else {
						$issued = $db->RowData['Issued'];
					}
					echo "<tr>";
					echo "<td>".$db->RowData['department']."</td>";
					echo "<td>".$db->RowData['hardware']."</td>";
					echo "<td>".$db->RowData['type']."</td>";
					echo "<td>".$db->RowData['make']."</td>";
					echo "<td>".$db->RowData['model']."</td>";
					echo "<td>".$db->RowData['Total']."</td>";
					echo "<td>".$issued."</td>";
					echo "<td>".$db->RowData['available']."</td>";
					echo "</tr>";
				}
			}

			?>

			</tbody>

		</table>
	</div>

	<div id="availcriticalstocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListAvailCriticalStock">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Make</th>
					<th >Model</th>
					<th >Total</th>
					<th >Issued</th>
					<th >Available stock</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($critdb->RowCount){
				while ($critdb->ReadRow()) {
					if ($critdb->RowData['Issued'] !='0') {
						$issued = $critdb->RowData['Issued'];
					} else {
						$issued = $critdb->RowData['Issued'];
					}
					echo "<tr>";
					echo "<td>".$critdb->RowData['department']."</td>";
					echo "<td>".$critdb->RowData['hardware']."</td>";
					echo "<td>".$critdb->RowData['make']."</td>";
					echo "<td>".$critdb->RowData['model']."</td>";
					echo "<td>".$critdb->RowData['Total']."</td>";
					echo "<td>".$issued."</td>";
					echo "<td>".$critdb->RowData['available']."</td>";
					echo "</tr>";
				}
			}

			?>

			</tbody>

		</table>
	</div>

	<div id="otheravailstocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListOtherAvailStock">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Make</th>
					<th >Model</th>
					<th >Total</th>
					<th >Issued</th>
					<th >Available stock</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($odb->RowCount){
				while ($odb->ReadRow()) {
					if ($odb->RowData['Issued'] !='0') {
						$issued = '<a href="#" onclick="window.open(\'otherIssuedStockWindow.php?hwid='.$odb->RowData['hwid'].'&makeid='.$odb->RowData['makeid'].'&modelid='.$odb->RowData['modelid'].'\',\'\',\'width=800,height=800\')">'.$odb->RowData['Issued'].'</a>';
					} else {
						$issued = $odb->RowData['Issued'];
					}
					echo "<tr>";
					echo "<td>".$odb->RowData['department']."</td>";
					echo "<td>".$odb->RowData['hardware']."</td>";
					echo "<td>".$odb->RowData['make']."</td>";
					echo "<td>".$odb->RowData['model']."</td>";
					echo "<td>".$odb->RowData['Total']."</td>";
					echo "<td>".$issued."</td>";
					echo "<td>".$odb->RowData['available']."</td>";
					echo "</tr>";
				}
			}

			?>

			</tbody>

		</table>
	</div>

	<div id="stocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListStock">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Type</th>
					<th >Make</th>
					<th >Model</th>
					<th >Invoice</th>
					<th >Date</th>
					<th >Party Name</th>
					<th >Receiver Name</th>
					<th >Quantity</th>
					<th >Rate</th>
					<th >Other Status</th>
					<th >Entry Type</th>
					<th >Edit</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($db1->RowCount){
				while ($db1->ReadRow()) {
					$date = getdate($db1->RowData['orderdate']);
					echo "<tr>";
					echo "<td>".$db1->RowData['department']."</td>";
					echo "<td>".$db1->RowData['hardware']."</td>";
					echo "<td>".$db1->RowData['type']."</td>";
					echo "<td>".$db1->RowData['make']."</td>";
					echo "<td>".$db1->RowData['model']."</td>";
					echo "<td>".$db1->RowData['invoiceno']."</td>";
					echo "<td>".$date['mday']."/".$date['mon']."/".$date['year']."</td>";
					echo "<td>".$db1->RowData['partyname']."</td>";
					echo "<td>".$db1->RowData['receivername']."</td>";
					echo "<td>".$db1->RowData['quantity']."</td>";
					echo "<td>".$db1->RowData['rate']."</td>";
					echo "<td>".$db1->RowData['otherstatus']."</td>";
					echo "<td>".$db1->RowData['entrytype']."</td>";
					echo '<td><a href="editStock.php?id='.base64_encode($db1->RowData['id']).'" title="click to edit""><img src="images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deletestock" style="cursor:pointer"><input type="hidden" class="delstockid" value="'.$db1->RowData['id'].'" ><img src="images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span></td>';
					echo "</tr>";
				}
			}

			?>

			</tbody>

		</table>
	</div>

	<div id="otherstocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListOtherStock">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Make</th>
					<th >Model</th>
					<th >Invoice</th>
					<th >Date</th>
					<th >Party Name</th>
					<th >Receiver Name</th>
					<th >Quantity</th>
					<th >Rate</th>
					<th >Other Status</th>
					<th >Edit</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($db4->RowCount){
				while ($db4->ReadRow()) {
					$date = getdate($db4->RowData['orderdate']);
					echo "<tr>";
					echo "<td>".$db4->RowData['department']."</td>";
					echo "<td>".$db4->RowData['hardware']."</td>";
					echo "<td>".$db4->RowData['make']."</td>";
					echo "<td>".$db4->RowData['model']."</td>";
					echo "<td>".$db4->RowData['invoiceno']."</td>";
					echo "<td>".$date['mday']."/".$date['mon']."/".$date['year']."</td>";
					echo "<td>".$db4->RowData['partyname']."</td>";
					echo "<td>".$db4->RowData['receivername']."</td>";
					echo "<td>".$db4->RowData['quantity']."</td>";
					echo "<td>".$db4->RowData['rate']."</td>";
					echo "<td>".$db4->RowData['otherstatus']."</td>";
					echo '<td><a href="editOtherStock.php?id='.base64_encode($db4->RowData['id']).'" title="click to edit""><img src="images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deleteotehrstock" style="cursor:pointer"><input type="hidden" class="delotherstockid" value="'.$db4->RowData['id'].'" ><img src="images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span></td>';
					echo "</tr>";
				}
			}

			?>

			</tbody>

		</table>
	</div>
	<div id="transferreglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListTransferReg">
				<thead>
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
						echo "<td>".$tdb->RowData['warnorvendor']."</td>";
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
<script>
</script>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
