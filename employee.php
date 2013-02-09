<?php
include 'includes/Application.php';
include 'includes/_incHeader.php';
$db = new cDB();
?>
<div class="content">
<table border="0" width="70%" cellspacing="5" cellpadding="0">
<form name="empform" action="#" method="post" >
<tr>
    <td><label for="username">Employee ID </label></td><td> <input type="text" name="txtempid" id="txtempid" value="" size="30" /></td><td></td>
</tr>

<tr>
    <td><label for="password">Employee Name </label></td><td> <input type="text" name="txtempname" id="txtempname" value="" size="30" /></td><td></td>
</tr>

<tr>
    <td><label for="username">Unit </label></td>
	<td> 
    <?php 
	$db->Query("SELECT * FROM units");
	?>
	<select name="txtunit" id="txtunit" style="width:67%" >
    <option value='-1'>----Select Unit----</option>
    <?php 
    if ($db->RowCount) { 
        while ($db->ReadRow()) {
	        echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
        } 
    }
    ?>
    <option value='0'>Other</option>
	</select>
	</td>
    <td><div id="unittext"></div></td>
</tr>

<tr>
    <td><label for="username">Department </label></td>
	<td> 
    <?php 
    $db->Query("SELECT * FROM departments");
	?>
    <select name="txtdepartment" id="txtdepartment" style="width:67%">
    <option value='-1' >----Select Department----</option>
    <?php 
    if ($db->RowCount) { 
        while ($db->ReadRow()) {
	        echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
        } 
    }
    ?>
    <option value='0'>Other</option>
    </select>
    </td>
    <td><div id="departmenttext"></div></td>
</tr>

<tr>
    <td><label for="designation">Designation </label></td><td> <input type="text" name="txtdesignation" id="txtdesignation" value="" size="30" /></td><td></td>
</tr>

<tr>
    <td colspan="2"> <input type="button" name="txtsubmit" id="txtsubmit" value="submit" /> 
	<input type="reset" name="txtreset" value="reset" /></td>
    <!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->
</tr>

</form>
</table>
</div>
<?php
include 'includes/_incFooter.php';
?>
