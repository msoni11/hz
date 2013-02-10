<?php
require_once('includes/_incHeader.php');
$db = new cDB();
if (!isset($_SESSION['username']) || $_SESSION['isadmin'] != 2) {
	header("Location:logout.php");
}

?>

<script>
$("document").ready(function(){
    
    $("#cfg_settings").live("click",function(){
        save_settings();
    }) ;
});

function save_settings()
{
    
        var cfg_host    = encodeURIComponent($("#cfg_host").val());
        var cfg_ver      = encodeURIComponent($("#cfg_ver").val());
        var encoding   = encodeURIComponent($("#cfg_encoding").val());
        var suffix          = encodeURIComponent($("#cfg_suffix").val());
        var dn       = encodeURIComponent($("#cfg_dn").val());
        var username          = encodeURIComponent($("#cfg_username").val());
        var password       = encodeURIComponent($("#cfg_password").val());
        var usertype      = encodeURIComponent($("#cfg_usertype").val());
        var contexts         = encodeURIComponent($("#cfg_contexts").val());
        var location  =  encodeURIComponent($("#cfg_location").val());
        if (cfg_host == '') {
			$("#loader").hide();
            alert('Enter Host URL');
            $("#cfg_host").focus();
			return;
        } else if (cfg_ver == '-1') {
			$("#loader").hide();
            alert('Select Version');
            $("#cfg_ver").focus();
			return;
        } else if (encoding == '') {
			$("#loader").hide();
            alert('Enter Encoding');
            $("#cfg_encoding").focus();
			return;
        } else if (suffix == '') {
			$("#loader").hide();
            alert('Enter Account Suffix');
            $("#cfg_suffix").focus();
			return;
        } else if (dn == '') {
			$("#loader").hide();
            alert('Enter Base DN');
            $("#cfg_dn").focus();
			return;
        } else if (username == '') {
			$("#loader").hide();
            alert('Enter Username');
            $("#cfg_username").focus();
			return;
        } else if (password == '') {
			$("#loader").hide();
            alert('Enter Password');
            $("#cfg_password").focus();
			return;
        }/* else if (usertype == '-1') {
			$("#loader").hide();
            alert('Select User Type');
            $("#cfg_usertype").focus();
			return;
        }*/ else if (contexts == '') {
			$("#loader").hide();
            alert('Enter Contexts');
            $("#cfg_contexts").focus();
            return;
        } else if (location == '') {
			$("#loader").hide();
            alert('Enter location');
            $("#cfg_location").focus();
			return;
		}
        
        myData = "functype=newLdapEntry&hosturl=" + cfg_host + "&version=" +cfg_ver + "&ldapencoding=" + encoding + 
				  "&accountsuffix=" + suffix + "&basedn=" + dn +
				  "&adminusername=" + username + "&password=" + password + "&contexts="+ contexts +"&location=" + location;
                  
                  //console.log(myData);
        $.ajax({
            url:"processor.php",
            type:"post",
			data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Configurations Successfully Added!');
					window.location.reload();
				} else if (result == 101){
					$("#loader").hide();
					alert('Session Expired! Login again!');
					window.location = 'logout.php';
				} else if (result == 2){
					$("#loader").hide();
					alert('Configurations Successfully UPdated');
				} else if (result == 103){
					$("#loader").hide();
					alert('Error inserting new ldap entry! Try again later');
				} else if(result == 105){
					$("#loader").hide();
					alert('Error! Reload page or try again later');
					window.location.reload();
				} else if (result == 404) {
					$("#loader").hide();
					alert('Function not found');
				} else {
					$("#loader").hide();
					alert('Internal update error');
				}
            }
        });
}
</script>
<!-- Content start -->
<div id="container" class="box1">
	<div id="obsah" class="content box1">
		<div id="center">
			<form name="empform" action="#" method="post" onSubmit="return false;">
				<fieldset><legend>Active Directory Settings</legend>

				<div style="height:20px;margin:0 0 0 200px; "><img src="images/ajax-loader.gif" id="loader" style="display:none" /></div>
				<!-- Server Settings-->
                <fieldset>
					<legend>Server Settings</legend>
					
					<div class="text-box-name">Host url:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_host" id="cfg_host" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>
					
					<div class="text-box-name">Version:</div>
					<div class="text-box-field">
						<select name="cfg_ver" id = "cfg_ver"  class="form-text" style="width:91%" >
							<option value='2'>2</option>
							<option value='3' selected='selected'>3</option>
						</select>			
					</div>
					<div class="text-box-field"></div>
					
					<div class="text-box-name">LDAP encoding:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_encoding" id="cfg_encoding" value="utf-8" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>
				</fieldset>
				
				<!-- Bind Settings-->
                <fieldset>
					<legend>Bind Settings</legend>
					
					<div class="text-box-name">Account Suffix:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_suffix" id="cfg_suffix" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>

					<div class="text-box-name">Base DN:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_dn" id="cfg_dn" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>
					
					<div class="text-box-name">Admin Username:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_username" id="cfg_username" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>

					<div class="text-box-name">Password:</div>
					<div class="text-box-field">
						<input type="password" name="cfg_password" id="cfg_password" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>

				</fieldset>
				
				<!-- User Lookup Settings-->
                <fieldset>
					<legend>User Lookup Settings</legend>
					
					<!-- <div class="text-box-name">User Type:</div>
					<div class="text-box-field">
						<select name="cfg_usertype" id = "cfg_usertype"  class="form-text" style="width:91%" >
							<option value='ad'>MS Active Directory</option>
						</select>			
					</div>
					<div class="text-box-field"></div>-->
					
					<div class="text-box-name">Contexts:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_contexts" id="cfg_contexts" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field">Multiple context seperated by ;</div>

					<div class="text-box-name">Location Name:</div>
					<div class="text-box-field">
						<input type="text" name="cfg_location" id="cfg_location" value="" class="form-text" size="30" maxlength="2048" />
					</div>
					<div class="text-box-field"></div>
				</fieldset>
			
				<input type="button" name="cfg_settings" id="cfg_settings" value="submit" style="width:80px; height:30px;margin-left:90px" /> 
				<input type="reset" name="txtempreset" id="txtempreset" value="Reset" style="width:80px; height:30px;" />
				</fieldset>
				<!--<td><div id="loader" style="display:block"><img src = 'images/ajax-loader.gif' /></div></td>-->

			</form>
		</div>
	</div>
</div>
<!-- Content End -->
<?php
require_once('includes/_incFooter.php');
?>