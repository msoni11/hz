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
		$("#txtcpuno").attr('disabled', 'disabled');
		$("#txtcpuno").val('NONE');
		$("#txtcrtno").attr('disabled', 'disabled');
		$("#txtcrtno").val('NONE');
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
	} else if (hardwareid == 4 ) { // scanner
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
	}

	$("#txtcartage").empty().append('<option value="-1" >----Select Cartage----</option>');
	$("#txtcartage").append('<option value="0" >Other</option>');
	$("#txtcartage").append('<option value="NONE" selected >NONE</option>');

	$("#txtprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
	$("#txtprintertype").append('<option value="0" >Other</option>');
	$("#txtprintertype").append('<option value="NONE" selected >NONE</option>');

	$("#txtmake").empty().append('<option value="-1" >----Select Make----</option>');
	$("#txtmake").append('<option value="0" >Other</option>');
	$("#txtmake").append('<option value="NONE" >NONE</option>');

	$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
	$("#txtmodel").append('<option value="0" >Other</option>');
	$("#txtmodel").append('<option value="NONE" >NONE</option>');

	$("#txtconfig").empty().append('<option value="-1" >----Select Configuration----</option>');
	$("#txtconfig").append('<option value="0" >Other</option>');
	$("#txtconfig").append('<option value="NONE" >NONE</option>');
	
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
				$("#txtprintertype").append('<option value="0" >Other</option>');
				$("#txtprintertype").append('<option value="NONE" >NONE</option>');
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
					$("#txtcartage").append('<option value="'+val+'" >'+ val +'</option>');
				});
				$("#txtcartage").append('<option value="0" >Other</option>');
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
				$("#txtmake").append('<option value="0" >Other</option>');
				$("#txtmake").append('<option value="NONE" >NONE</option>');
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
    $("#txtregempid").live('blur', function(){
		hz_getEmployeeDetails();
    });

	function hz_getEmployeeDetails() {
		$("#loader").show();
		var reggetempid = $("#txtregempid").val();
		if (reggetempid == '') {
			$("#loader").hide();
            alert('Enter Employee ID !');
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
            alert('Employee ID should be Numeric !');
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
            alert('Employee Id should be of 6 digits only');
			$("#txtempname").val('');
			$("#txtunit").val('-1');
			$("#txtdepartment").val('-1');
			$("#txtdesignation").val('');
			$("#unittext").empty();
			$("#departmenttext").empty();
			$("#hideEmpDetails").hide();
			return;
		}
		$.ajax({
		    url:"processrequest.php",
		    type:"post",
			    data:"functype=getempdetails&reggetempid=" + reggetempid,
			success: function(result) {
				if (result == 102) {
					$("#loader").hide();
					alert("Id doesn't exist");
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
				$("#txtempname").val(arr['empname']);
				$("#txtunit").val(arr['unit']);
				if (($("#txtunit").val() == '-1') || ($("#txtunit").val() == null) || ($("#txtunit").val() == '')) {
					$("#txtunit").val(0);
					$("#unittext").empty().append('<input type="text" name="txtunittext" id="txtunittext" value="'+ arr['unit'] + '" class="form-text" size="30" maxlength="2048">');
				}

				$("#txtdepartment").val(arr['department']);
				if ($("#txtdepartment").val() == '-1' || ($("#txtdepartment").val() == null) || ($("#txtdepartment").val() == '')) {
					$("#txtdepartment").val(0);
					$("#departmenttext").empty().append('<input type="text" name="txtdepartmenttext" id="txtdepartmenttext" value="' + arr['department'] + '" class="form-text" size="30" maxlength="2048">');
				}
				$("#txtdesignation").val(arr['designation']);
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

        if (reghardware == '0') {
            reghardware = regtxthardware;
        }

        if (regcartage == '0') {
            regcartage = regtxtcartage;
        }

        if (regprintertype == '0') {
            regprintertype = regtxtprintertype;
        }

        if (regmake == '0') {
            regmake = regtxtmake;
        }

        if (regmodel == '0') {
            regmodel = regtxtmodel;
        }

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
					$("#txtntwrkdept").val('-1');
					$("#ntwrkdepttext").empty();
					$("#txtntwrkitem").val('');
					$("#txtntwrkmake").val('-1');
					$("#txtntwrkmodel").val('');
					$("#txtntwrkserial").val('');
					$("#txtntwrkquantity").val('');
					$("#txtntwrktype").val('');
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
		criticalhardwareid = $("#criticalhardware").val();
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getecriticalhardwarename&criticalhardwareid=" + criticalhardwareid,
			success: function(result) {
			var arr = $.parseJSON(result);
			console.log(arr);
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
			data:"functype=getecriticalmake&criticalhardwareid=" + criticalhardwareid,
			success: function(result) {
			var arr = $.parseJSON(result);
			console.log(arr);
				$("#criticalmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#criticalmake").append('<option value="'+val+'" >'+ val +'</option>');
				});
				$("#criticalmake").append('<option value="0" >Other</option>');
				/*$("#criticalhwname").append('<option value="NONE" >NONE</option>');*/
			}
		});
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
    
    }

// js for critical asset |end|

});