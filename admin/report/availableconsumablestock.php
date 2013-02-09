<?php
include '../includes/_incHeader2.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}

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

?>
<script type="text/javascript">
$(document).ready( function () {
	$("#otheravailstocklist").show();
	var oTable = $('#ListOtherAvailStock').dataTable( {
		"sDom": 'T<"clear">lrtip',
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

	var AoH = $('#ListOtherAvailStock thead tr:gt(1)').map(function(){
    return [
        $('th',this).map(function(){
            return $(this).text();
        }).get()
    ];
	}).get();
	var jsonH = JSON.stringify(AoH);
	$("#tableheaddata").val(jsonH);

	var AoA = $('#ListOtherAvailStock tr:gt(2)').map(function(){
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
	<table>
		<tbody>
		<form name="exportExcel" method="post" action="../export.php">
		<input type="hidden" name="tabledata" id="tabledata">
		<input type="hidden" name="tableheaddata" id="tableheaddata">
		<tr><td><input type="submit" name="excelimport" value="Export to excel"></td></tr>
		</form>
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
			$db3->Query("SELECT * FROM hz_hardware WHERE name IN('".str_replace(',','\',\'',$otherhardware)."')");
			if ($db3->RowCount) { 
				while ($db3->ReadRow()) {
					echo '<option value="'.($db3->RowData['name']).'">'.$db3->RowData['name'].'</option>';
				} 
			}
			?>
			</select>
		</th>
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
	<div id="otheravailstocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListOtherAvailStock">
			<thead>
				<tr>
					<th colspan ="7" align="center"><table align="center"><tr><td><img src="../images/logo.gif" height = "130" width = "130" class="imgset" /></td><td><h2>Hindustan Zinc Limited</h2><br />smelter, chanderia</td></tr></table></th>
				</tr>
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
						$issued = '<a href="#" onclick="window.open(\'../otherIssuedStockWindow.php?hwid='.$odb->RowData['hwid'].'&makeid='.$odb->RowData['makeid'].'&modelid='.$odb->RowData['modelid'].'\',\'\',\'width=800,height=800\')">'.$odb->RowData['Issued'].'</a>';
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

</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
