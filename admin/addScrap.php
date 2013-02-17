<?php
include 'includes/_incHeader.php';
$hardware_array = explode(',', $hardware);
$make_array = explode(',', $make);
$monitor_array = explode(',', $monitor);
$unitcode = 'HZL/CZ/';
$assetcode = explode(',', $assetcode);
$msoffice_array = explode(',', $msoffice);
$amcwar_array = explode(',', $amcwar);
?>
<!--- test commit -->
<!-- Navbar start -->
<?php include '../includes/_incNavigation.php'; ?>
<!-- Navbar end   -->
<script>
$("document").ready(function(){
    $("#txthardware").change(function(){
		$this = $(this).val();
		if ($this == 1) {
			$('#desktoptype').show();
		} else {
			$('#desktoptype').hide();
		}
    });
        
    
	
	$("#txtmodel").change(function(){
        var hardware= $("#txthardware").val();
        var make = $("#txtmake").val();
        var model = $("#txtmodel").val();
        var dtpType = $("#txtdesktoptype").val();
		var vardata = '';
        if (hardware == 1) {
 			if (dtpType == 'tft') {
				vardata = "functype=getMSerialsToScrap&hardware="+hardware+"&make="+make+"&model="+model;
 	 		} else {
				vardata = "functype=getSerialsToScrap&hardware="+hardware+"&make="+make+"&model="+model;
 	 		} 
        } else {
			vardata = "functype=getserials&hardware="+hardware+"&make="+make+"&model="+model;
        }
        console.log(vardata);
        $.ajax({
            url:"getrequest.php",
            type:"post",
           data: vardata,
           success: function(result)
           {
            	var arr = $.parseJSON(result);
                $("#txtcpuno").empty().append('<option value="-1" >----Select Serial Number----</option>');
                $.each(arr,function(key,val){
                    $("#txtcpuno").append('<option value="'+key+'" >'+ val +'</option>');
                });
           }
           
        });
        
         /*$.ajax({
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
           
        });*/
    });

    $("#txtdesktoptype").change(function(){
		$("#txtmake").val(-1);
		$("#txtmodel").val(-1);
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
        
        $.ajax({
            url:"getrequest.php",
            type:"post",
           data:"functype=getassetcode&serial_id="+cpu_serial,
           success: function(result)
           {
                $("#txtasset").empty().val(result);
              
           }
          
           
        });
    });
    
});
</script>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="regform" action="#" method="post" onSubmit="return false;">				
            <fieldset><legend>Scrap Hardware</legend>
				
				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>

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
				
				<div id="desktoptype" style="display:none;">
					<div class="text-box-name">Type:</div>
					<div class="text-box-field">
						<select name="txtdesktoptype" id = "txtdesktoptype"  class="form-text" style="width:91%" >
							<option value='cpu'>CPU</option>
							<option value='tft'>TFT</option>
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
				
				<div class="text-box-name">Sr. No.:</div>
				<div class="text-box-field">
                    <select name="txtcpuno" id="txtcpuno"  class="form-text" style="width:91%" >
						<option value='-1'>----Select Serial Number----</option>
						<!--<option value='0'>Other</option>-->
						<!--<option value='NONE'>NONE</option>-->
					</select>
					<!--<input type="text" name="txtcpuno" id="txtcpuno" value="" class="form-text" size="30" maxlength="2048" />-->				
				</div>
				<div class="text-box-field"></div>

				<div class="text-box-name">Reason:</div>
				<div class="textarea-box-field" >
					<textarea name="txtreason" id="txtreason"  class="form-text" rows="4" ></textarea> 				
				</div>
				<div class="text-box-field"></div>

                <div class="text-box-name" style="clear: left;">Approved:</div>
                <div class="text-box-field">
					<input type="text" name="txtapproved" id="txtapproved" value="" class="form-text" size="30" maxlength="2048"  />				
				</div>
				<div class="text-box-field"></div>
				

				<div style="clear: both;">
				<input type="button" name="newscrap" id="newscrap" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtregreset" id="txtregreset" value="Reset" style="width:80px; height:30px;" />
				</div>
                </fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->
                
                
                

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
<?php
include 'includes/_incFooter.php';
?>