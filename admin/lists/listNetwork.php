<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
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
		"sAjaxSource": "../ajax/ajax_network.php",
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
});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<!-- Content start -->
<div id="container-2" class="box1">

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

</div>
<div class="layout-2">
      <div id="footer">  
        <span class="f-right">Developed By: <a href="#" style="font-size:16px;padding:0 100px 0 0">Avanik jain@9460195941</a> | &copy; 2012 <a href="/">Hindustan Zinc Ltd.</a></span>
      </div>
</div>
  </body>
</html>
