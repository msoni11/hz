$("document").ready(function(){
// js for new employee form |start|
function hasNumbers(t) {
	return /\d/.test(t);
}
$("#txtunit").change(function(){
    if ($("#txtunit").val() == '0') {
        $("#unittext").empty().append('<input type="text" name="txtunittext" id="txtunittext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#unittext").empty();
    }
});

$("#txtdepartment").change(function(){
    if ($("#txtdepartment").val() == '0') {
       $("#departmenttext").empty().append('<input type="text" name="txtdepartmenttext" id="txtdepartmenttext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#departmenttext").empty();
    }
});
$("#txtempreset").click(function(){
    $("#unittext").empty();
    $("#departmenttext").empty();
});

	$("#newempbtn").live('click', function(){
		hz_newemployee();
	});
	function hz_newemployee() {
		$("#loader").show();
        var empid          = $.trim($("#txtempid").val());
        var empname        = encodeURIComponent($("#txtempname").val());
        var unit           = encodeURIComponent($("#txtunit").val());
        var department     = encodeURIComponent($("#txtdepartment").val());
        var designation    = encodeURIComponent($("#txtdesignation").val());
        var unittext       = encodeURIComponent($("#txtunittext").val());
        var departmenttext = encodeURIComponent($("#txtdepartmenttext").val());

        if (empid == '') {
			$("#loader").hide();
            alert('Enter employee id');
			return;
        } else if (isNaN(empid)) {
			$("#loader").hide();
            alert('Employee Id should be numeric');
			return;
        } else if (empid.length != '6') {
			$("#loader").hide();
            alert('Employee Id should be of 6 digits only');
			return;
        } else if (empname == '') {
			$("#loader").hide();
            alert('Enter employee name');
			return;
        } else if (unit == '-1') {
			$("#loader").hide();
            alert('Select unit');
			return;
        } else if (unit == '0' && unittext == '') {
			$("#loader").hide();
            alert('Enter unit please!');
			return;
        } else if (department == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
        } else if (department == '0' && departmenttext == '') {
			$("#loader").hide();
            alert('Enter department please!');
			return;
        } else if (designation == '') {
			$("#loader").hide();
            alert('Enter designation');
			return;
	    }

        if (unit == '0') {
            unit = unittext;
        }
        if (department == '0') {
            department = departmenttext;
        }

        $.ajax({
            url:"processrequest.php",
            type:"post",
		    data:"functype=newemployee&empid=" + empid + "&empname=" + empname + "&unit=" + unit + "&department=" + department + "&designation=" + designation,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Employee has succesfully added!');
					$("#txtempid").val('');
					$("#txtempname").val('');
					$("#txtunit").val('-1');
					$("#txtdepartment").val('-1');
					$("#txtdesignation").val('');
					$("#unittext").empty();
					$("#departmenttext").empty();
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Employee ID already exist! Try another');
				} else if (result == 103){
					$("#loader").hide();
					alert('Error creating new employee! Try again later');
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
// js for new employee form |end|

// js for new user form |start|
    $("#newuserbtn").live('click', function(){
		hz_newuser();
    });
	function hz_newuser(){
		$("#loader").show();
		var uname     = $.trim($("#txtusername").val());
        var password    = $.trim($("#txtpassword").val());
        var usertype    = $("#txtusertype").val();
        if (uname == '') {
			$("#loader").hide();
            alert('Enter valid username');
			return;
        } else if (password == '') {
			$("#loader").hide();
            alert('Enter valid password');
			return;
        }
		
		 $.ajax({
            url:"processrequest.php",
            type:"post",
		    data:"functype=newuser&uname=" + uname + "&password=" + password + "&usertype=" + usertype,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('new user added');
					$("#txtusername").val('');
					$("#txtpassword").val('');
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error inserting user entry!');
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102) {
					$("#loader").hide();
					alert('User already exists! Try another username');
					$("#txtusername").val('');
					$("#txtpassword").val('');
				} else if(result == 105){
					$("#loader").hide();
					alert('Error! Reload page or try again later');
					window.location.reload();
				} else if (result == 404) {
						$("#loader").hide();
						alert('Function not found');
				} else {
					$("#loader").hide();
					alert('Internal update error !');
				}
            }
        });
		
	}
// js for new user form |end|


// js for user registration form |start|

$("#txthardware").change(function(){

	var hardwareid = $("#txthardware").val();

	if (hardwareid == 2) { // laptop
		$("#ipaddress").removeAttr('disabled');
		$("#ipaddress").val('');
		$("#txtmonitor1").attr('disabled', 'disabled');
		$("#txtmonitor1").val('NONE');
		$("#txtcpuno").removeAttr('disabled', 'disabled');
		$("#txtcpuno").val('');
		$("#txtcrtno").attr('disabled', 'disabled');
		$("#txtcrtno").val('NONE');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	} else if (hardwareid == 3 ) { // printer
		$("#txtcpuno").removeAttr('disabled', 'disabled');
		$("#txtcpuno").val('');
		$("#txtmonitor1").attr('disabled', 'disabled');
		$("#txtmonitor1").val('NONE');
		$("#txtcrtno").attr('disabled', 'disabled');
		$("#txtcrtno").val('NONE');
		$("#txtoffice").attr('disabled', 'disabled');
		$("#txtoffice").val('NONE');
		$("#txtlicense").attr('disabled', 'disabled');
		$("#txtlicense").val('NONE');
		$("#txtinternet").attr('disabled', 'disabled');
		$("#txtinternet").val('NONE');
		$("#txtconfig").empty().append('<option value="-1" >----Select Configuration----</option>');
		$("#txtconfig").append('<option value="0" >Other</option>');
		$("#txtconfig").append('<option value="NONE" >NONE</option>');
		$("#configtext").empty();
		$("#txtconfig").attr('disabled', 'disabled');
		$("#txtconfig").val('NONE');
	} else if (hardwareid == 4 ) { // scanner
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
		$("#txtcpuno").removeAttr('disabled', 'disabled');
		$("#txtcpuno").val('');
		$("#txtmonitor1").attr('disabled', 'disabled');
		$("#txtmonitor1").val('NONE');
		$("#txtcrtno").attr('disabled', 'disabled');
		$("#txtcrtno").val('NONE');
		$("#txtoffice").attr('disabled', 'disabled');
		$("#txtoffice").val('NONE');
		$("#txtlicense").attr('disabled', 'disabled');
		$("#txtlicense").val('NONE');
		$("#txtinternet").attr('disabled', 'disabled');
		$("#txtinternet").val('NONE');
		$("#ipaddress").attr('disabled', 'disabled');
		$("#ipaddress").val('NONE');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	} else {
		$("#ipaddress").val('');
		$("#ipaddress").removeAttr('disabled');
		$("#txtmonitor1").val('-1');
		$("#txtmonitor1").removeAttr('disabled');
		$("#txtcpuno").val('');
		$("#txtcpuno").removeAttr('disabled', 'disabled');
		$("#txtcrtno").val('');
		$("#txtcrtno").removeAttr('disabled');
		$("#txtoffice").val('-1');
		$("#txtoffice").removeAttr('disabled');
		$("#txtlicense").val('');
		$("#txtlicense").removeAttr('disabled');
		$("#txtinternet").val('YES');
		$("#txtinternet").removeAttr('disabled');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	}

	$("#txtcartage").empty().append('<option value="-1" >----Select Cartage----</option>');
	$("#txtcartage").append('<option value="0" >Other</option>');
	$("#txtcartage").append('<option value="NONE" selected >NONE</option>');

	$("#txtprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
	//$("#txtprintertype").append('<option value="0" >Other</option>');
	$("#txtprintertype").append('<option value="0" selected >NONE</option>');

	$("#txtmake").empty().append('<option value="-1" >----Select Make----</option>');
	//$("#txtmake").append('<option value="0" >Other</option>');
	//$("#txtmake").append('<option value="NONE" >NONE</option>');

	$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
	//$("#txtmodel").append('<option value="0" >Other</option>');
	//$("#txtmodel").append('<option value="NONE" >NONE</option>');

	if (hardwareid == 3) {
		$("#printertype").show();
		$("#cartage").show();
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#txtprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				/*$("#txtprintertype").append('<option value="0" >Other</option>');
				$("#txtprintertype").append('<option value="NONE" >NONE</option>');*/
				}
		});
	
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getecartage&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtcartage").empty().append('<option value="-1" >----Select Cartage----</option>');
				$.each(arr, function(key,val){
					$("#txtcartage").append('<option value="'+key+'" >'+ val +'</option>');
				});
				//$("#txtcartage").append('<option value="0" >Other</option>');
				$("#txtcartage").append('<option value="NONE" >NONE</option>');
				}
		});
	} else {
		$("#printertype").hide();
		$("#cartage").hide();
	} 
	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#txtmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				/*$("#txtmake").append('<option value="0" >Other</option>');
				$("#txtmake").append('<option value="NONE" >NONE</option>');*/
				}
			});
	}

    if (hardwareid == '0') {
        $("#hardwaretext").empty().append('<input type="text" name="txthardwaretext" id="txthardwaretext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#hardwaretext").empty();
    }

});

//cartage other
$("#txtcartage").change(function(){
    if ($("#txtcartage").val() == '0') {
        $("#cartagetext").empty().append('<input type="text" name="txtcartagetext" id="txtcartagetext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#cartagetext").empty();
    }
});

//printer type other
$("#txtprintertype").change(function(){
    if ($("#txtprintertype").val() == '0') {
        $("#printertypetext").empty().append('<input type="text" name="txtprintertypetext" id="txtprintertypetext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#printertypetext").empty();
    }
});

//make other
$("#txtmake").change(function(){
    if ($("#txtmake").val() == '0') {
        $("#maketext").empty().append('<input type="text" name="txtmaketext" id="txtmaketext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#maketext").empty();
    }
});

//model other
$("#txtmodel").change(function(){
    if ($("#txtmodel").val() == '0') {
        $("#modeltext").empty().append('<input type="text" name="txtmodeltext" id="txtmodeltext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#modeltext").empty();
    }
});

//configuration other
$("#txtconfig").change(function(){
    if ($("#txtconfig").val() == '0') {
        $("#configtext").empty().append('<input type="text" name="txtconfigtext" id="txtconfigtext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#configtext").empty();
    }
});

//IT asset other
$("#txtasset").change(function(){
        $("#assettext").empty().append('<input type="text" name="txtassettext" id="txtassettext" value="" class="form-text" size="30" maxlength="2048">');
});

// AMC/WAR
$("#txtamc").change(function(){
    if ($("#txtamc").val() == 'AMC') {
	$("#vendor").show();
	$("#warrdate").hide();
    } else if ($("#txtamc").val() == 'WAR') {
	$("#vendor").hide();
	$("#warrdate").show();
    }

});

$("#txtregreset").click(function(){
	$("#assettext").empty()				
	$("#hardwaretext").empty()				
	$("#maketext").empty()				
	$("#unittext").empty()				
	$("#departmenttext").empty()				
	$("#vendor").hide();
	$("#warrdate").hide();
	$("#printertype").hide();
	$("#cartage").hide();
});
	function fnValidateIPAddress(ipaddr) {
		//Remember, this function will validate only Class C IP.
		//change to other IP Classes as you need
		ipaddr = ipaddr.replace( /\s/g, "") //remove spaces for checking
		var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/; //regex. check for digits and in
											  //all 4 quadrants of the IP
		if (re.test(ipaddr)) {
			//split into units with dots "."
			var parts = ipaddr.split(".");
			//if the first unit/quadrant of the IP is zero
			if (parseInt(parseFloat(parts[0])) == 0) {
				return false;
			}
			//if the fourth unit/quadrant of the IP is zero
			if (parseInt(parseFloat(parts[3])) == 0) {
				return false;
			}
			//if any part is greater than 255
			for (var i=0; i<parts.length; i++) {
				if (parseInt(parseFloat(parts[i])) > 255){
					return false;
				}
			}
			return true;
		} else {
			return false;
		}
	}
	function validateNetMask(mask){
		//m[0] can be 128, 192, 224, 240, 248, 252, 254, 255
		//m[1] can be 128, 192, 224, 240, 248, 252, 254, 255 if m[0] is 255, else m[1] must be 0
		//m[2] can be 128, 192, 224, 240, 248, 252, 254, 255 if m[1] is 255, else m[2] must be 0
		//m[3] can be 128, 192, 224, 240, 248, 252, 254, 255 if m[2] is 255, else m[3] must be 0

		//var flag = '';
		var correct_range = {128:1,192:1,224:1,240:1,248:1,252:1,254:1,255:1,0:1};
		var m = mask.split('.');

		for (var i = 0; i <= 3; i ++) {
			if (!(m[i] in correct_range)) {
				//flag = 'Mask is not valid';
				return false;
				break;
			}
		}
		
		if ((m[0] == 0) || (m[0] != 255 && m[1] != 0) || (m[1] != 255 && m[2] != 0) || (m[2] != 255 && m[3] != 0)) {
			//flag = 'Mask is not valid';
			return false;
		}
		
		return true;
	}

    $("#txtregempid").live('blur', function(){
		hz_getEmployeeDetails();
    });

	function hz_getEmployeeDetails() {
		$("#loader").show();
		var reggetempid = $("#txtregempid").val();
		/*if (reggetempid == '') {
			$("#loader").hide();
            //alert('Enter Employee ID !');
			$("#txtempname").val('');
			$("#txtunit").val('-1');
			$("#txtdepartment").val('-1');
			$("#txtdesignation").val('');
			$("#unittext").empty();
			$("#departmenttext").empty();
			$("#hideEmpDetails").hide();
			return;
		} else if (isNaN(reggetempid)) {
			$("#loader").hide();
            //alert('Employee ID should be Numeric !');
			$("#txtempname").val('');
			$("#txtunit").val('-1');
			$("#txtdepartment").val('-1');
			$("#txtdesignation").val('');
			$("#unittext").empty();
			$("#departmenttext").empty();
			$("#hideEmpDetails").hide();
			return;
		} else if (reggetempid.length != '6') {
			$("#loader").hide();
            //alert('Employee Id should be of 6 digits only');
			$("#txtempname").val('');
			$("#txtunit").val('-1');
			$("#txtdepartment").val('-1');
			$("#txtdesignation").val('');
			$("#unittext").empty();
			$("#departmenttext").empty();
			$("#hideEmpDetails").hide();
			return;
		}*/
		$.ajax({
		    url:"processrequest.php",
		    type:"post",
			    data:"functype=getempdetails&reggetempid=" + reggetempid,
			success: function(result) {
				if (result == 102) {
					$("#loader").hide();
					alert("User doesn't exist");
					$("#txtempname").val('');
					$("#txtunit").val('-1');
					$("#txtdepartment").val('-1');
					$("#txtdesignation").val('');
					$("#unittext").empty();
					$("#departmenttext").empty();
					$("#hideEmpDetails").hide();
				} else {
				$("#loader").hide();
				var arr = $.parseJSON(result);
				$("#hideEmpDetails").show();
				$("#txtempname").val(arr['empname'])
								.attr('disabled', 'disabled');
				$("#txtregempiddesc").val(arr['empiddesc'])
									 .attr('disabled', 'disabled');
				$("#txtdepartment").val(arr['department'])
								   .attr('disabled', 'disabled');
				$("#txtdesignation").val(arr['designation'])
								    .attr('disabled', 'disabled');
				$("#txtunit").val(arr['unit']);
				if (($("#txtunit").val() == '-1') || ($("#txtunit").val() == null) || ($("#txtunit").val() == '')) {
					$("#txtunit").val(0);
					$("#unittext").empty().append('<input type="text" name="txtunittext" id="txtunittext" value="'+ arr['unit'] + '" class="form-text" size="30" maxlength="2048">');
				}

				/*if ($("#txtdepartment").val() == '-1' || ($("#txtdepartment").val() == null) || ($("#txtdepartment").val() == '')) {
					$("#txtdepartment").val(0);
					$("#departmenttext").empty().append('<input type="text" name="txtdepartmenttext" id="txtdepartmenttext" value="' + arr['department'] + '" class="form-text" size="30" maxlength="2048">');
				}*/
				}
			}
		});
	}

    $("#newregbtn").live('click', function(){
	hz_newregistration();
    });
	function hz_newregistration() {
		$("#loader").show();
		var regempid       = $.trim($("#txtregempid").val());
		var regempname     = $("#txtempname").val();
		var regunit        = encodeURIComponent($("#txtunit").val());
		var regdepartment  = encodeURIComponent($("#txtdepartment").val());
		var regdesignation = $("#txtdesignation").val();
		var regunittext    = encodeURIComponent($("#txtunittext").val());
		var regdepartmenttext = encodeURIComponent($("#txtdepartmenttext").val());
		var reghardware    = encodeURIComponent($("#txthardware").val());
		var regtxthardware = encodeURIComponent($("#txthardwaretext").val());
		var regcartage     = encodeURIComponent($("#txtcartage").val());
		var regtxtcartage  = encodeURIComponent($("#txtcartagetext").val());
		var regprintertype = encodeURIComponent($("#txtprintertype").val());
		var regtxtprintertype = encodeURIComponent($("#txtprintertypetext").val());
		var regmake        = encodeURIComponent($("#txtmake").val());
		var regtxtmake     = encodeURIComponent($("#txtmaketext").val());
		var regmodel       = encodeURIComponent($("#txtmodel").val());
		var regtxtmodel    = encodeURIComponent($("#txtmodeltext").val());
		var regcpuno       = encodeURIComponent($("#txtcpuno").val());
		var regmonitor     = $("#txtmonitor1").val();
		var regcrtno       = encodeURIComponent($("#txtcrtno").val());
		var regconfig      = encodeURIComponent($("#txtconfig").val());
		var regtxtconfig   = encodeURIComponent($("#txtconfigtext").val());
		var regasset       = $("#txtasset").val();
		var regassettext   = encodeURIComponent($("#txtassettext").val());
		var regip          = $("#ipaddress").val();
		var regoffice      = $("#txtoffice").val();
		var reglicense     = encodeURIComponent($("#txtlicense").val());
		var reginternet    = $("#txtinternet").val();
		var regamc         = $("#txtamc").val();
		var regday         = $("#txtday").val();
		var regmonth       = $("#txtmonth").val();
		var regyear        = $("#txtyear").val();
		var regotherasset  = encodeURIComponent($("#txtotheritasset").val());
		var regstatus      = encodeURIComponent($.trim($("#txtregstatus").val()));

		if (regamc == 'AMC') {
			var regvendor         = $("#txtvendor").val();
		} else if (regamc == 'WAR') {
			var regwarnday         = $("#txtwarnday").val();
			var regwarnmonth       = $("#txtwarnmonth").val();
			var regwarnyear        = $("#txtwarnyear").val();
		}
		
		if (regempid == '') {
			$("#loader").hide();
            alert('Enter Employee ID !');
			return;
		} /*else if (isNaN(regempid)) {
			$("#loader").hide();
            alert('Employee ID should be Numeric !');
			return;
		} else if (regempid.length != '6') {
			$("#loader").hide();
            alert('Employee Id should be of 6 digits only');
			return;
		}*/ else if (regempname == '') {
			$("#loader").hide();
	    alert('Enter employee name');
			return;
		} else if (regunit == '-1') {
			$("#loader").hide();
            alert('Select unit');
			return;
		} else if (regunit == '0' && regunittext == '') {
			$("#loader").hide();
            alert('Enter unit please!');
			return;
		} else if (regdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
		} else if (regdepartment == '0' && regdepartmenttext == '') {
			$("#loader").hide();
            alert('Enter department please!');
			return;
		} else if (regdesignation == '') {
			$("#loader").hide();
            alert('Enter designation');
			return;
		} else if (reghardware == '-1') {
			$("#loader").hide();
            alert('Select Hardware !');
			return;
		} else if (reghardware == '0' && regtxthardware == '') {
			$("#loader").hide();
            alert('Enter Hardware please!');
			return;
		} else if (reghardware == '3' && regprintertype == '-1') {
			$("#loader").hide();
            alert('Select Printer type!');
			return;
		} else if (reghardware == '3' && regprintertype == '0' && regtxtprintertype == '') {
			$("#loader").hide();
            alert('Enter Printer type!');
			return;
		} else if (regmake == '-1') {
			$("#loader").hide();
            alert('Select Make !');
			return;
		} else if (regmake == '0' && regtxtmake == '') {
			$("#loader").hide();
            alert('Enter make please!');
			return;
		} else if (regmodel == '-1') {
			$("#loader").hide();
            alert('Select Model!');
			return;
		} else if (regmodel == '0' && regtxtmodel == '') {
			$("#loader").hide();
            alert('Enter model please!');
			return;
		} else if (regcpuno == '') {
			$("#loader").hide();
            alert('Enter CPU Serial No. !');
			return;
		} else if (regmonitor == '-1') {
			$("#loader").hide();
            alert('Select Monitor !');
			return;
		} else if (regcrtno == '') {
			$("#loader").hide();
            alert('Enter CRT/TFT Serial No. !');
			return;
		} else if (regconfig == '-1') {
			$("#loader").hide();
            alert('Select Configuration !');
			return;
		} else if (regconfig == '0' && regtxtconfig == '') {
			$("#loader").hide();
            alert('Enter configuration please!');
			return;
		} else if (reghardware == '3' && regcartage == '-1') {
			$("#loader").hide();
            alert('Select Cartage No. !');
			return;
		} else if (reghardware == '3' && regcartage == '0' && regtxtcartage == '') {
			$("#loader").hide();
            alert('Enter Cartage No. !');
			return;
		} else if (regasset == '-1') {
			$("#loader").hide();
            alert('Select Asset Code !');
			return;
		} else if (regassettext == '') {
			$("#loader").hide();
            alert('Enter Asset code !');
			return;
		} else if (regip == '') {
			$("#loader").hide();
            alert('Enter IP Address !');
			return;
		} else if (regip != 'NONE' && !fnValidateIPAddress(regip)) {
			$("#loader").hide();
            alert('Enter Correct IP Address !');
			return;
		} else if (regoffice == '-1') {
			$("#loader").hide();
            alert('Select Office Version !');
			return;
		} else if (reglicense == '') {
			$("#loader").hide();
            alert('Enter License Software If Any !');
			return;
		} else if (reginternet == '') {
			$("#loader").hide();
            alert('Enter Internet Information !');
			return;
		} else if (regamc == '-1') {
			$("#loader").hide();
            alert('Select AMC/WAR !');
			return;
		} else if (regamc == 'AMC' && regvendor == '') {
			$("#loader").hide();
            alert('Enter vendor name please!');
			return;
		} else if (regamc == 'WAR' && regwarnday == '-1') {
			$("#loader").hide();
            alert('Select warranty day!');
			return;
		} else if (regamc == 'WAR' && regwarnmonth == '-1') {
			$("#loader").hide();
            alert('Select warranty month!');
			return;
		} else if (regamc == 'WAR' && regwarnyear == '-1') {
			$("#loader").hide();
            alert('Select warranty year!');
			return;
		} else if (regday == '-1') {
			$("#loader").hide();
            alert('Select day !');
			return;
		} else if (regmonth == '-1') {
			$("#loader").hide();
            alert('Select Month !');
			return;
		} else if (regyear == '-1') {
			$("#loader").hide();
            alert('Select Year !');
			return;
		} else if (regotherasset == '') {
			$("#loader").hide();
            alert('Enter Other IT Assets !');
			return;
		} else if (regstatus == '') {
			$("#loader").hide();
            alert('Enter Status !');
			return;
		}

        /*if (reghardware == '0') {
            reghardware = regtxthardware;
        }*/

        if (regcartage == '0') {
            regcartage = regtxtcartage;
        }

        /*if (regprintertype == '0') {
            regprintertype = regtxtprintertype;
        }

        if (regmake == '0') {
            regmake = regtxtmake;
        }

        if (regmodel == '0') {
            regmodel = regtxtmodel;
        }*/

        if (regconfig == '0') {
            regconfig = regtxtconfig;
        }

        if (regunit == '0') {
            regunit = regunittext;
        }

        if (regdepartment == '0') {
            regdepartment = regdepartmenttext;
        }
	
	if (regamc == 'AMC') {
		var allData = "functype=newregistration&regempid=" + regempid + "&regempname=" + regempname +
				"&regunit=" + regunit + "&regdepartment=" + regdepartment + "&regdesignation=" + regdesignation + 
				"&reghardware=" + reghardware + "&regcartage=" + regcartage + "&regprintertype=" + regprintertype + 
				"&regmake=" + regmake + "&regmodel=" + regmodel + "&regcpuno=" + regcpuno + 
				"&regmonitor=" + regmonitor + "&regcrtno=" + regcrtno + "&regconfig=" + regconfig + 
				"&regasset=" + regasset + "&regassettext=" + regassettext + "&regip=" + regip+ "&regoffice=" + regoffice+ 
				"&reglicense=" + reglicense+ "&reginternet=" + reginternet+ "&regamc=" + regamc + "&regvendor=" + regvendor + 
				"&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regotherasset=" + regotherasset+
				"&regstatus=" + regstatus;
	} else 	if (regamc == 'WAR') {
		var allData = "functype=newregistration&regempid=" + regempid + "&regempname=" + regempname +
				"&regunit=" + regunit + "&regdepartment=" + regdepartment + "&regdesignation=" + regdesignation + 
				"&reghardware=" + reghardware + "&regcartage=" + regcartage + "&regprintertype=" + regprintertype + 
				"&regmake=" + regmake + "&regmodel=" + regmodel + "&regcpuno=" + regcpuno + 
				"&regmonitor=" + regmonitor + "&regcrtno=" + regcrtno + "&regconfig=" + regconfig + 
				"&regasset=" + regasset + "&regassettext=" + regassettext + "&regip=" + regip+ "&regoffice=" + regoffice+ 
				"&reglicense=" + reglicense+ "&reginternet=" + reginternet + "&regamc=" + regamc + "&regwarnday=" + regwarnday + "&regwarnmonth=" + regwarnmonth +
				"&regwarnyear=" + regwarnyear + "&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regotherasset=" + regotherasset+
				"&regstatus=" + regstatus;
	}
	
	$.ajax({
            url:"processrequest.php",
            type:"post",
	    data:allData,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('Registration has been done succesfully');
						/*$("#txtregempid").val('');
						$("#txtempname").val('');
						$("#txtunit").val('-1');
						$("#txtdepartment").val('-1');
						$("#txtdesignation").val('');
						$("#unittext").empty();
						$("#departmenttext").empty();
						$("#txthardware").val('-1');
						$("#hardwaretext").empty();
						$("#printertype").hide();
						$("#cartage").hide();
						$("#maketext").empty();
						$("#txtmake").val('-1');
						$("#txtmodel").val('');
						$("#modeltext").empty();
						$("#txtcpuno").val('');
						$("#txtmonitor1").val('-1');
						$("#txtcrtno").val('');
						$("#txtconfig").val('');
						$("#configtext").empty();
						$("#txtasset").val('-1');
						$("#assettext").empty()				
						$("#ipaddress").val('');
						$("#txtoffice").val('-1');
						$("#txtlicense").val('');
						$("#txtamc").val('-1');
						$("#txtday").val('-1');
						$("#txtmonth").val('-1');
						$("#txtyear").val('-1');
						$("#txtotheritasset").val('');
						$("#txtregstatus").val('');*/
						window.location.reload();
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error inserting user entry!');
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102) {
					$("#loader").hide();
					alert('employee id doesn\'t exist');
				} else if (result == 105) {
					$("#loader").hide();
					alert('Security ! Reload page or try again later');
				} else if (result == 110) {
					$("#loader").hide();
					alert('Asset not available in stock');
				} else if (result == 111) {
					$("#loader").hide();
					alert('All asset has been alloted');
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

// js for user registration form |end|

// js for user other itasset form |start|

$("#txtotherithardware").change(function(){

	var hardwareid = $("#txtotherithardware").val();

	$("#txtotheritmake").empty().append('<option value="-1" >----Select Make----</option>');
	$("#txtotheritmodel").empty().append('<option value="-1" >----Select Model----</option>');

	if (hardwareid == 15 || hardwareid == 16 || hardwareid == 17 ) { // DVD / MOUSE / KEYBOARD
		$("#txtotheritmodel").empty().append('<option value="0" >NONE</option>');
		$("#txtotheritmodel").attr('disabled', 'disabled');
		$("#txtotheritmodel").val('0');
	} else {
		$("#txtotheritmodel").removeAttr('disabled', 'disabled');
		$("#txtotheritmodel").val('-1');
	}

	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtotheritmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#txtotheritmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				/*$("#txtmake").append('<option value="0" >Other</option>');
				$("#txtmake").append('<option value="NONE" >NONE</option>');*/
				}
			});
	}
});

    $("#newotherregbtn").live('click', function(){
	hz_newotherregistration();
    });
	function hz_newotherregistration() {
		$("#loader").show();
		var regempid       = $.trim($("#txtregempid").val());
		var regempname     = $("#txtempname").val();
		var regunit        = encodeURIComponent($("#txtunit").val());
		var regunittext    = encodeURIComponent($("#txtunittext").val());
		var regdepartment  = encodeURIComponent($("#txtdepartment").val());
		var regdepartmenttext = encodeURIComponent($("#txtdepartmenttext").val());
		var regdesignation = $("#txtdesignation").val();
		var reghardware    = encodeURIComponent($("#txtotherithardware").val());
		var regmake        = encodeURIComponent($("#txtotheritmake").val());
		var regmodel       = encodeURIComponent($("#txtotheritmodel").val());
		var regrcvrname    = encodeURIComponent($("#txtotheritreceivername").val());
		var regday         = $("#txtotheritday").val();
		var regmonth       = $("#txtotheritmonth").val();
		var regyear        = $("#txtotherityear").val();
		var regissuedby    = encodeURIComponent($("#txtotheritissuedby").val());
		var regstatus      = encodeURIComponent($.trim($("#txtotheritstatus").val()));

	
		if (regempid == '') {
			$("#loader").hide();
            alert('Enter Employee ID !');
			return;
		} else if (isNaN(regempid)) {
			$("#loader").hide();
            alert('Employee ID should be Numeric !');
			return;
		} else if (regempid.length != '6') {
			$("#loader").hide();
            alert('Employee Id should be of 6 digits only');
			return;
		} else if (regempname == '') {
			$("#loader").hide();
	    alert('Enter employee name');
			return;
		} else if (regunit == '-1') {
			$("#loader").hide();
            alert('Select unit');
			return;
		} else if (regunit == '0' && regunittext == '') {
			$("#loader").hide();
            alert('Enter unit please!');
			return;
		} else if (regdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
		} else if (regdepartment == '0' && regdepartmenttext == '') {
			$("#loader").hide();
            alert('Enter department please!');
			return;
		} else if (regdesignation == '') {
			$("#loader").hide();
            alert('Enter designation');
			return;
		} else if (reghardware == '-1') {
			$("#loader").hide();
            alert('Select Hardware !');
			return;
		} else if (reghardware == '0' && regtxthardware == '') {
			$("#loader").hide();
            alert('Enter Hardware please!');
			return;
		} else if (reghardware == '3' && regprintertype == '-1') {
			$("#loader").hide();
            alert('Select Printer type!');
			return;
		} else if (reghardware == '3' && regprintertype == '0' && regtxtprintertype == '') {
			$("#loader").hide();
            alert('Enter Printer type!');
			return;
		} else if (regmake == '-1') {
			$("#loader").hide();
            alert('Select Make !');
			return;
		} else if (regmake == '0' && regtxtmake == '') {
			$("#loader").hide();
            alert('Enter make please!');
			return;
		} else if (regmodel == '-1') {
			$("#loader").hide();
            alert('Select Model!');
			return;
		} else if (regmodel == '0' && regtxtmodel == '') {
			$("#loader").hide();
            alert('Enter model please!');
			return;
		} else if (regrcvrname == '') {
			$("#loader").hide();
            alert('Enter Receiver Name !');
			return;
		} else if (regday == '-1') {
			$("#loader").hide();
            alert('Select day !');
			return;
		} else if (regmonth == '-1') {
			$("#loader").hide();
            alert('Select Month !');
			return;
		} else if (regyear == '-1') {
			$("#loader").hide();
            alert('Select Year !');
			return;
		} else if (regissuedby == '') {
			$("#loader").hide();
            alert('Enter Name of Issued By !');
			return;
		} else if (regstatus == '') {
			$("#loader").hide();
            alert('Enter Other Status !');
			return;
		}

		
        if (regunit == '0') {
            regunit = regunittext;
        }

        if (regdepartment == '0') {
            regdepartment = regdepartmenttext;
        }

		var allData = "functype=newotherregistration&regempid=" + regempid + "&regempname=" + regempname +
				"&regunit=" + regunit + "&regdepartment=" + regdepartment + "&regdesignation=" + regdesignation + 
				"&reghardware=" + reghardware + "&regmake=" + regmake + "&regmodel=" + regmodel + "&regrcvrname=" + regrcvrname +  
				"&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regissuedby=" + regissuedby+
				"&regstatus=" + regstatus;

		$.ajax({
            url:"processrequest.php",
            type:"post",
			data:allData,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('Registration has been done succesfully');
					window.location.reload();
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error inserting IT asset entry!');
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102) {
					$("#loader").hide();
					alert('employee id doesn\'t exist');
				} else if (result == 105) {
					$("#loader").hide();
					alert('Security ! Reload page or try again later');
				} else if (result == 110) {
					$("#loader").hide();
					alert('Asset not available in stock');
				} else if (result == 111) {
					$("#loader").hide();
					alert('All asset has been alloted');
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

// js for user other itasset form |end|

// js for user network form |start|
$("#txtntwrkdept").change(function(){
    if ($("#txtntwrkdept").val() == '0') {
        $("#ntwrkdepttext").empty().append('<input type="text" name="txtntwrkdepttext" id="txtntwrkdepttext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#ntwrkdepttext").empty();
    }
});
$("#txtntwrkmake").change(function(){
    if ($("#txtntwrkmake").val() == '0') {
        $("#ntwrkmaketext").empty().append('<input type="text" name="txtntwrkmaketext" id="txtntwrkmaketext" value="" class="form-text" size="30" maxlength="2048">');
    } else {
        $("#ntwrkmaketext").empty();
    }
});
    $("#newnetworkbtn").live('click', function(){
		hz_newnetwork();
    });
	function hz_newnetwork() {
		$("#loader").show();
		var ntwdepartment    = encodeURIComponent($("#txtntwrkdept").val());
		var ntwdepartmenttext = encodeURIComponent($("#txtntwrkdepttext").val());
		var ntwitem          = encodeURIComponent($("#txtntwrkitem").val());
		var ntwmake          = encodeURIComponent($("#txtntwrkmake").val());
		var ntwmaketext      = encodeURIComponent($("#txtntwrkmaketext").val());
		var ntwmodel         = encodeURIComponent($("#txtntwrkmodel").val());
		var ntwserial        = $("#txtntwrkserial").val();
		var ntwquantity      = $("#txtntwrkquantity").val();
		var ntwtype          = encodeURIComponent($("#txtntwrktype").val());
		var ntwamc           = $("#txtamc").val();
		
		if (ntwamc == 'AMC') {
			var ntwvendor         = $("#txtntwrkvendor").val();
		} else if (ntwamc == 'WAR') {
			var ntwwarnday         = $("#txtntwrkwarnday").val();
			var ntwwarnmonth       = $("#txtntwrkwarnmonth").val();
			var ntwwarnyear        = $("#txtntwrkwarnyear").val();
		}
		
		if (ntwdepartment == '-1') {
			$("#loader").hide();
            alert('Select department!');
			return;
		} else if (ntwdepartmenttext == '') {
			$("#loader").hide();
            alert('Enter Department!');
			return;
		} else if (ntwitem == '') {
			$("#loader").hide();
            alert('Enter item!');
			return;
		} else if (ntwmake == '-1') {
			$("#loader").hide();
            alert('Select make!');
			return;
		} else if (ntwmake == '0' && ntwmaketext == '') {
			$("#loader").hide();
            alert('Enter make please!');
			return;
		} else if (ntwmodel == '') {
			$("#loader").hide();
            alert('Enter model!');
			return;
		} else if (ntwserial == '') {
			$("#loader").hide();
            alert('Enter serial no.!');
			return;
		} else if (ntwquantity == '') {
			$("#loader").hide();
            alert('Enter quantity!');
			return;
		} else if (isNaN(ntwquantity)) {
			$("#loader").hide();
            alert('Quantity should be numeric!');
			return;
		} else if (ntwtype == '') {
			$("#loader").hide();
            alert('Enter type!');
			return;
		} else if (ntwamc == '-1') {
			$("#loader").hide();
            alert('Select AMC/WAR !');
			return;
		} else if (ntwamc == 'AMC' && ntwvendor == '') {
			$("#loader").hide();
            alert('Enter vendor name please!');
			return;
		} else if (ntwamc == 'WAR' && ntwwarnday == '-1') {
			$("#loader").hide();
            alert('Select warranty day!');
			return;
		} else if (ntwamc == 'WAR' && ntwwarnmonth == '-1') {
			$("#loader").hide();
            alert('Select warranty month!');
			return;
		} else if (ntwamc == 'WAR' && ntwwarnyear == '-1') {
			$("#loader").hide();
            alert('Select warranty year!');
			return;
		}
		
        if (ntwdepartment == '0') {
            ntwdepartment = ntwdepartmenttext;
        }

        if (ntwmake == '0') {
            ntwmake = ntwmaketext;
        }
	
	if (ntwamc == 'AMC') {
		allData = "functype=newnetwork&ntwdepartment=" + ntwdepartment + "&ntwitem=" + ntwitem + "&ntwmake=" + ntwmake + "&ntwmodel=" + ntwmodel + "&ntwserial=" + ntwserial+ "&ntwquantity=" + ntwquantity + "&ntwtype=" + ntwtype + "&ntwamc=" + ntwamc + "&ntwvendor=" + ntwvendor;
	} else if (ntwamc == 'WAR') {
		allData = "functype=newnetwork&ntwdepartment=" + ntwdepartment + "&ntwitem=" + ntwitem + "&ntwmake=" + ntwmake + "&ntwmodel=" + ntwmodel + "&ntwserial=" + ntwserial+ "&ntwquantity=" + ntwquantity + "&ntwtype=" + ntwtype + "&ntwamc=" + ntwamc + "&ntwwarnday=" + ntwwarnday + "&ntwwarnmonth=" + ntwwarnmonth + "&ntwwarnyear=" + ntwwarnyear;
	}
        $.ajax({
            url:"processrequest.php",
            type:"post",
		    data:allData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Network has succesfully added!');
					window.location.reload();
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 105){
					$("#loader").hide();
					alert('Security ! Reload page or try again later');
				} else if (result == 103){
					$("#loader").hide();
					alert('Error inserting new network! Try again later');
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
// js for user network form |end|

// js for change password |start|
    $("#newchangepwdbtn").live('click', function(){
		hz_changepassword();
    });
    
    function hz_changepassword() {
	
		$("#loader").show();
		var bitadmin      = $("#txtchangeadmin").val();
		var checkusername = $("#txtchangeuname").val();
		var oldpwd        = $("#txtoldpassword").val();
		var changepwd     = $("#txteditpassword").val();
		var confirmpwd    = $("#txtconfirmpassword").val();
		
		if (oldpwd == '') {
			$("#loader").hide();
            alert('Enter Old password!');
			return;
		} else if (changepwd == '') {
			$("#loader").hide();
            alert('Enter new password!');
			return;
		} else if (confirmpwd == '') {
			$("#loader").hide();
            alert('Enter Confirm password!');
			return;
		} else if (changepwd != confirmpwd) {
			$("#loader").hide();
            alert('Password doesn\'t match !');
			return;
		}
	    
		$.ajax({
		    url:"processrequest.php",
		    type:"post",
			    data:"functype=changePassword&bitadmin=" + bitadmin + "&checkusername=" + checkusername + "&oldpwd=" + oldpwd + "&changepwd=" + changepwd + "&confirmpwd=" + confirmpwd,
		    success: function(result) {
					if (result == 0) {
						$("#loader").hide();
						alert('Password has been changed!');
						$("#txtoldpassword").val('');
						$("#txteditpassword").val('');
						$("#txtconfirmpassword").val('');
					} else if (result == 101){
						$("#loader").hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 102){
						$("#loader").hide();
						alert('Enter valid old password');
						$("#txtoldpassword").val('');
						$("#txteditpassword").val('');
						$("#txtconfirmpassword").val('');
					} else if (result == 103){
						$("#loader").hide();
						alert('Error updating password! Try again later');
					} else if (result == 105) {
						$("#loader").hide();
						alert('Security alert! Try again later');
						$("#txtoldpassword").val('');
						$("#txteditpassword").val('');
						$("#txtconfirmpassword").val('');
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
// js for change password |end|


// js for critical asset |start|

	$("#criticalhardware").change(function(){
		hardwareid = $("#criticalhardware").val();
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getecriticalhardwarename&hardwareid=" + hardwareid,
			success: function(result) {
			var arr = $.parseJSON(result);
				$("#criticalhwname").empty().append('<option value="-1" >----Select Name----</option>');
				$.each(arr, function(key,val){
					$("#criticalhwname").append('<option value="'+val+'" >'+ val +'</option>');
				});
				$("#criticalhwname").append('<option value="0" >Other</option>');
				/*$("#criticalhwname").append('<option value="NONE" >NONE</option>');*/
			}
		});

		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
			var arr = $.parseJSON(result);
				$("#criticalmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#criticalmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				//$("#criticalmake").append('<option value="0" >Other</option>');
				/*$("#criticalhwname").append('<option value="NONE" >NONE</option>');*/
			}
		});

	/**
	 * He made changes for hardware id 11, not to set disable.. Show none and other both
	 */
	if (hardwareid == '7') { //Router & Core switch
		$("#criticalipsubnet").attr('disabled','disabled');
		$("#criticalipsubnet").val('NONE');
	} else if ( hardwareid == '11') {
		$("#criticalipsubnet").empty().append('<option value=\'-1\'>Select IP Address/ Subnet Mask</option><option value="0">OTHER</option><option value="NONE">NONE</option>');
	} else {
		$("#criticalipsubnet").removeAttr('disabled','disabled');
		$("#criticalipsubnet").val('-1');
	}
	});

	//Name
	$("#criticalhwname").change( function() {
		if ($("#criticalhwname").val() == '0') {
			$("#criticalnametext").empty().append('<input type="text" name="txtcriticalnametext" id="txtcriticalnametext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalnametext").empty();
		}
	});

	//critical asset
	$("#criticalasset").change( function() {
		if ($("#criticalasset").val() != '-1') {
			$("#criticalassettext").empty().append('<input type="text" name="txtcriticalassettext" id="txtcriticalassettext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalassettext").empty();
		}
	});
	
	//Location
	$("#criticallocation").change( function() {
		if ($("#criticallocation").val() == '0') {
			$("#criticallocationtext").empty().append('<input type="text" name="txtcriticallocationtext" id="txtcriticallocationtext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticallocationtext").empty();
		}
	});

	//IP/Subnet
	$("#criticalipsubnet").change( function() {
		if ($("#criticalipsubnet").val() == '0') {
			$("#criticalipsubnettext").empty().append('<input type="text" name="txtcriticalipsubnettext" id="txtcriticalipsubnettext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalipsubnettext").empty();
		}
	});

	/*Configuration*/
	//Processor
	$("#criticalprocessor").change( function() {
		if ($("#criticalprocessor").val() == '0') {
			$("#criticalprocessortext").empty().append('<input type="text" name="txtcriticalprocessortext" id="txtcriticalprocessortext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalprocessortext").empty();
		}
	});

	//Ram
	$("#criticalram").change( function() {
		if ($("#criticalram").val() == '0') {
			$("#criticalramtext").empty().append('<input type="text" name="txtcriticalramtext" id="txtcriticalramtext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalramtext").empty();
		}
	});

	//HDD
	$("#criticalhdd").change( function() {
		if ($("#criticalhdd").val() == '0') {
			$("#criticalhddtext").empty().append('<input type="text" name="txtcriticalhddtext" id="txtcriticalhddtext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalhddtext").empty();
		}
	});

	//CDROM
	$("#criticalcdrom").change( function() {
		if ($("#criticalcdrom").val() == '0') {
			$("#criticalcdromtext").empty().append('<input type="text" name="txtcriticalcdromtext" id="txtcriticalcdromtext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalcdromtext").empty();
		}
	});
	
	//Software
	//operating System
	$("#criticalsoftwareos").change( function() {
		if ($("#criticalsoftwareos").val() == '0') {
			$("#criticalsoftwareostext").empty().append('<input type="text" name="txtcriticalsoftwareostext" id="txtcriticalsoftwareostext" value="" class="form-text" size="30" maxlength="2048">');
		} else {
			$("#criticalsoftwareostext").empty();
		}
	});

	//Reset
	$("#txtcriticalassetreset").click( function() {
			$("#criticalnametext").empty();
			$("#criticalassettext").empty();
			$("#criticallocationtext").empty();
			$("#criticalipsubnettext").empty();
			$("#criticalprocessortext").empty();
			$("#criticalramtext").empty();
			$("#criticalhddtext").empty();
			$("#criticalcdromtext").empty();
			$("#criticalsoftwareostext").empty();
			$("#hiddenconfig").hide();
			$("#hiddenntwrkcard").hide();
			$("#hiddenperipheral").hide();
			$("#hiddensoftware").hide();
	});
	
	$("#criticalconfig").change( function() {
		if($(this).is(":checked")) {
			$("#hiddenconfig").show();
		} else {
			$("#hiddenconfig").hide();
		}
	});

	$("#criticalntwrkcard").change( function() {
		if($(this).is(":checked")) {
			$("#hiddenntwrkcard").show();
		} else {
			$("#hiddenntwrkcard").hide();
		}
	});

	$("#criticalperipheral").change( function() {
		if($(this).is(":checked")) {
			$("#hiddenperipheral").show();
		} else {
			$("#hiddenperipheral").hide();
		}
	});

	$("#criticalsoftware").change( function() {
		if($(this).is(":checked")) {
			$("#hiddensoftware").show();
		} else {
			$("#hiddensoftware").hide();
		}
	});


	$("#newcriticalassetbtn").live('click', function(){
		hz_criticalasset();
	});
		
	function hz_criticalasset() {
		$("#loader").hide();
		var critdepartment        = encodeURIComponent($("#criticaldept").val());
		var crithardware          = encodeURIComponent($("#criticalhardware").val());
		var critname              = encodeURIComponent($("#criticalhwname").val());
		var critnametext          = encodeURIComponent($("#txtcriticalnametext").val());
		var critassetcode         = encodeURIComponent($("#criticalasset").val());
		var critassetcodetext     = encodeURIComponent($("#txtcriticalassettext").val());
		var critlocation          = encodeURIComponent($("#criticallocation").val());
		var critlocationtext      = encodeURIComponent($("#txtcriticallocationtext").val());
		var critassetowner        = encodeURIComponent($("#criticalassetowner").val());
		var critmake              = encodeURIComponent($("#criticalmake").val());
		var critmodel             = encodeURIComponent($("#criticalmodel").val());
		var critserialno          = encodeURIComponent($("#criticalserialno").val());
		var critipsubnet          = ($("#criticalipsubnet").val());
		var critipsubnettext      = ($("#txtcriticalipsubnettext").val());
		var critconfprocessor     = encodeURIComponent($("#criticalprocessor").val());
		var critconfprocessortext = encodeURIComponent($("#txtcriticalprocessortext").val());
		var critconfram           = encodeURIComponent($("#criticalram").val());
		var critconframtext       = encodeURIComponent($("#txtcriticalramtext").val());
		var critconfhdd           = encodeURIComponent($("#criticalhdd").val());
		var critconfhddtext       = encodeURIComponent($("#txtcriticalhddtext").val());
		var critconfcdrom         = encodeURIComponent($("#criticalcdrom").val());
		var critconfcdromtext     = encodeURIComponent($("#txtcriticalcdromtext").val());
		var critnwmake            = encodeURIComponent($("#criticalntwrkmake").val());
		var critnwspeed           = encodeURIComponent($("#criticalntwrkspeed").val());
		var critnwgateway         = encodeURIComponent($("#criticalntwrkgateway").val());
		var critpermake           = encodeURIComponent($("#criticalperipheralmake").val());
		var critpermodel          = encodeURIComponent($("#criticalperipheralmodel").val());
		var critperserno          = encodeURIComponent($("#criticalperipheralsrno").val());
		var critswos              = encodeURIComponent($("#criticalsoftwareos").val());
		var critswostext          = encodeURIComponent($("#txtcriticalsoftwareostext").val());
		var critswapplication     = encodeURIComponent($("#criticalsoftwareapp").val());
		var critswserno           = encodeURIComponent($("#criticalsoftwaresrno").val());
		var critotherconfig       = encodeURIComponent($("#criticalotherconfig").val());
		var critday               = ($("#criticalday").val());
		var critmonth             = ($("#criticalmonth").val());
		var crityear              = ($("#criticalyear").val());

		if (critdepartment == '-1') {
			$("#loader").hide();
            alert('Select department!');
			return;
		} else if (crithardware == '-1' ){
			$("#loader").hide();
            alert('Select hardware!');
			return;
		} else if (critname == '-1' ){
			$("#loader").hide();
            alert('Select name!');
			return;
		} else if (critname == '0' && critnametext == '' ){
			$("#loader").hide();
            alert('Enter name!');
			return;
		} else if (critassetcode == '-1' ){
			$("#loader").hide();
            alert('Select asset code!');
			return;
		} else if (critassetcodetext == '' ){
			$("#loader").hide();
            alert('Enter asset code!');
			return;
		} else if (critlocation == '-1' ){
			$("#loader").hide();
            alert('Select location!');
			return;
		} else if (critlocation == '0' && critlocationtext == '' ){
			$("#loader").hide();
            alert('Enter location!');
			return;
		} else if (critassetowner == '' ){
			$("#loader").hide();
            alert('Enter asset owner!');
			return;
		} else if (critmake == '-1' ){
			$("#loader").hide();
            alert('Select make!');
			return;
		} else if (critmodel == '-1' ){
			$("#loader").hide();
            alert('Select Model!');
			return;
		} else if (critserialno == '' ){
			$("#loader").hide();
            alert('Enter serial no.!');
			return;
		} else if (critipsubnet == '-1' ){
			$("#loader").hide();
            alert('Select IP/Subnet!');
			return;
		} else if (critipsubnet == '0' && critipsubnettext == ''){
			$("#loader").hide();
            alert('Enter IP/Subnet!');
			return;
		}else if (critipsubnet == '0' && critipsubnettext != '') {
			var splitipsubnet = critipsubnettext.split('/');
			if ((splitipsubnet.length) == 2) {
				if (!fnValidateIPAddress(splitipsubnet[0]) || !validateNetMask(splitipsubnet[1])){
					$("#loader").hide();
					alert('Enter valid IP/Subnet!');
					return;
				}
			} else {
				$("#loader").hide();
				alert('Enter vaild IP/Subnet!');
				return;
			}
		}
		if ($("#criticalconfig").is(":checked")) {
			var hasconfig = 1;
			if (critconfprocessor == '-1' ){
				$("#loader").hide();
				alert('Select processor!');
				return;
			} else if (critconfprocessor == '0' && critconfprocessortext == ''){
				$("#loader").hide();
				alert('Enter processor!');
				return;
			} else if (critconfram == '-1' ){
				$("#loader").hide();
				alert('Select ram!');
				return;
			} else if (critconfram == '0' && critconframtext == ''){
				$("#loader").hide();
				alert('Enter ram!');
				return;
			} else if (critconfhdd == '-1' ){
				$("#loader").hide();
				alert('Select hdd!');
				return;
			} else if (critconfhdd == '0' && critconfhddtext == ''){
				$("#loader").hide();
				alert('Enter hdd!');
				return;
			} else if (critconfcdrom == '-1' ){
				$("#loader").hide();
				alert('Select CDROM!');
				return;
			} else if (critconfcdrom == '0' && critconfcdromtext == ''){
				$("#loader").hide();
				alert('Enter CDROM!');
				return;
			}

			if (critconfprocessor == '0') {
				critconfprocessor = critconfprocessortext;
			}
			if (critconfram == '0') {
				critconfram = critconframtext;
			}
			if (critconfhdd == '0') {
				critconfhdd = critconfhddtext;
			}
			if (critconfcdrom == '0') {
				critconfcdrom = critconfcdromtext;
			}
		} else {
			var hasconfig = 0;
			critconfprocessor = 'NONE';
			critconfram       = 'NONE';
			critconfhdd       = 'NONE';
			critconfcdrom     = 'NONE';
		}
		
		if ($("#criticalntwrkcard").is(":checked")) {
			var hasnetwork = 1;
			if (critnwmake == '' ){
				$("#loader").hide();
				alert('Enter network make!');
				return;
			} else if (critnwspeed == '' ){
				$("#loader").hide();
				alert('Enter network speed!');
				return;
			} else if (critnwgateway == '' ){
				$("#loader").hide();
				alert('Enter network gateway!');
				return;
			} 
		} else {
			var hasnetwork = 0;
			critnwmake       = 'NONE';
			critnwspeed      = 'NONE';
			critnwgateway    = 'NONE';
		}
		
		if ($("#criticalperipheral").is(":checked")) {
			var hasperipheral = 1;
			if (critpermake == '' ){
				$("#loader").hide();
				alert('Enter peripheral make!');
				return;
			} else if (critpermodel == '' ){
				$("#loader").hide();
				alert('Enter peripheral model!');
				return;
			} else if (critperserno == '' ){
				$("#loader").hide();
				alert('Enter peripheral serial no.!');
				return;
			} 
		} else {
			var hasperipheral = 0;
			critpermake       = 'NONE';
			critpermodel      = 'NONE';
			critperserno      = 'NONE';
		}
		
		if ($("#criticalsoftware").is(":checked")) {
			var hassoftware = 1;
			if (critswos == '-1' ){
				$("#loader").hide();
				alert('Select s/w operating system!');
				return;
			} else if (critswos == '0' && critswostext == ''){
				$("#loader").hide();
				alert('Enter s/w operating system!');
				return;
			} else if (critswapplication == '' ){
				$("#loader").hide();
				alert('Enter s/w application!');
				return;
			} else if (critswserno == '' ){
				$("#loader").hide();
				alert('Enter s/w serial no.!');
				return;
			}
			
			if (critswos == '0') {
				critswos = critswostext;
			}
		} else {
			var hassoftware = 0;
			critswos          = 'NONE';
			critswapplication = 'NONE';
			critswserno       = 'NONE';
		}
		
		if (critotherconfig == '' ){
				$("#loader").hide();
				alert('Enter other configuration!');
				return;
		} else if (critday == '-1' ){
				$("#loader").hide();
				alert('Select issue date!');
				return;
		} else if (critmonth == '-1' ){
				$("#loader").hide();
				alert('Select issue month!');
				return;
		} else if (crityear == '-1' ){
				$("#loader").hide();
				alert('Select issue year!');
				return;
		}  
		
		if (critname == '0') {
			critname = critnametext;
		}
		if (critlocation == '0') {
			critlocation = critlocationtext;
		}
		if (critipsubnet == '0') {
			critipsubnet = critipsubnettext;
		}
		
	alldata = 'functype=newcriticalregistration&critdepartment='+critdepartment+'&crithardware='+crithardware+'&critname='+critname+
			  '&critassetcode='+critassetcode+'&critassetcodetext='+critassetcodetext+'&critlocation='+critlocation+
			  '&critassetowner='+critassetowner+'&critmake='+critmake+'&critmodel='+critmodel+
			  '&critserialno='+critserialno+'&critipsubnet='+critipsubnet+'&hasconfig='+hasconfig+'&critconfprocessor='+critconfprocessor+
			  '&critconfram='+critconfram+'&critconfhdd='+critconfhdd+'&critconfcdrom='+critconfcdrom+
			  '&hasnetwork='+hasnetwork+'&critnwmake='+critnwmake+'&critnwspeed='+critnwspeed+'&critnwgateway='+critnwgateway+
			  '&hasperipheral='+hasperipheral+'&critpermake='+critpermake+'&critpermodel='+critpermodel+'&critperserno='+critperserno+
			  '&hassoftware='+hassoftware+'&critswos='+critswos+'&critswapplication='+critswapplication+'&critswserno='+critswserno+
			  '&critotherconfig='+critotherconfig+'&critday='+critday+'&critmonth='+critmonth+'&crityear='+crityear; 

		$.ajax({
            url:"processrequest.php",
            type:"post",
			data:alldata,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('Critical asset has been inserted succesfully');
						window.location.reload();
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error inserting critical asset!');
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 105) {
					$("#loader").hide();
					alert('Security ! Reload page or try again later');
				} else if (result == 110) {
					$("#loader").hide();
					alert('Asset not available in stock');
				} else if (result == 111) {
					$("#loader").hide();
					alert('All asset has been alloted');
				} else if (result == 404) {
					$("#loader").hide();
					alert('Function not found');
				} else {
					$("#loader").hide();
					alert('Internal update error');
				}
            }
        })
	
	}
	
	

// js for critical asset |end|

});