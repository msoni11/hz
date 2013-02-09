$("document").ready(function(){

	// get model
	$("#edittxtmake").change(function(){
		var makeid = $("#edittxtmake").val();
		var hwid = $("#edittxthardware").val();
		if (hwid != 3) {
			$("#edittxtmodel").empty().append('<option value="-1" >----Select Model----</option>');
			//$("#edittxtmodel").append('<option value="0" >Other</option>');
			//$("#edittxtmodel").append('<option value="NONE" >NONE</option>');
		}
		
		$("#edittxtconfig").empty().append('<option value="-1" >----Select Confiiguration----</option>');
		$("#edittxtconfig").append('<option value="0" >Other</option>');
		$("#edittxtconfig").append('<option value="NONE" >NONE</option>');

		if (makeid != 0 && makeid != 'NONE' && hwid != 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=getemodel&makeid=" + makeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$.each(arr, function(key,val){
						if (key == 'model') {
							$("#edittxtmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#edittxtmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
							//$("#edittxtmodel").append('<option value="0" >Other</option>');
							//$("#edittxtmodel").append('<option value="NONE" >NONE</option>');
						}

						if (key == 'config') {
							$("#edittxtconfig").empty().append('<option value="-1" >----Select Confiiguration----</option>');
							$.each(val, function(key,val){
								$("#edittxtconfig").append('<option value="'+val+'" >'+ val +'</option>');
							});
							$("#edittxtconfig").append('<option value="0" >Other</option>');
							$("#edittxtconfig").append('<option value="NONE" >NONE</option>');
						}
					});
				}
			});
		}
	});

	// get printer type
	$("#edittxtprintertype").change(function(){
		var printertypeid = $("#edittxtprintertype").val();
		var hwid = $("#edittxthardware").val();

		$("#edittxtmodel").empty().append('<option value="-1" >----Select Model----</option>');
		$("#edittxtmodel").append('<option value="0" >Other</option>');
		$("#edittxtmodel").append('<option value="NONE" >NONE</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=geteprintermodel&printertypeid=" + printertypeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$("#edittxtmodel").empty().append('<option value="-1" >----Select Model----</option>');
					$.each(arr, function(key,val){
						$("#edittxtmodel").append('<option value="'+key+'" >'+ val +'</option>');
					});
					//$("#edittxtmodel").append('<option value="0" >Other</option>');
					//$("#edittxtmodel").append('<option value="NONE" >NONE</option>');
				}
			});

			$.ajax({
				url:"getrequest.php",
				type:"post",
				data:"functype=checkIP&printertypeid=" + printertypeid,
				success: function(result) {
					var arr = $.parseJSON(result);
					if (arr['ip'] == 0) {
						$("#editipaddress").attr('disabled', 'disabled');
						$("#editipaddress").val('NONE');
					} else if (arr['ip'] == 1) {
						$("#editipaddress").removeAttr('disabled');
						$("#editipaddress").val('');
					}
				}
			});
		} else {
			$("#editipaddress").removeAttr('disabled');
			$("#editipaddress").val('');
		}
	});

	// check printer has IP or not
	/*$("#edittxtmodel").change(function(){
		var modelid = $("#edittxtmodel").val();
		var hwid = $("#edittxthardware").val();
		if (modelid != 0 && modelid != 'NONE' && hwid == 3) {
			$.ajax({
				url:"getrequest.php",
				type:"post",
				data:"functype=checkIP&modelid=" + modelid,
				success: function(result) {
					var arr = $.parseJSON(result);
					if (arr['ip'] == 0) {
						$("#editipaddress").attr('disabled', 'disabled');
						$("#editipaddress").val('NONE');
					} else if (arr['ip'] == 1) {
						$("#editipaddress").removeAttr('disabled');
						$("#editipaddress").val('');
					}
				}
			});
		} else {
			$("#editipaddress").removeAttr('disabled');
			$("#editipaddress").val('');
		}
	});*/

});
		