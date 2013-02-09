<?php
include '../includes/_incHeader2.php';
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}

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

?>
<script type="text/javascript">
$(document).ready( function () {
	$("#stocklist").show();
	var oTable = $('#ListStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"bProcessing": false,
		"bServerSide":false,
		"bFilter":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );

	var AoH = $('#ListStock thead tr:gt(1)').map(function(){
    return [
        $('th',this).map(function(){
            return $(this).text();
        }).get()
    ];
	}).get();
	var jsonH = JSON.stringify(AoH);
	$("#tableheaddata").val(jsonH);

	var AoA = $('#ListStock tr:gt(2)').map(function(){
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
	<div id="stocklist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListStock">
			<thead>
				<tr>
					<th colspan ="13" align="center"><table align="center"><tr><td><img src="../images/logo.gif" height = "130" width = "130" class="imgset" /></td><td><h2>Hindustan Zinc Limited</h2><br />smelter, chanderia</td></tr></table></th>
				</tr>
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
