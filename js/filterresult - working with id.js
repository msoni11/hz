$("document").ready(function(){

$("#txtadddepartment").change(function(){
	$("#txtaddhardware").val('');
});

$("#txtaddhardware").change(function(){
	var hardwareid = $("#txtaddhardware").val();
	if (hardwareid == 3) { // printer
		$("#txtaddprintertype").removeAttr('disabled','disabled');
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=geteprintertype&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtaddprintertype").empty().append('<option value="" >----Select Printer Type----</option>');
				$.each(arr, function(key,val){
					$("#txtaddprintertype").append('<option value="'+key+'" >'+ val +'</option>');
				});
				}
		});
	
	} else {
		$("#txtaddprintertype").attr('disabled','disabled');
		$("#txtaddprintertype").empty().append('<option value="" >----Select Printer Type----</option>');
	}

	if (hardwareid != 0) {
		$.ajax({
		    url:"getrequest.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtaddmake").empty().append('<option value="" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#txtaddmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				$("#txtaddmake").append('<option value="0" >Other</option>');
				}
			});
	}
});
	// get model in case of stock
	$("#txtaddmake").change(function(){
		var makeid = $("#txtaddmake").val();
		var hwid = $("#txtaddhardware").val();
		if (hwid != 3) {
			$("#txtmodel").empty().append('<option value="" >----Select Model----</option>');
		}
		
		if (makeid != 0 && makeid != 'NONE' && hwid != 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=getemodel&makeid=" + makeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$.each(arr, function(key,val){
						if (key == 'model') {
							$("#txtaddmodel").empty().append('<option value="" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#txtaddmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
						}
					});
				}
			});
		}
	});

	// get model in case of printer selected
	$("#txtaddprintertype").change(function(){
		var printertypeid = $("#txtaddprintertype").val();
		var hwid = $("#txtaddhardware").val();

		$("#txtmodel").empty().append('<option value="" >----Select Model----</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				data:"functype=geteprintermodel&printertypeid=" + printertypeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$("#txtaddmodel").empty().append('<option value="" >----Select Model----</option>');
					$.each(arr, function(key,val){
						$("#txtaddmodel").append('<option value="'+key+'" >'+ val +'</option>');
					});
				}
			});

			
		}
	});
	
});		