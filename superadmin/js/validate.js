$("document").ready(function(){
	function hasWhiteSpace(s) {
	  return /\s/g.test(s);
	}
// js for new user form |start|
    $("#newuserbtn").live('click', function(){
		hz_newuser();
    });
	function hz_newuser(){
		$("#loader").show();
		var uname     = $.trim($("#txtusername").val());
        var password    = $.trim($("#txtpassword").val());
        var adlocation    = encodeURIComponent(($.trim($("#txtlocation").val())));
        if (uname == '') {
			$("#loader").hide();
            alert('Enter valid username');
			return;
        } else if(hasWhiteSpace(uname)) {
			$("#loader").hide();
            alert('Username is not valid');
			return;
        } else if (password == '') {
			$("#loader").hide();
            alert('Enter valid password');
			return;
        } else if (adlocation == '-1') {
			$("#loader").hide();
            alert('Select location');
			return;
		}
		
		 $.ajax({
            url:"processor.php",
            type:"post",
		    data:"functype=newuser&uname=" + uname + "&password=" + password + "&location=" + adlocation,
            success: function(result) {
                if (result == 0) {
					$("#loader").hide();
					alert('new admin added');
					//window.location.reload();
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

});