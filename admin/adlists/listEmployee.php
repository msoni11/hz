<?php
include '../includes/_incHeader3.php';

if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 1) {
	header("Location:../logout.php");
}
?>
<script type="text/javascript">
$(document).ready( function () {
	$('#emplist').show();
	oTable=$('#ListEmployees').dataTable( {
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
		"iDisplayStart":0,
		"iDisplayLength":10,
		"sPaginationType": "full_numbers",
//		"sAjaxSource": "../ajax/ajax_emp.php",
		"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"oLanguage": {
		"sSearch": "Enter ID/NAME to restrict result for:",
		"sInfoEmpty": "No Records Found",
		},
	} );

});
</script>
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->

<?php
	$userinfo = array();
	$options = getLdapOU($_SESSION['ldapid']);
	for ($i=0;$i<count($options);$i++) {
        $adldap = initializeLDAP($options[$i]);
        $users = $adldap->user()->all();
        foreach ($users as $key=>$user) {
        	$userinfo[] = $adldap->user()->info($user, array('mail','description','name','department','title','manager'));
       		for ($j=0;$j<count($options);$j++) {
        		$adldapmgr = initializeLDAP($options[$j]);
       			$managerinfo[] = $adldapmgr->contact()->info($userinfo[0][0]['manager'][0],array('name','mail')); 
	        	if (!empty($managerinfo)) {
	        		break;
	        	}
       		}
        	$username[] = $user;
        	$empinfo[] = array_merge($userinfo, $managerinfo, $username);
        	unset($userinfo);
        	unset($managerinfo);
          	unset($username);
        }
	}
	
?>

<!-- Content start -->
<div id="container-2" class="box1">
	<div id="emplist" style="padding:50px 0 0 0;display:none;">
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListEmployees">
				<thead>
					<tr>
						<th >Emp Username</th>
						<th >Employee ID</th>
						<th >Employee Name</th>
						<th >Department</th>
						<th >Designation</th>
						<th >Email</th>
						<th >Manager</th>
						<th >Manager email</th>
					</tr>
				</thead>

				<tbody>
				<?php 
				foreach ($empinfo as $empinf) {
					echo "<tr>";
						echo "<td >".$empinf[2]."</td>";
						echo "<td >".$empinf[0][0]['description'][0]."</td>";
						echo "<td >".$empinf[0][0]['name'][0]."</td>";
						echo "<td >".$empinf[0][0]['department'][0]."</td>";
						echo "<td >".$empinf[0][0]['title'][0]."</td>";
						echo "<td >".$empinf[0][0]['mail'][0]."</td>";
						echo "<td >".$empinf[1][0]['name'][0]."</td>";
						echo "<td >".$empinf[1][0]['mail'][0]."</td>";
					echo "</tr>";
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
