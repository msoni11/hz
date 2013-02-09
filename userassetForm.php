<?php
$hardware_array = explode(',', $hardware);
$make_array = explode(',', $make);
$monitor_array = explode(',', $monitor);
$unitcode = 'HZL/CZ/';
$assetcode = explode(',', $assetcode);
$msoffice_array = explode(',', $msoffice);
$amcwar_array = explode(',', $amcwar);
?>

<!-- Navbar start -->
<?php include 'includes/_incNavigation.php'; ?>
<!-- Navbar end   -->
<script>
$("document").ready(function(){
    
    $("#seeAllotedAsset").click(function(){
		var empid = $('#txtregempid').val();
		if (empid == '') {
			alert('Enter Employee username first');
		} else {
			$("#loader").hide();
			$.ajax({
				url:"getrequest.php",
				type:"post",
				data:'functype=getassetdetails&reggetempid='+empid,
				success: function(result) {
					try {
						obj = $.parseJSON(result);
						var table = '';
						table += '<table cellspacing="10" cellpadding="10">';
						table += '<tr><th>Hardware</th><th>CPU/P/S Serial</th></tr>';
						$.each(obj, function(key,val){
							table += '<tr><td>'+val['name']+'</td><td>'+val['serial']+'</td></tr>';
						});
						table += '</table>';
						$("#space_for_table").empty().append(table);
					} catch(e) {
						$("#space_for_table").empty().append('No Asset Issued!!');
					}
				}
			});
		window.scroll(0,0);    
		$("body").css("overflow","hidden");
		$("#black_bg").fadeIn(600);
		$("#form-container").fadeIn("fast");
		}
	});
	
	$("#txtmodel").change(function(){
        var hardware= $("#txthardware").val();
        var make = $("#txtmake").val();
        var model = $("#txtmodel").val();
        $.ajax({
            url:"getrequest.php",
            type:"post",
           data:"functype=getserials&hardware="+hardware+"&make="+make+"&model="+model,
           success: function(result)
           {
            	var arr = $.parseJSON(result);
                $("#txtcpuno").empty().append('<option value="-1" >----Select Serial Number----</option>');
                $.each(arr,function(key,val){
                    $("#txtcpuno").append('<option value="'+key+'" >'+ val +'</option>');
                });
           }
           
        });
        
         $.ajax({
            url:"getrequest.php",
            type:"post",
           data:"functype=getmserials&hardware="+hardware+"&make="+make+"&model="+model,
           success: function(result)
           {
            	var arr = $.parseJSON(result);
                $("#txtcrtno").empty().append('<option value="-1" >----Select Serial Number----</option>');
                $.each(arr,function(key,val){
                    $("#txtcrtno").append('<option value="'+key+'" >'+ val +'</option>');
                });
           }
           
        });
    });
    
    $("#txtcpuno").change(function(){
        var cpu_serial = this.value;
        
        
        $.ajax({
            url:"getrequest.php",
            type:"post",
           data:"functype=getcpuconfig&serial_id="+cpu_serial,
           success: function(result)
           {
            	var arr = $.parseJSON(result);
                $("#txtconfig").empty();
                $.each(arr,function(key,val){
                    $("#txtconfig").append('<option value="'+key+'" >'+ val +'</option>');
                });
           }
           
        });
    });
    
});
</script>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="regform" action="#" method="post" onSubmit="return false;">				<fieldset><legend>Registration</legend>
				
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

				<div class="text-box-name">Emp Username:</div>
				<div class="text-box-field">
					<input type="text" name="txtregempid" id="txtregempid" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field" ><button id='seeAllotedAsset' style='margin-left:110px;padding:3px;'>See Alloted Asset</button></div>

				<div id="hideEmpDetails" style="display:none">

				<div class="text-box-name">Employee Id:</div>
				<div class="text-box-field">
					<input type="text" name="txtregempiddesc" id="txtregempiddesc" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field" ></div>

				<div class="text-box-name">Employee Name:</div>
				<div class="text-box-field">
					<input type="text" name="txtempname" id="txtempname" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<?php 
				//$db->Query("SELECT * FROM hz_departments");
				?>
				<div class="text-box-name">Department:</div>
				<div class="text-box-field">
					<input type="text" name="txtdepartment" id="txtdepartment" value="" class="form-text" size="30" maxlength="2048" />				
					<!--<select name="txtdepartment" id = "txtdepartment"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Department----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
					</select>-->
				</div>
				<div class="text-box-field"><div id = "departmenttext"></div></div>

				<div class="text-box-name">Designation:</div>
				<div class="text-box-field">
					<input type="text" name="txtdesignation" id="txtdesignation" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Unit:</div>
				<?php 
				$db->Query("SELECT * FROM hz_units");
				?>
				<div class="text-box-field">
					<select name="txtunit" id = "txtunit"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Unit----</option>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.mysql_real_escape_string($db->RowData['name']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<option value='0'>Other</option>
						<option value='NONE'>None</option>
					</select>
				</div>
				<div class="text-box-field"><div id="unittext"></div></div>
				</div>

				<div class="text-box-name">Hardware:</div>
				<?php 
				$db->Query("SELECT * FROM hz_hardware WHERE name IN ('".str_replace(',','\',\'',$hardware)."')");
				?>
				<div class="text-box-field">
					<select name="txthardware" id = "txthardware"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Hardware----</option>
						<?php 
						/*foreach ( $hardware_array as $harray ) { 
							echo  '<option value="'.strtoupper($harray).'">'.strtoupper($harray).'</option>';
						}*/
						?>
						<?php 
						if ($db->RowCount) { 
							while ($db->ReadRow()) {
								echo '<option value="'.($db->RowData['id']).'">'.$db->RowData['name'].'</option>';
							} 
						}
						?>
						<!--<option value='0'>Other</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="hardwaretext"></div></div>
				
				<div id="printertype" style="display:none;">
					<div class="text-box-name">Type:</div>
					<div class="text-box-field">
						<select name="txtprintertype" id = "txtprintertype"  class="form-text" style="width:91%" >
						</select>
					</div>
					<div class="text-box-field"><div id="printertypetext"></div></div>
				</div>

				<div class="text-box-name">Make:</div>
				<div class="text-box-field">
					<select name="txtmake" id = "txtmake"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Make----</option>
						<!--<option value='0'>Other</option>-->
						<!--<option value='NONE'>NONE</option>-->
					</select>
				</div>
				<div class="text-box-field"><div id="maketext"></div></div>

				<div class="text-box-name">Model:</div>
				<div class="text-box-field">
					<select name="txtmodel" id = "txtmodel"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Model----</option>
						<!--<option value='0'>Other</option>-->
						<!--<option value='NONE'>NONE</option>-->
					</select>
					<!--<input type="text" name="txtmodel" id="txtmodel" value="" class="form-text" size="30" maxlength="2048" />-->
				</div>
				<div class="text-box-field"><div id="modeltext"></div></div>
				
				<div class="text-box-name">CPU/P/S Sr. No.:</div>
				<div class="text-box-field">
                    <select name="txtcpuno" id="txtcpuno"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Serial Number----</option>
						<!--<option value='0'>Other</option>-->
						<!--<option value='NONE'>NONE</option>-->
					</select>
					<!--<input type="text" name="txtcpuno" id="txtcpuno" value="" class="form-text" size="30" maxlength="2048" />-->				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Monitor:</div>
				<div class="text-box-field">
					<select name="txtmonitor1" id = "txtmonitor1"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Monitor----</option>
						<?php
						foreach ( $monitor_array as $monitorarray ) { 
							echo  '<option value="'.strtoupper($monitorarray).'">'.strtoupper($monitorarray).'</option>';
						}
						?>
						<option value="NONE">NONE</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">CRT/TFT Sr. No.:</div>
				<div class="text-box-field">
					<select name="txtcrtno" id="txtcrtno" class="form-text"  style="width:91%"></select>				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Configuration:</div>
				<div class="text-box-field">
					<select name="txtconfig" id = "txtconfig"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Configuration----</option>
						<option value='0'>Other</option>
						<option value='NONE'>NONE</option>
					</select>
					<!--<input type="text" name="txtconfig" id="txtconfig" value="" class="form-text" size="30" maxlength="2048" />-->
				</div>
				<div class="text-box-field"><div id="configtext"></div></div>

				<div id="cartage" style="display:none;">
					<div class="text-box-name">Cartage No.:</div>
					<div class="text-box-field">
						<select name="txtcartage" id = "txtcartage"  class="form-text" style="width:91%" >
						</select>
					</div>
					<div class="text-box-field"><div id="cartagetext"></div></div>
				</div>

				<div class="text-box-name">Asset Code:</div>
				<div class="text-box-field">
					<select name="txtasset" id = "txtasset"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Asset Code----</option>
						<?php 
						foreach ($assetcode as $ac){
							echo '<option value="'.$unitcode.$ac.'">'.$unitcode.$ac.'/</option>';
						}
						?>
						<option value='other'>Other</option>
						<option value="NONE">NONE</option>
					</select>
				</div>
				<div class="text-box-field"><div id="assettext"></div></div>

				<div class="text-box-name">IP Address:</div>
				<div class="text-box-field">
					<input type="text" name="ipaddress" id="ipaddress" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">MS Office:</div>
				<div class="text-box-field">
					<select name="txtoffice" id = "txtoffice"  class="form-text" style="width:91%" >
						<option value="-1">---Select---</option>
						<?php
						foreach ($msoffice_array as $mso){
							echo '<option value="'.$mso.'">'.$mso.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Any License Soft:</div>
				<div class="text-box-field">
					<input type="text" name="txtlicense" id="txtlicense" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Internet:</div>
				<div class="text-box-field">
					<select name="txtinternet" id = "txtinternet"  class="form-text" style="width:91%" >
						<option value="YES">YES</option>
						<option value="NO">NO</option>
						<option value='NONE'>NONE</option>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">AMC/WAR:</div>
				<div class="text-box-field">
					<select name="txtamc" id = "txtamc"  class="form-text" style="width:91%" >
						<option value="-1">---SELECT---</option>
						<?php
						foreach ($amcwar_array as $aw){
							echo '<option value="'.$aw.'">'.$aw.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
		
				<div id="warrdate" style="display:none;">
				<div class="text-box-name">Warranty date:</div>
				<div class="text-box-field">
					<select name="txtwarnday" id = "txtwarnday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtwarnmonth" id = "txtwarnmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtwarnyear" id = "txtwarnyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>
				</div>

				<div id="vendor" style="display:none;">
				<div class="text-box-name">vendor:</div>
				<div class="text-box-field">
					<input type="text" name="txtvendor" id="txtvendor" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>
				</div>

				<div class="text-box-name">Issue Date:</div>
				<div class="text-box-field">
					<select name="txtday" id = "txtday"  class="form-text" style="width:24%" >
						<option value="-1">DAY</option>
						<?php 
						for($i = 1; $i<=31; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
					<select name="txtmonth" id = "txtmonth"  class="form-text" style="width:34%" >
						<option value="-1">MONTH</option>
						<?php 
						for($i = 1; $i<=12; $i++) { 
							echo '<option value="'.$i.'">'.str_pad($i,2,"0",STR_PAD_LEFT).'</option>';
						}
						?>
					</select>
					<select name="txtyear" id = "txtyear"  class="form-text" style="width:30%" >
						<option value="-1">YEAR</option>
						<?php 
						for($i = 2006; $i<=2020; $i++) { 
							echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
					</select>
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Other IT Asset:</div>
				<div class="text-box-field">
					<input type="text" name="txtotheritasset" id="txtotheritasset" value="" class="form-text" size="30" maxlength="2048" />				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Status:</div>
				<div class="textarea-box-field">
					<textarea name="txtregstatus" id="txtregstatus" value="" class="form-text" size="30" maxlength="2048" rows="5" /></textarea>				
				</div>
				<div class="textarea-box-field" ></div>
				
				<input type="button" name="newregbtn" id="newregbtn" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtregreset" id="txtregreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->
                <div id="form-container">
                <div id="space_for_table"></div>
                <div style="clear:both;text-align:center;">
                <input id="cancel" type="button" name="cancel" value="Okay" style="width:80px; height:30px;" onclick="hide_popup();"/></div>

			</form>
		</div>
	</div>
</div>
<!-- Content End -->