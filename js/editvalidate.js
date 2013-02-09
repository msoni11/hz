$("document").ready(function(){
function currencyCheck(t) {
    var regex = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/;
	return regex.test(t);
}

// js for edit employee form |start|
$("#edittxtunit").change(function(){
    if ($("#edittxtunit").val() == '0') {
        $("#editunittext").show();
    } else {
        $("#editunittext").hide();
    }
});

$("#edittxtdepartment").change(function(){
    if ($("#edittxtdepartment").val() == '0') {
       $("#editdepartmenttext").show();
    } else {
        $("#editdepartmenttext").hide();
    }
});
$("#txtempreset").click(function(){
    $("#unittext").empty();
    $("#departmenttext").empty();
});

$("#editempbtn").live('click', function(){
	hz_editemployee();
});
function hz_editemployee() {
		$("#loader").show();
        var empid          = $.trim($("#edittxtempid").val());
        var empname        = encodeURIComponent($("#edittxtempname").val());
        var unit           = encodeURIComponent($("#edittxtunit").val());
        var department     = encodeURIComponent($("#edittxtdepartment").val());
        var designation    = encodeURIComponent($("#edittxtdesignation").val());
        var unittext       = encodeURIComponent($("#edittxtunittext").val());
        var departmenttext = encodeURIComponent($("#edittxtdepartmenttext").val());

        if (empid == '') {
			$("#loader").hide();
            alert('Security! Employee id missing or changed');
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
            url:"editrequest.php",
            type:"post",
		    data:"functype=editemployee&empid=" + empid + "&empname=" + empname + "&unit=" + unit + "&department=" + department + "&designation=" + designation,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Employee records updated succesfully!');
					window.location = 'lists/listEmployee.php';
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Can\'t edit! Entry missing or deleted before');
					window.location.reload();
				} else if (result == 103){
					$("#loader").hide();
					alert('Error updating employee records! Try again later');
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

// js for user registration form |start|
$("#edittxthardware").change(function(){

	var hardwareid = $("#edittxthardware").val();

	if (hardwareid == 2) { // laptop
		$("#editipaddress").removeAttr('disabled');
		$("#editipaddress").val('');
		$("#edittxtmonitor1").attr('disabled', 'disabled');
		$("#edittxtmonitor1").val('NONE');
		$("#edittxtcpuno").attr('disabled', 'disabled');
		$("#edittxtcpuno").val('NONE');
		$("#edittxtcrtno").attr('disabled', 'disabled');
		$("#edittxtcrtno").val('NONE');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	} else if (hardwareid == 3 ) { // printer
		$("#edittxtcpuno").removeAttr('disabled', 'disabled');
		$("#edittxtcpuno").val('');
		$("#edittxtmonitor1").attr('disabled', 'disabled');
		$("#edittxtmonitor1").val('NONE');
		$("#edittxtcrtno").attr('disabled', 'disabled');
		$("#edittxtcrtno").val('NONE');
		$("#edittxtoffice").attr('disabled', 'disabled');
		$("#edittxtoffice").val('NONE');
		$("#edittxtlicense").attr('disabled', 'disabled');
		$("#edittxtlicense").val('NONE');
		$("#edittxtinternet").attr('disabled', 'disabled');
		$("#edittxtinternet").val('NONE');
		$("#txtconfig").attr('disabled', 'disabled');
		$("#txtconfig").val('NONE');
	} else if (hardwareid == 4 ) { // scanner
		$("#edittxtcpuno").removeAttr('disabled', 'disabled');
		$("#edittxtcpuno").val('');
		$("#edittxtmonitor1").attr('disabled', 'disabled');
		$("#edittxtmonitor1").val('NONE');
		$("#edittxtcrtno").attr('disabled', 'disabled');
		$("#edittxtcrtno").val('NONE');
		$("#edittxtoffice").attr('disabled', 'disabled');
		$("#edittxtoffice").val('NONE');
		$("#edittxtlicense").attr('disabled', 'disabled');
		$("#edittxtlicense").val('NONE');
		$("#edittxtinternet").attr('disabled', 'disabled');
		$("#edittxtinternet").val('NONE');
		$("#editipaddress").attr('disabled', 'disabled');
		$("#editipaddress").val('NONE');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	} else {
		$("#edittxtmonitor1").val('-1');
		$("#edittxtmonitor1").removeAttr('disabled');
		$("#edittxtcrtno").val('');
		$("#edittxtcrtno").removeAttr('disabled');
		$("#edittxtoffice").val('-1');
		$("#edittxtoffice").removeAttr('disabled');
		$("#edittxtlicense").val('');
		$("#edittxtlicense").removeAttr('disabled');
		$("#edittxtinternet").val('YES');
		$("#edittxtinternet").removeAttr('disabled');
		$("#editipaddress").val('');
		$("#editipaddress").removeAttr('disabled');
		$("#edittxtcpuno").val('');
		$("#edittxtcpuno").removeAttr('disabled', 'disabled');
		$("#txtconfig").removeAttr('disabled', 'disabled');
		$("#txtconfig").val('-1');
	}

	$("#edittxtcartage").empty().append('<option value="-1" >----Select Cartage----</option>');
	$("#edittxtcartage").append('<option value="0" >Other</option>');
	$("#edittxtcartage").append('<option value="NONE" selected >NONE</option>');

	$("#edittxtprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
	//$("#edittxtprintertype").append('<option value="0" >Other</option>');
	$("#edittxtprintertype").append('<option value="0" selected >NONE</option>');

	$("#edittxtmake").empty().append('<option value="-1" >----Select Make----</option>');
	//$("#edittxtmake").append('<option value="0" >Other</option>');
	//$("#edittxtmake").append('<option value="NONE" >NONE</option>');

	$("#edittxtmodel").empty().append('<option value="-1" >----Select Model----</option>');
	//$("#edittxtmodel").append('<option value="0" >Other</option>');
	//$("#edittxtmodel").append('<option value="NONE" >NONE</option>');

	$("#edittxtconfig").empty().append('<option value="-1" >----Select Confiiguration----</option>');
	$("#edittxtconfig").append('<option value="0" >Other</option>');
	$("#edittxtconfig").append('<option value="NONE" >NONE</option>');

	if (hardwareid == 3) {
		$("#editcartagediv").show();
		$("#editprintertypediv").show();
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#edittxtprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#edittxtprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				//$("#edittxtprintertype").append('<option value="0" >Other</option>');
				//$("#edittxtprintertype").append('<option value="NONE" >NONE</option>');
				}
		});
	
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getecartage&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#edittxtcartage").empty().append('<option value="-1" >----Select Cartage----</option>');
				$.each(arr, function(key,val){
					$("#edittxtcartage").append('<option value="'+val+'" >'+ val +'</option>');
				});
				$("#edittxtcartage").append('<option value="0" >Other</option>');
				$("#edittxtcartage").append('<option value="NONE" >NONE</option>');
				}
		});
	} else {
		$("#editcartagediv").hide();
		$("#editprintertypediv").hide();
	}
	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#edittxtmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#edittxtmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				//$("#edittxtmake").append('<option value="0" >Other</option>');
				//$("#edittxtmake").append('<option value="NONE" >NONE</option>');
				}
			});
	}

	if (hardwareid == '0') {
		$("#edithwtext").show();
	} else {
		$("#edithwtext").hide();
	}
});

//cartage other
$("#edittxtcartage").change(function(){
    if ($("#edittxtcartage").val() == '0') {
        $("#editcartagetext").show();
    } else {
        $("#editcartagetext").hide();
    }
});

//printer type other
$("#edittxtprintertype").change(function(){
    if ($("#edittxtprintertype").val() == '0') {
        $("#editprintertypetext").show();
    } else {
        $("#editprintertypetext").hide();
    }
});

//make other
$("#edittxtmake").change(function(){
    if ($("#edittxtmake").val() == '0') {
        $("#editmaketext").show();
    } else {
        $("#editmaketext").hide();
    }
});

//model other
$("#edittxtmodel").change(function(){
    if ($("#edittxtmodel").val() == '0') {
        $("#editmodeltext").show();
    } else {
        $("#editmodeltext").hide();
    }
});

//configuration other
$("#edittxtconfig").change(function(){
    if ($("#edittxtconfig").val() == '0') {
        $("#editconfigtext").show();
    } else {
        $("#editconfigtext").hide();
    }
});

//IT asset other
$("#edittxtasset").change(function(){
        $("#edittxtassettext").val('');
});

// AMC/WAR
$("#edittxtamc").change(function(){
    if ($("#edittxtamc").val() == 'AMC') {
	$("#editvendor").show();
	$("#editwarrdate").hide();
    } else if ($("#edittxtamc").val() == 'WAR') {
	$("#editvendor").hide();
	$("#editwarrdate").show();
    }

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

    $("#editregbtn").live('click', function(){
		hz_editregistration();
    });
	function hz_editregistration() {
		$("#loader").show();
		var regid          = $.trim($("#txtregid").val());
		var regempid       = $.trim($("#txtregempid").val());
		var reghardware    = encodeURIComponent($("#edittxthardware").val());
		var reghardwaretext = encodeURIComponent($("#edittxthwtext").val());
		var regcartage     = encodeURIComponent($("#edittxtcartage").val());
		var regtxtcartage  = encodeURIComponent($("#edittxtcartagetext").val());
		var regprintertype = encodeURIComponent($("#edittxtprintertype").val());
		var regtxtprintertype = encodeURIComponent($("#edittxtprintertypetext").val());
		var regmake        = encodeURIComponent($("#edittxtmake").val());
		var regmaketext    = encodeURIComponent($("#edittxtmaketext").val());
		var regmodel       = encodeURIComponent($("#edittxtmodel").val());
		var regtxtmodel    = encodeURIComponent($("#edittxtmodeltext").val());
		var regcpuno       = encodeURIComponent($("#edittxtcpuno").val());
		var regmonitor     = encodeURIComponent($("#edittxtmonitor1").val());
		var regcrtno       = encodeURIComponent($("#edittxtcrtno").val());
		var regconfig      = encodeURIComponent($("#edittxtconfig").val());
		var regtxtconfig   = encodeURIComponent($("#edittxtconfigtext").val());
		var regasset       = $("#edittxtasset").val();
		var regassettext   = encodeURIComponent($("#edittxtassettext").val());
		var regip          = $("#editipaddress").val();
		var regoffice      = $("#edittxtoffice").val();
		var reglicense     = encodeURIComponent($("#edittxtlicense").val());
		var reginternet    = encodeURIComponent($("#edittxtinternet").val());
		var regamc         = $("#edittxtamc").val();
		var regday         = $("#edittxtday").val();
		var regmonth       = $("#edittxtmonth").val();
		var regyear        = $("#edittxtyear").val();
		var regotherasset  = encodeURIComponent($("#edittxtotheritasset").val());
		var regstatus      = encodeURIComponent($.trim($("#edittxtregstatus").val()));

		if (regamc == 'AMC') {
			var regvendor         = $("#txteditvendor").val();
		} else if (regamc == 'WAR') {
			var regwarnday         = $("#txteditwarnday").val();
			var regwarnmonth       = $("#txteditwarnmonth").val();
			var regwarnyear        = $("#txteditwarnyear").val();
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
		} else if (reghardware == '-1') {
			$("#loader").hide();
            alert('Select Hardware !');
			return;
		} else if (reghardware == '0' && reghardwaretext == '') {
			$("#loader").hide();
            alert('Enter Hardware !');
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
		} else if (regmake == '0' && regmaketext == '') {
			$("#loader").hide();
            alert('Enter Make !');
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

		/*if (reghardware == 0) {
			reghardware = reghardwaretext;
		}*/

		if (regcartage == 0) {
		    regcartage = regtxtcartage;
		}

		/*if (regprintertype == 0) {
		    regprintertype = regtxtprintertype;
		}

		if (regmake == 0) {
			regmake = regmaketext;
		}

		if (regmodel == 0) {
		    regmodel = regtxtmodel;
		}*/

		if (regconfig == 0) {
		    regconfig = regtxtconfig;
		}
		
	if (regamc == 'AMC') {
		editAllData = "functype=editregistration&regid=" + regid + "&regempid=" + regempid + "&reghardware=" + reghardware + 
			"&regcartage=" + regcartage + "&regprintertype=" + regprintertype + "&regmake=" + regmake + "&regmodel=" + regmodel + "&regcpuno=" + regcpuno + 
			"&regmonitor=" + regmonitor + "&regcrtno=" + regcrtno + "&regconfig=" + regconfig + 
			"&regasset=" + regasset + "&regassettext=" + regassettext +"&regip=" + regip+ "&regoffice=" + regoffice+ 
			"&reglicense=" + reglicense+ "&reginternet=" + reginternet+ "&regamc=" + regamc  + "&regvendor=" + regvendor +
			"&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regotherasset=" + regotherasset+
			"&regstatus=" + regstatus
	} else 	if (regamc == 'WAR') {
		editAllData = "functype=editregistration&regid=" + regid + "&regempid=" + regempid + "&reghardware=" + reghardware + 
			"&regcartage=" + regcartage + "&regprintertype=" + regprintertype + "&regmake=" + regmake + "&regmodel=" + regmodel + "&regcpuno=" + regcpuno + 
			"&regmonitor=" + regmonitor + "&regcrtno=" + regcrtno + "&regconfig=" + regconfig + 
			"&regasset=" + regasset + "&regassettext=" + regassettext +"&regip=" + regip+ "&regoffice=" + regoffice+ 
			"&reglicense=" + reglicense+ "&reginternet=" + reginternet+ "&regamc=" + regamc + "&regwarnday=" + regwarnday + "&regwarnmonth=" + regwarnmonth +
			"&regwarnyear=" + regwarnyear + "&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regotherasset=" + regotherasset+
			"&regstatus=" + regstatus
	}

	$.ajax({
            url:"editrequest.php",
            type:"post",
		    data:editAllData,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('IT Asset record(s) updated');
					window.location = 'lists/listAsset.php';
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error updating user entry!');
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Can\'t update! serious error! Try again later');
					//window.location.reload();
				} else if(result == 105){
					$("#loader").hide();
					alert('Error! Reload page or try again later');
					window.location.reload();
				} else if (result == 110) {
					$("#loader").hide();
					alert('Asset not available in stock');
				} else if (result == 111) {
					$("#loader").hide();
					alert('You can\'t allot!! All asset has been alloted');
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
$("#edittxtntwrkdept").change(function(){
    if ($("#edittxtntwrkdept").val() == '0') {
        $("#editntwrkdepttext").show();
    } else {
        $("#editntwrkdepttext").hide();
    }
});
$("#edittxtntwrkmake").change(function(){
    if ($("#edittxtntwrkmake").val() == '0') {
        $("#editntwrkmaketext").show();
    } else {
        $("#editntwrkmaketext").hide();
    }
});

    $("#editnetworkbtn").live('click', function(){
		hz_editnetwork();
    });
	function hz_editnetwork() {
		$("#loader").show();
		var id                = $("#edittxtntwrkhiddenid").val();
		var ntwdepartment     = encodeURIComponent($("#edittxtntwrkdept").val());
		var ntwdepartmenttext = encodeURIComponent($("#editntwrktxtdepttext").val());
		var ntwitem           = encodeURIComponent($("#edittxtntwrkitem").val());
		var ntwmake           = encodeURIComponent($("#edittxtntwrkmake").val());
		var ntwmaketext       = encodeURIComponent($("#edittxtntwrkmaketext").val());
		var ntwmodel          = encodeURIComponent($("#edittxtntwrkmodel").val());
		var ntwserial         = encodeURIComponent($("#edittxtntwrkserial").val());
		var ntwquantity       = $("#edittxtntwrkquantity").val();
		var ntwtype           = encodeURIComponent($("#edittxtntwrktype").val());
		var ntwamc            = $("#edittxtamc").val();

		if (ntwamc == 'AMC') {
			var ntwvendor         = $("#txteditvendor").val();
		} else if (ntwamc == 'WAR') {
			var ntwwarnday         = $("#txteditwarnday").val();
			var ntwwarnmonth       = $("#txteditwarnmonth").val();
			var ntwwarnyear        = $("#txteditwarnyear").val();
		}

		if (ntwdepartment == '-1') {
			$("#loader").hide();
            alert('Select department!');
			return;
		} else if (ntwdepartment=='0' && ntwdepartmenttext == '') {
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
		} else if (ntwmake=='0' && ntwmaketext == '') {
			$("#loader").hide();
            alert('Enter make!');
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
		editAllData = "functype=editnetwork&id=" + id + "&ntwdepartment=" + ntwdepartment + "&ntwitem=" + ntwitem + "&ntwmake=" + ntwmake + "&ntwmodel=" + ntwmodel + "&ntwserial=" + ntwserial+ "&ntwquantity=" + ntwquantity + "&ntwtype=" + ntwtype + "&ntwamc=" + ntwamc + "&ntwvendor=" + ntwvendor;
	} else if (ntwamc == 'WAR') {
		editAllData = "functype=editnetwork&id=" + id + "&ntwdepartment=" + ntwdepartment + "&ntwitem=" + ntwitem + "&ntwmake=" + ntwmake + "&ntwmodel=" + ntwmodel + "&ntwserial=" + ntwserial+ "&ntwquantity=" + ntwquantity + "&ntwtype=" + ntwtype + "&ntwamc=" + ntwamc + "&ntwwarnday=" + ntwwarnday + "&ntwwarnmonth=" + ntwwarnmonth + "&ntwwarnyear=" + ntwwarnyear;
	}

	$.ajax({
            url:"editrequest.php",
            type:"post",
		    data:editAllData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Network has updated succesfully!');
					window.location = "lists/listNetwork.php";
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Can\'t update! error! Try again later');
				} else if (result == 105){
					$("#loader").hide();
					alert('Security alert! Try again later');
					window.location = 'logout.php';
				} else if (result == 103){
					$("#loader").hide();
					alert('Error updating network! Try again later');
				} else if (result == 404){
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

// js tp delete employee |start|
    $(".deleteemp").live('click', function(){
		var $this = $(this);
		var delempid = $this.children('.delempid').val();
		conf = confirm("Are you sure you want to delete this employee?");
		if (conf) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deleteemployee&delempid=" + delempid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('Employee has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 102){
						$this.children('.loader').hide();
						alert('You can\'t delete! User has a IT Asset!');
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting employee! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('Employee id not found! Its been removed earlier');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete employee |end|

// js tp delete registration |start|
    $(".deletereg").live('click', function(){
		var $this = $(this);
		var delregid = $this.children('.delregid').val();
		confdelreg = confirm("Are you sure you want to delete this registration?");
		if (confdelreg) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deleteregistration&delregid=" + delregid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('IT Asset has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting IT Asset! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('IT Asset not found! Its been removed earlier');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete registration |end|

// js tp delete other registration |start|
    $(".deleteotherreg").live('click', function(){
		var $this = $(this);
		var delregid = $this.children('.delotherregid').val();
		confdelreg = confirm("Are you sure you want to delete this registration?");
		if (confdelreg) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deleteotherregistration&delregid=" + delregid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('IT Asset has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting IT Asset! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('IT Asset not found! Its been removed earlier');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete other registration |end|

// js tp delete critical registration |start|
    $(".deletecriticalreg").live('click', function(){
		var $this = $(this);
		var delregid = $this.children('.delcriticalregid').val();
		confdelreg = confirm("Are you sure you want to delete critical registration?");
		if (confdelreg) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deletecriticalregistration&delregid=" + delregid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('Critical Asset has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting Critical Asset! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('Critical Asset not found! Its been removed earlier');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete critical registration |end|


// js tp transfer registration |start|
    $(".transferreg").live('click', function(){
		var $this = $(this);
		var transferregid = $this.children('.transferregid').val();
		conftransferreg = confirm("Are you sure you want to transfer this registration?");
		if (conftransferreg) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=transferregistration&transferregid=" + transferregid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('IT Asset has been transfered!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error transfering IT Asset! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('IT Asset not found! Its been transfered earlier');
					} else if (result == 110){
						$this.children('.loader').hide();
						alert('This is not a transferred stock');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp transfer registration |end|

// js tp delete network |start|
    $(".deletentwrk").live('click', function(){
		var $this = $(this);
		var delntwrkid = $this.children('.delntwrkid').val();
		confntwrk = confirm("Are you sure you want to delete network?");
		if (confntwrk) {
		$this.children('.loader').show();
			$.ajax({
				url:"../editrequest.php",
				type:"post",
				data:"functype=deletenetwork&delntwrkid=" + delntwrkid,
				success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('Network has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 102){
						$this.children('.loader').hide();
						alert('Can\'t delete! error! Try again later');
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting network! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('Network id not found! Its been removed earlier');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});

// js for new stock form |start|

// js for edit stock form |start|
$("#editstockhardware").change(function(){
	var hardwareid = $("#editstockhardware").val();
	$("#editstockprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');

	$("#editstockmake").empty().append('<option value="-1" >----Select Make----</option>');

	$("#editstockmodel").empty().append('<option value="-1" >----Select Model----</option>');

	if (hardwareid == 3) { // printer
		$("#editstockprintertype").removeAttr('disabled','disabled');
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#editstockprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#editstockprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#editstockprintertype").append('<option value="0" >Other</option>');
				}
		});
	
	} else {
		$("#editstockprintertype").attr('disabled','disabled');
		$("#editstockprintertype").append('<option value="0" selected>NONE</option>');
	}

	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#editstockmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#editstockmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#editstockmake").append('<option value="0" >Other</option>');
				}
			});
	}
});

	$("#editstockbtn").live('click', function(){
		hz_editstock();
    });
	function hz_editstock() {
		$("#loader").show();
		var id                  = $("#editstockhiddenid").val();
		var stockdepartment     = encodeURIComponent($("#editstockdept").val());
		var stockhardware       = encodeURIComponent($("#editstockhardware").val());
		var stocktype           = encodeURIComponent($("#editstockprintertype").val());
		var stockmake           = encodeURIComponent($("#editstockmake").val());
		var stockmodel          = encodeURIComponent($("#editstockmodel").val());
		var stockinvoice        = encodeURIComponent($("#editstockinvoice").val());
		var stockday            = ($("#editstockday").val());
		var stockmonth          = ($("#editstockmonth").val());
		var stockyear           = ($("#editstockyear").val());
		var stockpartyname      = encodeURIComponent($("#editstockpartyname").val());
		var stockrcvrname       = encodeURIComponent($("#editstockreceivername").val());
		var stockquantity       = $("#editstockquantity").val();
		var stockrate           = $("#editstockrate").val();
		var stockotherstatus    = encodeURIComponent($("#editstockotherstatus").val());
        var stockentrytype     = encodeURIComponent($("#editstockentrytype").val());

 
	if (stockdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
        } else if (stockhardware == '-1') {
			$("#loader").hide();
            alert('Select hardware');
			return;
        } else if (stockhardware == 3 && stocktype == '-1') {
			$("#loader").hide();
            alert('Select type');
			return;
        } else if (stockmake == '-1') {
			$("#loader").hide();
            alert('Select make');
			return;
        } else if (stockmodel == '-1') {
			$("#loader").hide();
            alert('Select model');
			return;
        } else if (stockinvoice == '') {
			$("#loader").hide();
            alert('Enter Invoice no');
			return;
        } else if (stockday == '-1') {
			$("#loader").hide();
            alert('Select day');
			return;
        } else if (stockmonth == '-1') {
			$("#loader").hide();
            alert('Select month');
			return;
        } else if (stockyear == '-1') {
			$("#loader").hide();
            alert('Select year');
			return;
        } else if (stockpartyname == '') {
			$("#loader").hide();
            alert('Enter Party Name');
			return;
        } else if (stockrcvrname == '') {
			$("#loader").hide();
            alert('Enter Receiver Name');
			return;
        } else if (stockquantity == '') {
			$("#loader").hide();
            alert('Enter Quantity');
			return;
        } else if (isNaN(stockquantity)) {
			$("#loader").hide();
            alert('Quantity should be numeric');
			return;
        } else if (stockrate == '') {
			$("#loader").hide();
            alert('Enter Rate');
			return;
        } else if (!currencyCheck(stockrate)) {
			$("#loader").hide();
            alert('Please check the rate you entered');
			return;
        } else if (stockotherstatus == '') {
			$("#loader").hide();
            alert('Enter Other Status');
			return;
        } else if (stockentrytype == '') {
			$("#loader").hide();
            alert('Select stock entry type');
			return;
        }
	
        editAllData = "functype=editstock&id="+ id +"&stockdepartment=" + stockdepartment + "&stockhardware=" + stockhardware + 
				  "&stocktype=" + stocktype + "&stockmake=" + stockmake + 
				  "&stockmodel=" + stockmodel +  "&stockinvoice=" + stockinvoice +
				  "&stockday=" + stockday + "&stockmonth=" + stockmonth +
				  "&stockyear=" + stockyear + "&stockpartyname=" + stockpartyname +
				  "&stockrcvrname=" + stockrcvrname + "&stockquantity=" + stockquantity +
				  "&stockrate=" + stockrate + "&stockotherstatus=" + stockotherstatus + "&stockentrytype=" + stockentrytype;

	$.ajax({
            url:"editrequest.php",
            type:"post",
		    data:editAllData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Stock has updated succesfully!');
					window.location = "lists/listStock.php";
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Can\'t update! error! Try again later');
				} else if (result == 105){
					$("#loader").hide();
					alert('Security alert! Try again later');
					//window.location = 'logout.php';
				} else if (result == 103){
					$("#loader").hide();
					alert('Error updating stock! Try again later');
				} else if (result == 111){
					$("#loader").hide();
					alert('You can\'t edit! You have alloted more asset than the quantity you are updating');
				} else if (result == 404){
					$("#loader").hide();
					alert('Function not found');
				} else {
					$("#loader").hide();
					alert('Internal update error');
				}
            }
        });
	}
// js for edit stock form |end|

// js tp delete stock |start|
    $(".deletestock").live('click', function(){
		var $this = $(this);
		var delstockid = $this.children('.delstockid').val();
		conf = confirm("Are you sure you want to delete Stock entry?");
		if (conf) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deletestock&delstockid=" + delstockid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('Stock record has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting stock! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('Stock id not found! Its been removed earlier');
					} else if (result == 111){
						$this.children('.loader').hide();
						alert('You can\'t delete! This hardware is alloted to one of employee');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete stock |end|

// js for edit other stock form |start|
$("#editotherstockhardware").change(function(){
	var hardwareid = $("#editotherstockhardware").val();
	$("#editotherstockprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');

	$("#editotherstockmake").empty().append('<option value="-1" >----Select Make----</option>');

	$("#editotherstockmodel").empty().append('<option value="-1" >----Select Model----</option>');

	if (hardwareid == 3) { // printer
		$("#editotherstockprintertype").removeAttr('disabled','disabled');
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#editotherstockprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#editotherstockprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#editotherstockprintertype").append('<option value="0" >Other</option>');
				}
		});
	
	} else {
		$("#editotherstockprintertype").attr('disabled','disabled');
		$("#editotherstockprintertype").append('<option value="0" selected>NONE</option>');
	}

	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#editotherstockmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#editotherstockmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#editotherstockmake").append('<option value="0" >Other</option>');
				}
			});
	}
});

	$("#editotherstockbtn").live('click', function(){
		hz_editotherstock();
    });
	function hz_editotherstock() {
		$("#loader").show();
		var id                  = $("#editotherstockhiddenid").val();
		var stockdepartment     = encodeURIComponent($("#editotherstockdept").val());
		var stockhardware       = encodeURIComponent($("#editotherstockhardware").val());
		var stockmake           = encodeURIComponent($("#editotherstockmake").val());
		var stockmodel          = encodeURIComponent($("#editotherstockmodel").val());
		var stockinvoice        = encodeURIComponent($("#editotherstockinvoice").val());
		var stockday            = ($("#editotherstockday").val());
		var stockmonth          = ($("#editotherstockmonth").val());
		var stockyear           = ($("#editotherstockyear").val());
		var stockpartyname      = encodeURIComponent($("#editotherstockpartyname").val());
		var stockrcvrname       = encodeURIComponent($("#editotherstockreceivername").val());
		var stockquantity       = $("#editotherstockquantity").val();
		var stockrate           = $("#editotherstockrate").val();
		var stockotherstatus    = encodeURIComponent($("#editotherstockotherstatus").val());

	if (stockdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
        } else if (stockhardware == '-1') {
			$("#loader").hide();
            alert('Select hardware');
			return;
        } else if (stockhardware == 3 && stocktype == '-1') {
			$("#loader").hide();
            alert('Select type');
			return;
        } else if (stockmake == '-1') {
			$("#loader").hide();
            alert('Select make');
			return;
        } else if (stockmodel == '-1') {
			$("#loader").hide();
            alert('Select model');
			return;
        } else if (stockinvoice == '') {
			$("#loader").hide();
            alert('Enter Invoice no');
			return;
        } else if (stockday == '-1') {
			$("#loader").hide();
            alert('Select day');
			return;
        } else if (stockmonth == '-1') {
			$("#loader").hide();
            alert('Select month');
			return;
        } else if (stockyear == '-1') {
			$("#loader").hide();
            alert('Select year');
			return;
        } else if (stockpartyname == '') {
			$("#loader").hide();
            alert('Enter Party Name');
			return;
        } else if (stockrcvrname == '') {
			$("#loader").hide();
            alert('Enter Receiver Name');
			return;
        } else if (stockquantity == '') {
			$("#loader").hide();
            alert('Enter Quantity');
			return;
        } else if (isNaN(stockquantity)) {
			$("#loader").hide();
            alert('Quantity should be numeric');
			return;
        } else if (stockrate == '') {
			$("#loader").hide();
            alert('Enter Rate');
			return;
        } else if (!currencyCheck(stockrate)) {
			$("#loader").hide();
            alert('Please check the rate you entered');
			return;
        } else if (stockotherstatus == '') {
			$("#loader").hide();
            alert('Enter Other Status');
			return;
        }
	
        editAllData = "functype=editotherstock&id="+ id +"&stockdepartment=" + stockdepartment + "&stockhardware=" + stockhardware + 
				  "&stockmake=" + stockmake + 
				  "&stockmodel=" + stockmodel +  "&stockinvoice=" + stockinvoice +
				  "&stockday=" + stockday + "&stockmonth=" + stockmonth +
				  "&stockyear=" + stockyear + "&stockpartyname=" + stockpartyname +
				  "&stockrcvrname=" + stockrcvrname + "&stockquantity=" + stockquantity +
				  "&stockrate=" + stockrate + "&stockotherstatus=" + stockotherstatus;

	$.ajax({
            url:"editrequest.php",
            type:"post",
		    data:editAllData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('Stock record has been updated!');
					window.location = "lists/listConsumableStock.php";
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 102){
					$("#loader").hide();
					alert('Can\'t update! error! Try again later');
				} else if (result == 105){
					$("#loader").hide();
					alert('Security alert! Try again later');
					//window.location = 'logout.php';
				} else if (result == 103){
					$("#loader").hide();
					alert('Error updating stock! Try again later');
				} else if (result == 111){
					$("#loader").hide();
					alert('You can\'t edit! You have alloted more asset than the quantity you are updating');
				} else if (result == 404){
					$("#loader").hide();
					alert('Function not found');
				} else {
					$("#loader").hide();
					alert('Internal update error');
				}
            }
        });
	}
// js for edit other stock form |end|

// js tp delete other stock |start|
    $(".deleteotehrstock").live('click', function(){
		var $this = $(this);
		var delotherstockid = $this.children('.delotherstockid').val();
		conf = confirm("Are you sure you want to delete Stock entry?");
		if (conf) {
			$this.children('.loader').show();
			$.ajax({
			    url:"../editrequest.php",
			    type:"post",
				    data:"functype=deleteotherstock&delotherstockid=" + delotherstockid,
			    success: function(result) {
					if (result == 0) {
						$this.children('.loader').hide();
						alert('Stock record has been deleted!');
						window.location.reload();
					} else if (result == 101){
						$this.children('.loader').hide();
						alert('Session expired! Login again');
						window.location = 'logout.php';
					} else if (result == 105){
						$this.children('.loader').hide();
						alert('Security alert! Try again later');
						window.location = 'logout.php';
					} else if (result == 103){
						$this.children('.loader').hide();
						alert('Error deleting stock! Try again later');
					} else if (result == 107){
						$this.children('.loader').hide();
						alert('Stock id not found! Its been removed earlier');
					} else if (result == 111){
						$this.children('.loader').hide();
						alert('You can\'t delete! This hardware is alloted to one of employee');
					} else if (result == 404){
						$this.children('.loader').hide();
						alert('Function not found');
					} else {
						$this.children('.loader').hide();
						alert('Internal update error');
					}
				}
			});
		} else {
			return false;
		}
	});
// js tp delete other stock |end|

// js for edit critical asset |start|

	$("#criticalhardware").change(function(){
		hardwareid = $("#criticalhardware").val();
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getecriticalhardwarename&hardwareid=" + hardwareid,
			success: function(result) {
			var arr = $.parseJSON(result);
				$("#editcriticalhwname").empty().append('<option value="-1" >----Select Name----</option>');
				$.each(arr, function(key,val){
					$("#editcriticalhwname").append('<option value="'+val+'" >'+ val +'</option>');
				});
				$("#editcriticalhwname").append('<option value="0" >Other</option>');
			}
		});

	if (hardwareid == '7' || hardwareid == '11') { //Router & Core switch
		$("#editcriticalipsubnet").attr('disabled','disabled');
		$("#editcriticalipsubnet").val('NONE');
	} else {
		$("#editcriticalipsubnet").removeAttr('disabled','disabled');
		$("#editcriticalipsubnet").val('-1');
	}
	});

	//Name
	$("#editcriticalhwname").change( function() {
		if ($("#editcriticalhwname").val() == '0') {
			$("#editcriticalnametext").show();
		} else {
			$("#editcriticalnametext").hide();
		}
	});

	//critical asset
	$("#editcriticalasset").change( function() {
		if ($("#editcriticalasset").val() != '-1') {
			$("#editcriticalassettext").show();
		} else {
			$("#editcriticalassettext").hide();
		}
	});
	
	//Location
	$("#editcriticallocation").change( function() {
		if ($("#editcriticallocation").val() == '0') {
			$("#editcriticallocationtext").show();
		} else {
			$("#editcriticallocationtext").hide();
		}
	});

	//IP/Subnet
	$("#editcriticalipsubnet").change( function() {
		if ($("#editcriticalipsubnet").val() == '0') {
			$("#editcriticalipsubnettext").show();
		} else {
			$("#editcriticalipsubnettext").hide();
		}
	});

	/*Configuration*/
	//Processor
	$("#editcriticalprocessor").change( function() {
		if ($("#editcriticalprocessor").val() == '0') {
			$("#editcriticalprocessortext").show();
		} else {
			$("#editcriticalprocessortext").hide();
		}
	});

	//Ram
	$("#editcriticalram").change( function() {
		if ($("#editcriticalram").val() == '0') {
			$("#editcriticalramtext").show();
		} else {
			$("#editcriticalramtext").hide();
		}
	});

	//HDD
	$("#editcriticalhdd").change( function() {
		if ($("#editcriticalhdd").val() == '0') {
			$("#editcriticalhddtext").show();
		} else {
			$("#editcriticalhddtext").hide();
		}
	});

	//CDROM
	$("#editcriticalcdrom").change( function() {
		if ($("#editcriticalcdrom").val() == '0') {
			$("#editcriticalcdromtext").show();
		} else {
			$("#editcriticalcdromtext").hide();
		}
	});
	
	//Software
	//operating System
	$("#editcriticalsoftwareos").change( function() {
		if ($("#editcriticalsoftwareos").val() == '0') {
			$("#editcriticalsoftwareostext").show();
		} else {
			$("#editcriticalsoftwareostext").hide();
		}
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


	$("#editcriticalassetbtn").live('click', function(){
		hz_editcriticalasset();
	});
		
	function hz_editcriticalasset() {
		$("#loader").hide();
		var criticalid  	      = $.trim($("#txtcriticalid").val());
		var critdepartment        = encodeURIComponent($("#criticaldept").val());
		var crithardware          = encodeURIComponent($("#criticalhardware").val());
		var critname              = encodeURIComponent($("#editcriticalhwname").val());
		var critnametext          = encodeURIComponent($("#txtcriticalnametext").val());
		var critassetcode         = encodeURIComponent($("#editcriticalasset").val());
		var critassetcodetext     = encodeURIComponent($("#txtcriticalassettext").val());
		var critlocation          = encodeURIComponent($("#editcriticallocation").val());
		var critlocationtext      = encodeURIComponent($("#txtcriticallocationtext").val());
		var critassetowner        = encodeURIComponent($("#criticalassetowner").val());
		var critmake              = encodeURIComponent($("#criticalmake").val());
		var critmodel             = encodeURIComponent($("#criticalmodel").val());
		var critserialno          = encodeURIComponent($("#criticalserialno").val());
		var critipsubnet          = ($("#editcriticalipsubnet").val());
		var critipsubnettext      = ($("#txtcriticalipsubnettext").val());
		var critconfprocessor     = encodeURIComponent($("#editcriticalprocessor").val());
		var critconfprocessortext = encodeURIComponent($("#txtcriticalprocessortext").val());
		var critconfram           = encodeURIComponent($("#editcriticalram").val());
		var critconframtext       = encodeURIComponent($("#txtcriticalramtext").val());
		var critconfhdd           = encodeURIComponent($("#editcriticalhdd").val());
		var critconfhddtext       = encodeURIComponent($("#txtcriticalhddtext").val());
		var critconfcdrom         = encodeURIComponent($("#editcriticalcdrom").val());
		var critconfcdromtext     = encodeURIComponent($("#txtcriticalcdromtext").val());
		var critnwmake            = encodeURIComponent($("#criticalntwrkmake").val());
		var critnwspeed           = encodeURIComponent($("#criticalntwrkspeed").val());
		var critnwgateway         = encodeURIComponent($("#criticalntwrkgateway").val());
		var critpermake           = encodeURIComponent($("#criticalperipheralmake").val());
		var critpermodel          = encodeURIComponent($("#criticalperipheralmodel").val());
		var critperserno          = encodeURIComponent($("#criticalperipheralsrno").val());
		var critswos              = encodeURIComponent($("#editcriticalsoftwareos").val());
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
		
	alldata = 'functype=editcriticalregistration&criticalid='+criticalid+'&critdepartment='+critdepartment+'&crithardware='+crithardware+'&critname='+critname+
			  '&critassetcode='+critassetcode+'&critassetcodetext='+critassetcodetext+'&critlocation='+critlocation+
			  '&critassetowner='+critassetowner+'&critmake='+critmake+'&critmodel='+critmodel+
			  '&critserialno='+critserialno+'&critipsubnet='+critipsubnet+'&hasconfig='+hasconfig+'&critconfprocessor='+critconfprocessor+
			  '&critconfram='+critconfram+'&critconfhdd='+critconfhdd+'&critconfcdrom='+critconfcdrom+
			  '&hasnetwork='+hasnetwork+'&critnwmake='+critnwmake+'&critnwspeed='+critnwspeed+'&critnwgateway='+critnwgateway+
			  '&hasperipheral='+hasperipheral+'&critpermake='+critpermake+'&critpermodel='+critpermodel+'&critperserno='+critperserno+
			  '&hassoftware='+hassoftware+'&critswos='+critswos+'&critswapplication='+critswapplication+'&critswserno='+critswserno+
			  '&critotherconfig='+critotherconfig+'&critday='+critday+'&critmonth='+critmonth+'&crityear='+crityear; 

		$.ajax({
            url:"editrequest.php",
            type:"post",
			data:alldata,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('Critical asset has been updated succesfully');
						window.location = 'lists/listCriticalAsset.php';
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error updating critical asset!');
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
					alert('You can\'t allot!! All asset has been alloted');
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
	
	

// js for edit critical asset |end|

// js for edit other itasset form |start|

    $("#editotherregbtn").live('click', function(){
	hz_newotherregistration();
    });
	function hz_newotherregistration() {
		$("#loader").show();
		var regid          = $.trim($("#txtregid").val());
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

		var allData = "functype=editotherregistration&regid=" + regid +"&regempid=" + regempid + "&regempname=" + regempname +
				"&regunit=" + regunit + "&regdepartment=" + regdepartment + "&regdesignation=" + regdesignation + 
				"&reghardware=" + reghardware + "&regmake=" + regmake + "&regmodel=" + regmodel + "&regrcvrname=" + regrcvrname +  
				"&regday=" + regday + "&regmonth=" + regmonth + "&regyear=" + regyear + "&regissuedby=" + regissuedby+
				"&regstatus=" + regstatus;

		$.ajax({
            url:"editrequest.php",
            type:"post",
			data:allData,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('IT Asset has been updated succesfully');
					window.location = 'lists/listConsumable.php';
				} else if (result == 103) {
					$("#loader").hide();
					alert('Error updating IT asset!');
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

// js for edit other itasset form |end|

	
});