<?php
include 'includes/_incHeader1.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
	$("#Employee").click(function(){
		window.location = 'listEmployees.php?type=emp';
	});
	$("#Registration").click(function(){
		window.location = 'listEmployees.php?type=reg';
	});
	$("#Network").click(function(){
		window.location = 'listEmployees.php?type=ntwrk';
	});
	$("#critical").click(function(){
		window.location = 'listEmployees.php?type=critical';
	});
	$("#otherRegistration").click(function(){
		window.location = 'listEmployees.php?type=otherRegistration';
	});
	<?php if (isset($_GET['type']) && $_GET['type'] == 'emp') { ?>
	$('#emplist').show();
		$('#ListEmployees').dataTable( {
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
			"bServerSide":true,
			"iDisplayStart":0,
			"iDisplayLength":10,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "ajax_emp.php",
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"oLanguage": {
			"sSearch": "Enter ID/NAME to restrict result for:",
			"sInfoEmpty": "No Records Found",
			},
			"aoColumns": [ 
				 null,
				 null,
				 null,
				 null,
				 null, 
				 { "bSortable": false }
			],
		} );
	<?php } else if (isset($_GET['type']) && $_GET['type'] == 'reg') { ?>
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
			"bServerSide":true,
			"iDisplayStart":0,
			"iDisplayLength":10,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "ajax_reg.php",
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
				 { "bSortable": false }
			], 
		} );
	<?php } else if (isset($_GET['type']) && $_GET['type'] == 'ntwrk') { ?>
		$('#networklist').show();
		$('#ListNetwork').dataTable( {
			"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
				"aButtons": [
					{
						"sExtends": "copy",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "csv",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "xls",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "print",
						"mColumns": [0,1,2,3,4,5,6,7]
					}
				]
			},									
			"bProcessing": false,
			"bServerSide":true,
			"iDisplayStart":0,
			"iDisplayLength":10,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "ajax_network.php",
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"aoColumns": [ 
				 { "bSortable": false },
				 null,
				 null,
				 null,
				 null,
				 null,
				 null,
				 null, 
				 null, 
				 { "bSortable": false },
				 { "bSortable": false }
			], 
		} );
	<?php } else if (isset($_GET['type']) && $_GET['type'] == 'critical') { ?>
		$('#criticallist').show();
		$('#ListCritical').dataTable( {
			"sDom": 'T<"clear">lfrtip',
			"oTableTools": {
				"aButtons": [
					{
						"sExtends": "copy",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "csv",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "xls",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "pdf",
						"mColumns": [0,1,2,3,4,5,6,7]
					},
					{
						"sExtends": "print",
						"mColumns": [0,1,2,3,4,5,6,7]
					}
				]
			},									
			"bProcessing": false,
			"bServerSide":true,
			"iDisplayStart":0,
			"iDisplayLength":10,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "ajax_critical.php",
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
				 null,
				 null,
				 null,
				 null, 
				 null, 
				 { "bSortable": false }
			], 
		} );
	<?php } else if (isset($_GET['type']) && $_GET['type'] == 'otherRegistration') { ?>
	$('#otherreglist').show();
		$('#ListOtherRegistration').dataTable( {
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
			"bServerSide":true,
			"iDisplayStart":0,
			"iDisplayLength":10,
			"sPaginationType": "full_numbers",
			"sAjaxSource": "ajax_otherreg.php",
			"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"oLanguage": {
			"sSearch": "Enter ID/NAME to restrict result for:",
			"sInfoEmpty": "No Records Found",
			},
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
				 { "bSortable": false }
			],
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
		<div class="text-box-name"><input type="button" id="Employee" value="Employee" style="width:120px;height:40px;cursor:pointer;"></div>
		<div class="text-box-name"><input type="button" id="Registration" value="IT ASSET" style="width:120px;height:40px;cursor:pointer;" ></div>
		<div class="text-box-name"><input type="button" id="Network" value="Network" style="width:120px;height:40px;cursor:pointer;"></div>
		<div class="text-box-name"><input type="button" id="critical" value="Critical Asset" style="width:120px;height:40px;cursor:pointer;"></div>
		<div class="text-box-name"><input type="button" id="otherRegistration" value="Other Asset" style="width:120px;height:40px;cursor:pointer;"></div>
	</div>

	<div id="emplist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListEmployees">
				<thead>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
						<th >Edit</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

	<div id="reglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListReg">
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
						<th >Edit</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

	<div id="networklist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListNetwork">
				<thead>
					<tr>
						<th >Serial</th>
						<th >Department</th>
						<th >Item</th>
						<th >Make</th>
						<th >Model</th>
						<th >Serial</th>
						<th >Quantity</th>
						<th >Type</th>
						<th >AMC/WAR</th>
						<th >Warn/Vendor</th>
						<th >Edit</th>
					</tr>
				</thead>

				<tbody>
				</tbody>

			</table>
	</div>

	<div id="stocklist" style="padding:50px 0 0 0;display:none;">
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
				$db = new cDB();
				$db->Query("SELECT * FROM hz_departments");
				if ($db->RowCount) { 
					while ($db->ReadRow()) {
						echo '<option value="'.mysql_real_escape_string($db->RowData['id']).'" >'.$db->RowData['name'].'</option>';
					} 
				}
				?>
				</select>
			</th>
			<th>
				<select name="txtaddhardware" id = "txtaddhardware"  >
				<option value=''>----Select Hardware----</option>
				<?php 
				$db->Query("SELECT * FROM hz_hardware");
				if ($db->RowCount) { 
					while ($db->ReadRow()) {
						echo '<option value="'.($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
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
			</tbody>

		</table>
	</div>

	<div id="criticallist" style="padding:50px 0 0 0;display:none;">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListCritical">
			<thead>
				<tr>
					<th >Department</th>
					<th >Hardware</th>
					<th >Name</th>
					<th >Asset Code</th>
					<th >Location</th>
					<th >Asset Owner</th>
					<th >Make</th>
					<th >Model</th>
					<th >Serial</th>
					<th >IP/Subnet</th>
					<th >Processor</th>
					<th >Ram</th>
					<th >HDD</th>
					<th >CD-ROM</th>
					<th >N/w make</th>
					<th >Speed</th>
					<th >Gateway</th>
					<th >Peri make</th>
					<th >Peri model</th>
					<th >Peri serial</th>
					<th >OS</th>
					<th >Application</th>
					<th >s/w serial</th>
					<th >Other config</th>
					<th >Issue date</th>
					<th >Edit</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<div id="otherreglist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListOtherRegistration">
				<thead>
					<tr>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Unit</th>
						<th >Department</th>
						<th >Designation</th>
						<th >Hardware</th>
						<th >Make</th>
						<th >Model</th>
						<th >Receiver Name</th>
						<th >Issue Date</th>
						<th >Issued By</th>
						<th >Other Status</th>
						<th >Edit</th>
					</tr>
				</thead>

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
