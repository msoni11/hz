<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}

$db4 = new cDB();
$db4->Query("
	SELECT hd.name department, hh.name hardware, hm.name make, hmo.modelname model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
			FROM `hz_otherstock` hs
			LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
			LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
			LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
			LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
");

?>
<script type="text/javascript">
$(document).ready( function () {
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
});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
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
					echo '<td><a href="../editOtherStock.php?id='.base64_encode($db4->RowData['id']).'" title="click to edit""><img src="../images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deleteotehrstock" style="cursor:pointer"><input type="hidden" class="delotherstockid" value="'.$db4->RowData['id'].'" ><img src="../images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span></td>';
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
