
//configuration type other
function chk(row_value,row_number)
{
    if(row_value==0)
    {
      $("#other_config").show();  
    }
    else
    {
       $("#other_config").hide();  
    }
}

function hide_popup()
{
     $("body").css("overflow","auto");
     $("#loader").hide();
    $("#black_bg").fadeOut(100);
    $("#form-container").fadeOut(100);
}

$("document").ready(function(){
function currencyCheck(t) {
    var regex = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/;
	return regex.test(t);
}



// js for new stock form |start|
$("#txtaddhardware").change(function(){

	var hardwareid = $("#txtaddhardware").val();

	$("#txtaddprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
	$("#txtaddprintertype").append('<option value="0" >Other</option>');

	$("#txtaddmake").empty().append('<option value="-1" >----Select Make----</option>');
	$("#txtaddmake").append('<option value="0" >Other</option>');

	$("#txtaddmodel").empty().append('<option value="-1" >----Select Model----</option>');
	$("#txtaddmodel").append('<option value="0" >Other</option>');

	if (hardwareid == 15 || hardwareid == 16 || hardwareid == 17 ) { // DVD / MOUSE / KEYBOARD
		$("#txtaddmodel").empty().append('<option value="NONE" >NONE</option>');
		$("#txtaddmodel").attr('disabled', 'disabled');
		$("#txtaddmodel").val('0');
	}
	
	if (hardwareid == 3) { // printer
		$("#txtaddprintertype").removeAttr('disabled','disabled');
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtaddprintertype").empty().append('<option value="-1" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#txtaddprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#txtaddprintertype").append('<option value="0" >Other</option>');
				}
		});
	
	} else {
		$("#txtaddprintertype").attr('disabled','disabled');
		$("#txtaddprintertype").append('<option value="NONE" selected>NONE</option>');
	}

	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtaddmake").empty().append('<option value="-1" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#txtaddmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#txtaddmake").append('<option value="0" >Other</option>');
				}
			});
	}

    if (hardwareid == '0') {
        //$("#addhardwaretext").empty().append('<input type="text" name="txtaddhardwaretext" id="txtaddhardwaretext" value="" class="form-text" size="30" maxlength="2048">');
        $("#addhardwaretext").show();
    } else {
        //$("#addhardwaretext").empty();
        $("#addhardwaretext").hide();
    }

});

//printer type other
$("#txtaddprintertype").change(function(){
    if ($("#txtaddprintertype").val() == '0') {
        $("#addprintertypetext").show();
    } else {
        $("#addprintertypetext").hide();
    }
});

//make other
$("#txtaddmake").change(function(){
    if ($("#txtaddmake").val() == '0') {
        $("#addmaketext").show();
    } else {
        $("#addmaketext").hide();
    }
});

//model other
$("#txtaddmodel").change(function(){
    if ($("#txtaddmodel").val() == '0') {
        $("#addmodeltext").show();
    } else {
        $("#addmodeltext").hide();
    }
});

//Reset

$("#txtstockreset").click(function(){
	$("#addprintertypetext").hide();
	$("#addmaketext").hide()
	$("#addmodeltext").hide();
	$("#addhardwaretext").hide();
	$("#txtaddprintertype").removeAttr('disabled','disabled');	
});


	$("#newentry").live('click', function(){
		hz_newstockentry();
       
	});
	
	function hz_newstockentry() {
		$("#loader").show();
        var stockdepartment    = encodeURIComponent($("#txtadddepartment").val());
        var stockhardware      = encodeURIComponent($("#txtaddhardware").val());
        var stockaddhardware   = encodeURIComponent($("#txtaddhardwaretext").val());
        var stocktype          = encodeURIComponent($("#txtaddprintertype").val());
        var stockaddtype       = encodeURIComponent($("#txtaddprintertypetext").val());
        var stockmake          = encodeURIComponent($("#txtaddmake").val());
        var stockaddmake       = encodeURIComponent($("#txtaddmaketext").val());
        var stockmodel         = encodeURIComponent($("#txtaddmodel").val());
        var stockaddmodel      = encodeURIComponent($("#txtaddmodeltext").val());
        var stockinvoice       = encodeURIComponent($("#txtaddinvoice").val());
        var stockday           = $("#txtaddday").val();
        var stockmonth         = $("#txtaddmonth").val();
        var stockyear          = $("#txtaddyear").val();
        var stockpartyname     = encodeURIComponent($("#txtaddpartyname").val());
        var stockrcvrname      = encodeURIComponent($("#txtaddreceivername").val());
        var stockquantity      = ($("#txtaddquantity").val());
        var stockrate          = ($("#txtaddrate").val());
        var stockotherstatus   = encodeURIComponent($("#txtaddotherstatus").val());
        var stockentrytype     = encodeURIComponent($("#txtaddentrytype").val());
        var admin     = encodeURIComponent($("#admin_id").val());

	if (stockdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
        } else if (stockhardware == '-1') {
			$("#loader").hide();
            alert('Select hardware');
			return;
        } else if (stockhardware == 0 && stockaddhardware == '') {
			$("#loader").hide();
            alert('Enter Hardware');
			return;
        } else if (stockhardware == 3 && stocktype == '-1') {
			$("#loader").hide();
            alert('Select type');
			return;
        } else if (stockhardware == 3 && stocktype == 0 && stockaddtype == '') {
			$("#loader").hide();
            alert('Enter Type');
			return;
        } else if (stockmake == '-1') {
			$("#loader").hide();
            alert('Select make');
			return;
        } else if (stockmake == 0 && stockaddmake == '') {
			$("#loader").hide();
            alert('Enter Make');
			return;
        } else if (stockmodel == '-1') {
			$("#loader").hide();
            alert('Select model');
			return;
        } else if (stockmodel == 0 && stockaddmodel == '') {
			$("#loader").hide();
            alert('Enter Model');
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
		
        /*if (stockhardware == '0') {
            stockhardware = stockaddhardware;
        }

        if (stocktype == '0') {
            stocktype = stockaddtype;
        }

        if (stockmake == '0') {
            stockmake = stockaddmake;
        }
		*/
        if (stockmodel == 'NONE') {
            stockmodel = 0;
        }
        
        

      //apending input elements to hidden div
      $("#space_for_table").empty();
      $("#space_for_table").append('<legend>Enter product serial numbers:</legend>');
      if(stockhardware!=0)
      {
    	if (stockhardware == 3) {
    		var vardata ="functype=geteprintermodel&printertypeid=" + stocktype;
    	} else {
    		var vardata ="functype=getemodel&makeid=" + stockmake;
    	}
        var config_select="";
        $.ajax({
			    url:"getrequest.php",
			    type:"post",
				data:vardata,
				success: function(result) {
				var arr = $.parseJSON(result);
                
					$.each(arr, function(key,val){
						
						if (key == 'config') {
							config_select+='<option value="-1" >--Select Configuration--</option>';
							$.each(val, function(key,val){
								config_select+='<option value="'+key+'" >'+ val +'</option>';
                                
							});
                            config_select+='<option value="0" >Other</option>';
						}
					});
                   var table='<table>';
                   table+='<tr>';
                   table+='<th><div class="text-box-field" style="float:left;color:red;">CPU Serial #:</div></th><th><div class="text-box-field" style="float:left;color:red;" >Monitor Serial #:</div></th>';
                   table+='</tr>';
                   for(var i=1;i<=stockquantity;i++)
                      {
                      table+='<tr>'; 
                      table+='<td><div class="text-box-field"><input type="text" name="cpu_serial[]" id="cpu_serial_number_'+i+'"  class="form-text" size="30"/></div></td>';
                      if (stockhardware == 1) {
                    	  table+='<td><div class="text-box-field"><input type="text" name="m_serial[]" id="m_serial_number_'+i+'"  class="form-text" size="30"/></div></td>';
                      }
                      table+='</tr>';
                     }
                      table+='<tr><td colspan="2"><div class="text-box-field" style="float:left;color:red;width:170px;" >Configuration:</div></td></tr>'; 
                     table+='<tr>'; 
                     table+='<td><div ><select name="config" id="config" class="form-text" style="width:170px;margin-top:-6px;" onchange="return chk(this.value);" >'+config_select+'</select></div></td>';
                     table+='<td><div><input type="text" name="other_config" id="other_config"  class="form-text" size="30" style="display:none;margin-top:-6px;" /></div></td>';
                     table+='</tr>'; 
                    table+='</table>';
                    $("#space_for_table").append(table);
                    //$("#form-container").append('<div style="clear:both;text-align:center;"><input id="continue" type="button" name="continue" value="Continue" style="width:80px; height:30px;"/><div>' );

                      }
			});
      
        
        
      }
      else
      {
           for(var i=1;i<=stockquantity;i++)
          {
            
            $("#space_for_table").append('<div class="text-box-name">Serial #'+i+':</div><div class="text-box-field"><input type="text" name="serial[]" id="serial_number_'+i+'"  class="form-text" size="30"/></div>')
            
          }
          
          
      } 
      
      window.scroll(0,0);    
      $("body").css("overflow","hidden");
      $("#black_bg").fadeIn(600);
      $("#form-container").fadeIn("fast");
      
        
        
       myData = "functype=newstock&stockdepartment=" + stockdepartment + "&stockhardware=" + stockhardware + "&stockaddhardware=" + stockaddhardware + 
				  "&stocktype=" + stocktype + "&stockaddtype=" + stockaddtype + "&stockmake=" + stockmake + "&stockaddmake=" + stockaddmake +
				  "&stockmodel=" + stockmodel + "&stockaddmodel=" + stockaddmodel + "&stockinvoice=" + stockinvoice +
				  "&stockday=" + stockday + "&stockmonth=" + stockmonth +
				  "&stockyear=" + stockyear + "&stockpartyname=" + stockpartyname +
				  "&stockrcvrname=" + stockrcvrname + "&stockquantity=" + stockquantity +
				  "&stockrate=" + stockrate + "&stockotherstatus=" + stockotherstatus + "&stockentrytype=" + stockentrytype;
                  
                   
        $("#continue").click(function(){
            
            //var stockhardware      = encodeURIComponent($("#txtaddhardware").val());
            
            if(stockhardware!=0)
            {
                var configs1="";
                for(var i=1;i<=stockquantity;i++)
                  {
                    if($('#cpu_serial_number_'+i).val().length ==0)
                    {
                    $('#cpu_serial_number_'+i).focus();
                    $('#cpu_serial_number_'+i).css("border","red solid 1px");
                    return false;
                    }
                    else
                    {
                       $('#cpu_serial_number_'+i).css("border","#333 solid 1px"); 
                    }
                    if (stockhardware == 1){
	                    if($('#m_serial_number_'+i).val().length ==0)
	                    {
	                    $('#m_serial_number_'+i).focus();
	                    $('#m_serial_number_'+i).css("border","red solid 1px");
	                    return false;
	                    }
	                    else
	                    {
	                       $('#m_serial_number_'+i).css("border","#333 solid 1px"); 
	                    }
	                }
                     
                  }
                  
                  //config dropdown
                    if($('#config').val() =='-1')
                    {
                    $('#config'+i).focus();
                    $('#config').css("border","red solid 1px");
                    return false;
                    }
                    else  if($('#config').val() ==0)
                    {
                        if($('#other_config').val().length ==0)
                        {
                        $('#other_config').focus();
                        $('#other_config').css("border","red solid 1px");
                        return false;
                        }
                        else
                        {
                           $('#other_config').css("border","#333 solid 1px"); 
                           $('#config').css("border","#333 solid 1px"); 
                        }
                    }
                    else
                    {
                       $('#config').css("border","#333 solid 1px"); 
                       
                    } 
                 
              var serials = $('input[name^="cpu_serial"]').map(function() {
                              return this.value;
                            }).get();
                            
              var monitor_serials = $('input[name^="m_serial"]').map(function() {
                              return this.value;
                            }).get();
              
               var config = $("#config").val();
               var other = $("#other_config").val();                                        
               
              myData+="&cpu_serials="+serials+"&monitor_serials="+monitor_serials+"&config="+config+"&others="+other;
            }    
            else
            {
                for(var i=1;i<=stockquantity;i++)
                  {
                    if($('#serial_number_'+i).val().length ==0)
                    {
                    $('#serial_number_'+i).focus();
                    $('#serial_number_'+i).css("border","red solid 1px");
                    return false;
                    }
                    else
                    {
                       $('#serial_number_'+i).css("border","#333 solid 1px"); 
                    }
                  } 
                  
                var serials = $('input[name^="serial"]').map(function() {
                              return this.value;
                            }).get();
              myData+="&serials="+serials;
             } 
             myData += "&admin="+admin;
              console.log(myData);
              //return false;
              
          $.ajax({
            url:"processrequest.php",
            type:"post",
	    data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('New stock has been added succesfully!');
					window.location.reload();
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
        
        });
    }
// js for new stock form |end|

// js for new other stock form |start|
	$("#txtaddotherhardware").change(function(){

		var hardwareid = $("#txtaddotherhardware").val();

		$("#txtaddothermake").empty().append('<option value="-1" >----Select Make----</option>');
		$("#txtaddothermake").append('<option value="0" >Other</option>');

		$("#txtaddothermodel").empty().append('<option value="-1" >----Select Model----</option>');
		$("#txtaddothermodel").append('<option value="0" >Other</option>');

		if (hardwareid == 15 || hardwareid == 16 || hardwareid == 17 ) { // DVD / MOUSE / KEYBOARD
			$("#txtaddothermodel").append('<option value="NONE" >NONE</option>');
			$("#txtaddothermodel").attr('disabled', 'disabled');
			$("#txtaddothermodel").val('NONE');
		} else {
			$("#txtaddothermodel").removeAttr('disabled', 'disabled');
			$("#txtaddothermodel").val('-1');
		}

		if (hardwareid != 0) {
			$.ajax({
				url:"getrequest.php",
				type:"post",
				data:"functype=getemake&hardwareid=" + hardwareid,
				success: function(result) {
					var arr = $.parseJSON(result);
					$("#txtaddothermake").empty().append('<option value="-1" >----Select Make----</option>');
					$.each(arr, function(key,val){
						$("#txtaddothermake").append('<option value="'+key+'" >'+ val +'</option>');
					});
					$("#txtaddothermake").append('<option value="0" >Other</option>');
					/*$("#txtmake").append('<option value="NONE" >NONE</option>');*/
					}
				});
		}
		if (hardwareid == '0') {
			$("#addhardwaretext").show();
		} else {
			$("#addhardwaretext").hide();
		}
});

	//make other
	$("#txtaddothermake").change(function(){
		if ($("#txtaddothermake").val() == '0') {
			$("#addmaketext").show();
		} else {
			$("#addmaketext").hide();
		}
	});

	//model other
	$("#txtaddothermodel").change(function(){
		if ($("#txtaddothermodel").val() == '0') {
			$("#addmodeltext").show();
		} else {
			$("#addmodeltext").hide();
		}
	});

	//Reset

	$("#txtstockreset").click(function(){
		$("#addmaketext").hide()
		$("#addmodeltext").hide();
		$("#addhardwaretext").hide();
		$("#txtaddothermodel").removeAttr('disabled','disabled');	
		$("#txtaddothermodel").val('-1');	
	});

	$("#newotherentry").live('click', function(){
		hz_newotherstockentry();
	});
	
	function hz_newotherstockentry() {
		$("#loader").show();
        var stockdepartment    = encodeURIComponent($("#txtadddepartment").val());
        var stockhardware      = encodeURIComponent($("#txtaddotherhardware").val());
        var stockaddhardware   = encodeURIComponent($("#txtaddhardwaretext").val());
        var stockmake          = encodeURIComponent($("#txtaddothermake").val());
        var stockaddmake       = encodeURIComponent($("#txtaddmaketext").val());
        var stockmodel         = encodeURIComponent($("#txtaddothermodel").val());
        var stockaddmodel      = encodeURIComponent($("#txtaddmodeltext").val());
        var stockinvoice       = encodeURIComponent($("#txtaddinvoice").val());
        var stockday           = $("#txtaddday").val();
        var stockmonth         = $("#txtaddmonth").val();
        var stockyear          = $("#txtaddyear").val();
        var stockpartyname     = encodeURIComponent($("#txtaddpartyname").val());
        var stockrcvrname      = encodeURIComponent($("#txtaddreceivername").val());
        var stockquantity      = ($("#txtaddquantity").val());
        var stockrate          = ($("#txtaddrate").val());
        var stockotherstatus   = encodeURIComponent($("#txtaddotherstatus").val());

		if (stockdepartment == '-1') {
			$("#loader").hide();
            alert('Select department');
			return;
        } else if (stockhardware == '-1') {
			$("#loader").hide();
            alert('Select hardware');
			return;
        } else if (stockhardware == 0 && stockaddhardware == '') {
			$("#loader").hide();
            alert('Enter Hardware');
			return;
        } else if (stockhardware == 3 && stocktype == '-1') {
			$("#loader").hide();
            alert('Select type');
			return;
        } else if (stockhardware == 3 && stocktype == 0 && stockaddtype == '') {
			$("#loader").hide();
            alert('Enter Type');
			return;
        } else if (stockmake == '-1') {
			$("#loader").hide();
            alert('Select make');
			return;
        } else if (stockmake == 0 && stockaddmake == '') {
			$("#loader").hide();
            alert('Enter Make');
			return;
        } else if (stockmodel == '-1') {
			$("#loader").hide();
            alert('Select model');
			return;
        } else if (stockmodel == 0 && stockaddmodel == '') {
			$("#loader").hide();
            alert('Enter Model');
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
	
        /*if (stockhardware == '0') {
            stockhardware = stockaddhardware;
        }

        if (stocktype == '0') {
            stocktype = stockaddtype;
        }

        if (stockmake == '0') {
            stockmake = stockaddmake;
        }

        if (stockmodel == '0') {
            stockmodel = stockaddmodel;
        }*/

        myData = "functype=newotherstock&stockdepartment=" + stockdepartment + "&stockhardware=" + stockhardware + "&stockaddhardware=" + stockaddhardware + 
				  "&stockmake=" + stockmake + "&stockaddmake=" + stockaddmake +
				  "&stockmodel=" + stockmodel + "&stockaddmodel=" + stockaddmodel + "&stockinvoice=" + stockinvoice +
				  "&stockday=" + stockday + "&stockmonth=" + stockmonth +
				  "&stockyear=" + stockyear + "&stockpartyname=" + stockpartyname +
				  "&stockrcvrname=" + stockrcvrname + "&stockquantity=" + stockquantity +
				  "&stockrate=" + stockrate + "&stockotherstatus=" + stockotherstatus;
        $.ajax({
            url:"processrequest.php",
            type:"post",
			data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('New stock has been added succesfully!');
					window.location.reload();
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
// js for new other stock form |end|



//below scrap form handler
	$("#newscrap").live('click', function(){
		hz_scrapentry();
       
	});
    
    	function hz_scrapentry() {
		$("#loader").show();
       
        var hardware      = encodeURIComponent($("#txthardware").val());
        var make          = encodeURIComponent($("#txtmake").val());
        var model         = encodeURIComponent($("#txtmodel").val());
        var serial        = $("#txtcpuno").val();
        var reason        = encodeURIComponent($("#txtreason").val());
        var approved      = encodeURIComponent($("#txtapproved").val());
        
        
        
	if (hardware == '-1') {
			$("#loader").hide();
            alert('Select hardware');
			return;
        } else if (make == '-1') {
			$("#loader").hide();
            alert('Select Make');
			return;
        } else if (model=='-1') {
			$("#loader").hide();
            alert('Select Model');
			return;
        } else if (serial == '-1') {
			$("#loader").hide();
            alert('Select Serial');
			return;
        } else if (reason == '') {
			$("#loader").hide();
            alert('Enter Reason');
			return;
        } else if (approved == '') {
			$("#loader").hide();
            alert('Enter Approved By');
			return;
        } 
        
        
        myData = "functype=newscrap&hardware=" + hardware + "&make=" + make + "&model=" + model + 
				  "&serial=" + serial + "&reason=" + reason +
				  "&approved=" + approved ;
        $.ajax({
            url:"processor_extra.php",
            type:"post",
			data:myData,
            success: function(result) {
				if (result == 0) {
					$("#loader").hide();
					alert('New scrap has been added succesfully!mail sent');
					window.location.reload();
				} else if (result == 1) {
					$("#loader").hide();
					alert('New scrap has been added succesfully!mail not sent');
					window.location.reload();
				} else if (result == 101){
					$("#loader").hide();
					alert('Session expired! Login again');
					window.location = 'logout.php';
				} else if (result == 112){
					$("#loader").hide();
					alert('Asset is already scrapped or in waitig to approve from GM');
				} else if (result == 113){
					$("#loader").hide();
					alert('This asset is alloted to one of employee! You can\'t scrap it');
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



});