$("document").ready(function(){

$("#txtadddepartment").change(function(){
	$("#txtaddhardware").val('');
});

$("#txtaddhardware").change(function(){
	var hardwareid = encodeURIComponent($("#txtaddhardware").val());
	if (hardwareid == 'PRINTER') { // printer
		$("#txtaddprintertype").removeAttr('disabled','disabled');
		$.ajax({
		    url:"getrequestfilter.php",
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
		    url:"getrequestfilter.php",
		    type:"post",
			data:"functype=getemake&hardwareid=" + hardwareid,
			success: function(result) {
				var arr = $.parseJSON(result);
				$("#txtaddmake").empty().append('<option value="" >----Select Make----</option>');
				$.each(arr, function(key,val){
					$("#txtaddmake").append('<option value="'+key+'" >'+ val +'</option>');
				});
				}
			});
	}
});
	// get model in case of stock
	$("#txtaddmake").change(function(){
		var makeid = encodeURIComponent($("#txtaddmake").val());
		var hwid = encodeURIComponent($("#txtaddhardware").val());
		if (hwid != 'PRINTER') {
			$("#txtmodel").empty().append('<option value="" >----Select Model----</option>');
		}
		
		if (makeid != 0 && makeid != 'NONE' && hwid != 'PRINTER') {
			$.ajax({
			    url:"getrequestfilter.php",
			    type:"post",
				    data:"functype=getemodel&makeid=" + makeid + "&hwid=" + hwid,
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
		var printertypeid = encodeURIComponent($("#txtaddprintertype").val());
		var hwid = encodeURIComponent($("#txtaddhardware").val());

		$("#txtmodel").empty().append('<option value="" >----Select Model----</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 'PRINTER') {
			$.ajax({
			    url:"getrequestfilter.php",
			    type:"post",
				data:"functype=geteprintermodel&printertypeid=" + printertypeid + "&hwid=" + hwid,
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