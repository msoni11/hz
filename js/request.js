$("document").ready(function(){
  
  	$("#newrequest").live('click', function(){
		hz_request();
    });
    
    
    function hz_request() {
		$("#loader").show();
        var empid           = encodeURIComponent($("#txtempid").val());
        var empname         = encodeURIComponent($("#txtempname").val());
        var empdept         = encodeURIComponent($("#txtempdept").val());
        var empdesi         = encodeURIComponent($("#txtempdesi").val());
        var hardware        = $("#txthardware").val();
        var reason          = encodeURIComponent($("#txtreason").val());
        var assets_yes      = $("#have_assets_yes");
        var assets_no           = $("#have_assets_no");
        var executive           = $("#executive");
        var nonexecutive       = $("#nonexecutive");
       

	if (empid == '') {
			$("#loader").hide();
            alert('Enter Employee Username/ID');
            $("#txtempid").focus();
			return;
        } else if (empname == '') {
			$("#loader").hide();
            alert('Enter Employee Name');
            $("#txtempname").focus();
			return;
        } else if (empdept=='') {
			$("#loader").hide();
            alert('Enter Employee Department ');
			return;
        } else if (empdesi == '') {
			$("#loader").hide();
            alert('Enter Employee Designation');
			return;
        } else if (hardware == '-1') {
			$("#loader").hide();
            alert('Select Hardware');
            $("#txthardware").focus();
			return;
        } else if (reason == '') {
			$("#loader").hide();
            alert('Enter Reason/Purpose');
            $("#txtreason").focus();
			return;
        } else if(!$("input.have_assets:checked").val()) {
			$("#loader").hide();
            alert('Select Have Assets?');
			return;
        } else if(!$("input.executive:checked").val()) {
			$("#loader").hide();
            alert('Select Type');
			return;
        }
        
        myData = "functype=newrequest&empid=" + empid + "&empname=" + empname + "&empdept=" + empdept + 
				  "&empdesi=" + empdesi + "&hardware=" + hardware + "&reason=" + reason + "&have_assets=" + $("input.have_assets:checked").val() +
                  "&type="+$("input.executive:checked").val()+"&manager="+$("#manager").val();
				  
        console.log(myData);          
         $.ajax({
            url:"processor_for_user.php",
            type:"post",
	    data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('New Request has been added succesfully! Mail NOT Sent');
					//window.location.reload();
				}else if (result == 1){
					$("#loader").hide();
					alert('New Request has been added succesfully! Mail Sent');
					//window.location.reload();
				}  else if (result == 101){
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
 
 
 	$("#newTrequest").live('click', function(){
		hz_Trequest();
    });
    
    function hz_Trequest() {
		$("#loader").show();
        var empid           = encodeURIComponent($("#txtempid").val());
         var empname         = encodeURIComponent($("#txtempname").val());
        var empdept         = encodeURIComponent($("#txtempdept").val());
        var empdesi         = encodeURIComponent($("#txtempdesi").val());
       var hardware        = $("#txthardware").val();
        var serial        = $("#txtserial").val();
        var reason          = encodeURIComponent($("#txtreason").val());
        var email          = $("#txtempemailid").val();
        
        //requestors
        var rempid           = encodeURIComponent($("#requestor").val());
        var rname           = encodeURIComponent($("#requestorname").val());
        var rdept           = encodeURIComponent($("#requestordept").val());
        var rdesi           = encodeURIComponent($("#requestordesi").val());
        var rmail           = encodeURIComponent($("#receiverMail").val());
        var rmanagermail           = encodeURIComponent($("#receiverManager").val());
        
     

	if (empid == '') {
			$("#loader").hide();
            alert('Enter Employee Username/ID');
            $("#txtempid").focus();
			return;
        } else if (hardware == '-1') {
			$("#loader").hide();
            alert('Select Hardware');
            $("#txthardware").focus();
			return;
        } else if (serial == '-1') {
			$("#loader").hide();
            alert('Select Serial');
            $("#txtserial").focus();
			return;
        }
        else if(!isValidEmailAddress(email)) {
            $("#loader").hide();
            alert('Enter valid email');
            $("#txtempemailid").focus();
            return false;
            
        }else if (reason == '') {
			$("#loader").hide();
            alert('Enter Reasone');
            $("#txtreason").focus();
			return;
        } 
        
        myData = "functype=newtrequest&empid=" + empid+ "&empname=" + empname + "&empdept=" + empdept + 
				  "&empdesi=" + empdesi +"&hardware=" + hardware + "&reason=" + reason + "&serial=" + serial +
                  "&email="+email+"&manager="+$("#manager").val()+"&requestor="+rempid+"&requestorname="+rname+"&requestordept="+rdept+"&requestordesi="+rdesi
                  +"&rmail="+rmail+"&rmanagermail="+rmanagermail;
				  
        console.log(myData);          
         $.ajax({
            url:"processor_for_user.php",
            type:"post",
	    data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('New Request has been added succesfully! Mail NOT Sent');
					//window.location.reload();
				}else if (result == 1 || result == 2){
					$("#loader").hide();
					alert('New Request has been added succesfully! Mail Sent');
					//window.location.reload();
				}  else if (result == 101){
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
 
 
	function isValidEmailAddress(emailAddress) {
	    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
	    return pattern.test(emailAddress);
	};


	$("#txthardware").change(function(){
        var hardware= $("#txthardware").val();
      
        $.ajax({
            url:"processor_for_user.php",
            type:"post",
           data:"functype=getserials&hardware="+hardware,
           success: function(result)
           {
            	var arr = $.parseJSON(result);
                $("#txtserial").empty().append('<option value="-1" >----Select Serial Number----</option>');
               
                $.each(arr,function(key,val){
                    $("#txtserial").append('<option value="'+key+'" >'+ val +'</option>');
                });
           }
           
        });
        
    });

    $("#txtempid").live('blur', function(){
		hz_getAnmEmployeeDetails();
    });

	function hz_getAnmEmployeeDetails() {
		$("#loader").show();
		var reggetempid = $("#txtempid").val();
		if (reggetempid == '') {
			$("#loader").hide();
            alert('Enter Employee Username please!');
			$("#txtempiddesc").val('');
			$("#txtempname").val('');
			$("#txtempdept").val('');
			$("#txtempdesi").val('');
			return;
		}
		$.ajax({
		    url:"processor_for_user.php",
		    type:"post",
			data:"functype=getuserinfo&reggetempid="+reggetempid,
			success: function(result) {
				if (result == 103) {
					$("#loader").hide();
					alert("User doesn't exist");
					$("#txtempiddesc").val('');
					$("#txtempname").val('');
					$("#txtempdept").val('');
					$("#txtempdesi").val('');
					$("#hideEmpDetails").hide();
				} else if (result == 101) {
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 105) {
					$("#loader").hide();
					alert('Security ! Reload page or try again later');
				} else if (result == 109) {
					$("#loader").hide();
					alert('Missing ldap info! You must login again');
					window.location = 'logout.php';
				} else if (result == 404) {
					$("#loader").hide();
					alert('Function not found');
				} else {
					$("#loader").hide();
					var arr = $.parseJSON(result);
					if ($('#requestor').val() == arr['empiddesc']) {
					    alert('You are not allowed to transfer request to yourself');
						$("#txtempid").val('');
						$("#txtempiddesc").val('');
						$("#txtempname").val('');
						$("#txtempdept").val('');
						$("#txtempdesi").val('');
						$("#hideEmpDetails").hide();
					    return;
					} else {
						$("#hideEmpDetails").show();
						$("#txtempname").val(arr['empname'])
										.attr('disabled', 'disabled');
						$("#txtempiddesc").val(arr['empiddesc'])
											 .attr('disabled', 'disabled');
						$("#txtempdept").val(arr['department'])
										   .attr('disabled', 'disabled');
						$("#txtempdesi").val(arr['designation'])
										    .attr('disabled', 'disabled');
						$("#receiverMail").val(arr['empmail']);
                        $("#txtempemailid").val(arr['empmail']);
						$("#receiverManager").val(arr['mgrmail']);
					}
				}
			}
		});
	}
    
});