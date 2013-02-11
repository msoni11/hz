$("document").ready(function(){
    
    
        $("#newIP").live("click", function(){
             if (validateIPAddress($("#start").val()) && validateIPAddress($("#end").val())    ){
                       var startarr  = $("#start").val().split(".");
                       var endarr  = $("#end").val().split(".");
                       if(startarr[0]== endarr[0] && startarr[1]== endarr[1] && startarr[2]== endarr[2])
                       {
                        alert("Good Range");
                        myData = "functype=addips&start="+$("#start").val()+"&end="+$("#end").val();
                            $.ajax({
                                url:"processor_extra.php",
                                type:"post",
                    	    data:myData,
                                success: function(result) {
                    				if (result == 0) {
                    					$("#loader").hide();
                    					alert('New Request has been added succesfully! Mail NOT Sent');
                    					//window.location.reload();
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
                       else
                       {
                        alert("Bad Range");
                       }
                     }
                     else{
                        
                       alert("Bad IP Address!");
                     }
        });
        
        
        function validateIPAddress(inputString) {

             //create reqular expression to validate that the
             //format of the string is at least correct
             var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;
            
             //test the input string against the regular expression
             if (re.test(inputString)) {
            
               //now, validate the separate parts
               var parts = inputString.split(".");
               if (parseInt(parseFloat(parts[0])) == 0) {
                 return false;
               }
               for (var i=0; i<parts.length; i++) {
                 if (parseInt(parseFloat(parts[i])) > 255) {
                   return false;
                 }
               }
               return true;
             }
             else {
               return false;
             }
            }
});