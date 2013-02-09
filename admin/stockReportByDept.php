<?php 
include '../includes/Application.php';
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
	printertype TYPE, hm.name make, hmo.modelname model, COUNT( * ) issued
	FROM `hz_registration` hs
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id )
	WHERE hardware !=3
	GROUP BY hardware, make, model
	)
	UNION (

	SELECT hh.name hardware, ht.printertype
	TYPE , hm.name make, hpmo.printermodel model, count( * ) issued
	FROM `hz_registration` hs
	LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
	LEFT OUTER JOIN hz_printertype ht ON ( hs.printertype = ht.id )
	LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
	LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id )
	WHERE hardware =3
	GROUP BY hardware, make, model
	)
	)b ON a.hardware = b.hardware AND a.make = b.make AND a.model = b.model
	GROUP BY a.hardware, a.make, a.model
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
	c.id id  

	FROM ((SELECT hd.name department, hh.name hardware, type , hm.name make, hmo.modelname model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
				FROM `hz_stock` hs
				LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
				LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
				LEFT OUTER JOIN hz_model hmo ON ( hs.model = hmo.id ) where hardware != 3)
			UNION
			(SELECT hd.name department, hh.name hardware, hpt.printertype type , hm.name make, hpmo.printermodel model, hs.invoiceno invoiceno, hs.orderdate orderdate, hs.partyname partyname, hs.receivername receivername, hs.quantity quantity, hs.rate rate, hs.otherstatus otherstatus, hs.id id
				FROM `hz_stock` hs
				LEFT OUTER JOIN hz_departments hd ON ( hs.department = hd.id )
				LEFT OUTER JOIN hz_hardware hh ON ( hs.hardware = hh.id )
				LEFT OUTER JOIN hz_printertype hpt ON ( hs.type = hpt.id )
				LEFT OUTER JOIN hz_make hm ON ( hs.make = hm.id )
				LEFT OUTER JOIN hz_printermodel hpmo ON ( hs.model = hpmo.id ) where hardware = 3))c
	");
}
?>
<!DOCTYPE html PUBLIC '//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta name="description" />
<meta name="keywords" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link href="../styles/screen.css" rel="stylesheet" type="text/css" />
<link href="../styles/login-box.css" rel="stylesheet" type="text/css" />
<link href="../styles/TableTools.css" rel="stylesheet" type="text/css" />
<!--<link href="styles/style.css" rel="stylesheet" type="text/css" />-->
<!--<link href="styles/demo_page.css" rel="stylesheet" type="text/css" />-->
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css" />
<script type=text/javascript src='../js/jquery-1.7.2.min.js'></script>
<script type=text/javascript src='../js/jquery.dataTables.js'></script>
<script type=text/javascript src='../js/ZeroClipboard.js'></script>
<script type=text/javascript src='../js/TableTools.js'></script>
<script type=text/javascript src='../js/validate.js'></script>
<script type=text/javascript src='../js/editvalidate.js'></script>
<!--<script type=text/javascript src='../js/common.js'></script>-->
<script type=text/javascript src='../js/filterresult.js'></script>
<script type=text/javascript src='../js/authenticate.js'></script>
<title>Hindustan Zinc Limited</title>
<script type="text/javascript">
$(document).ready( function () {
	$("#stock").click(function(){
		window.location = 'stockreport.php?type=stock';
	});
	$("#availstock").click(function(){
		window.location = 'stockreport.php?type=availstock';
	});
	$("#otherstock").click(function(){
		window.location = 'stockreport.php?type=otherstock';
	});

	<?php if (isset($_GET['type']) && $_GET['type'] == 'stock') { ?>
	$("#stocklist").show();
	var oTable = $('#ListStock').dataTable( {
		"sDom": 'T<"clear">lfrtip',
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
		"bProcessing": false,
		"bServerSide":false,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"sPaginationType": "full_numbers",
	} );
	<?php } ?>
	<?php if (isset($_GET['type']) && $_GET['type'] == 'availstock') { ?>
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
});

</script>
</head>
<body>
<!-- Header start -->
<div class="layout-2">
      
      <div id="header">
        
        <h1 id="logo">
		<a href="./" title="Company"><img src="images/logo.gif" height = "130" width = "130" class="imgset" />Hindustan Zinc Limited <span></span></a>
		<br ><div class="textsmall" style="position:absolute; top :20px; left:134px; font-size:0.6em">Smelter, Chanderiya</div>
        </h1>
		<hr class="noscreen" />
		<!-- Show only if user is login-->
		<?php if (isset($_SESSION['username'])) { ?>
			<!-- Navbar start -->
			<div id="nav" class="box1">
				<ul>
					<li><a href="admin_home.php">HOME</a></li>
					<?php if(isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == '1') { ?>
					<li><a href="addUser.php">LOGIN USER</a></li>
					<?php } ?>
					<li><a href="addEmployee.php">EMPLOYEE</a></li>
					<li><a href="userasset.php">IT ASSET</a></li>
					<li><a href="addNetwork.php">NETWORK</a></li>
					<li><a href="listEmployees.php">EMPLOYEE LIST</a></li>
					<li><a href="crystReport.php">REPORT</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
				</ul>
				<hr class="noscreen" />
			</div>
			<!-- Navbar end   -->
		<?php } else { ?>
		<table border="0" width="98%">
			<tr>
				<td width="60"><div id="welcome">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome </div></td>
				<td width="30%"><div class="time"><?php print date('D, d M Y H:i:s'); ?></div></td>
			</tr>
		</table>
		<?php } ?>
      </div>
</div>  
      <hr class="noscreen" />

<!-- Header End -->

<?php
/*if (!isset($_SESSION['username'])) {
header("Location:logout.php");
}*/
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>

<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">
	<div style = "padding:10px 0 30px 400px">
		<div class="text-box-name"><input type="button" id="stock" value="Stock" style="width:120px;height:40px;cursor:pointer;"></div>
		<div class="text-box-name"><input type="button" id="otherstock" value="Other Stock" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="availstock" value="Available Stock" style="width:120px;height:40px;cursor:pointer;" ></div>

	</div>
	<div id="availstocklist" style="padding:50px 0 0 0;display:none;">
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
				$db3->Query("SELECT * FROM hz_hardware");
				if ($db3->RowCount) { 
					while ($db3->ReadRow()) {
						echo '<option value="'.($db3->RowData['name']).'">'.$db3->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</th>
			<th>
				<select name="txtaddprintertype" id = "txtaddprintertype" >
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
					<th >Edit</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if ($db1->RowCount){
				while ($db1->ReadRow()) {
					$date = getdate($db4->RowData['orderdate']);
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
					echo '<td><a href="editStock.php?id='.base64_encode($db4->RowData['id']).'" title="click to edit""><img src="images/edit-icon.png" style="border:none; display:inline" /></a>&nbsp;<span class="deletestock" style="cursor:pointer"><input type="hidden" class="delstockid" value="'.$db4->RowData['id'].'" ><img src="images/delete-icon.png" alt="Click to delete" title="Click to delete" /><img src="images/ajax-loader.gif" class="loader" style="display:none" /></span></td>';
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
