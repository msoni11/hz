<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
	$('#criticallist').show();
	$('#ListCritical').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"aButtons": [
				{
					"sExtends": "copy",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				},
				{
					"sExtends": "csv",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				},
				{
					"sExtends": "xls",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				},
				{
					"sExtends": "pdf",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				},
				{
					"sExtends": "print",
					"mColumns": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]
				}
			]
		},									
		"bProcessing": false,
		"bServerSide":true,
		"iDisplayStart":0,
		"iDisplayLength":10,
		"sPaginationType": "full_numbers",
		"sAjaxSource": "../ajax/ajax_critical.php",
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
});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">

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
</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
