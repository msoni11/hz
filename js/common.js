$("document").ready(function(){

	// get model by make
	$("#txtmake").change(function(){
		var makeid = $("#txtmake").val();
		var hwid = $("#txthardware").val();
		if (hwid != 3) {
			$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
			//$("#txtmodel").append('<option value="0" >Other</option>');
			//$("#txtmodel").append('<option value="NONE" >NONE</option>');
			$("#txtconfig").empty().append('<option value="-1" >----Select Configuration----</option>');
			$("#txtconfig").append('<option value="0" >Other</option>');
			$("#txtconfig").append('<option value="NONE" >NONE</option>');
			$("#configtext").empty();
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
							$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#txtmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
							/*$("#txtmodel").append('<option value="0" >Other</option>');
							$("#txtmodel").append('<option value="NONE" >NONE</option>');*/
						}

						if (key == 'config') {
							$("#txtconfig").empty().append('<option value="-1" >----Select Confiiguration----</option>');
							$.each(val, function(key,val){
								$("#txtconfig").append('<option value="'+val+'" >'+ val +'</option>');
							});
							$("#txtconfig").append('<option value="0" >Other</option>');
							$("#txtconfig").append('<option value="NONE" >NONE</option>');
						}
					});
				}
			});
		}
	});

	// get model by printer type
	$("#txtprintertype").change(function(){
		var printertypeid = $("#txtprintertype").val();
		var hwid = $("#txthardware").val();

		$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
		$("#txtmodel").append('<option value="0" >Other</option>');
		$("#txtmodel").append('<option value="NONE" >NONE</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=geteprintermodel&printertypeid=" + printertypeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$("#txtmodel").empty().append('<option value="-1" >----Select Model----</option>');
					$.each(arr, function(key,val){
						$("#txtmodel").append('<option value="'+key+'" >'+ val +'</option>');
					});
					$("#txtmodel").append('<option value="0" >Other</option>');
					$("#txtmodel").append('<option value="NONE" >NONE</option>');
				}
			});

			$.ajax({
				url:"getrequest.php",
				type:"post",
				data:"functype=checkIP&printertypeid=" + printertypeid,
				success: function(result) {
					var arr = $.parseJSON(result);
					if (arr['ip'] == 0) {
						$("#ipaddress").attr('disabled', 'disabled');
						$("#ipaddress").val('NONE');
					} else if (arr['ip'] == 1) {
						$("#ipaddress").removeAttr('disabled');
						$("#ipaddress").val('');
					}
				}
			});
		} else {
			$("#ipaddress").removeAttr('disabled');
			$("#ipaddress").val('');
		}
	});

	// get model in case of stock
	$("#txtaddmake").change(function(){
		var makeid = $("#txtaddmake").val();
		var hwid = $("#txtaddhardware").val();
		if (hwid != 3) {
			$("#txtaddmodel").empty().append('<option value="-1" >----Select Model----</option>');
			$("#txtaddmodel").append('<option value="0" >Other</option>');
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
							$("#txtaddmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#txtaddmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
							$("#txtaddmodel").append('<option value="0" >Other</option>');
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

		$("#txtaddmodel").empty().append('<option value="-1" >----Select Model----</option>');
		$("#txtaddmodel").append('<option value="0" >Other</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=geteprintermodel&printertypeid=" + printertypeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$("#txtaddmodel").empty().append('<option value="-1" >----Select Model----</option>');
					$.each(arr, function(key,val){
						$("#txtaddmodel").append('<option value="'+key+'" >'+ val +'</option>');
					});
					$("#txtaddmodel").append('<option value="0" >Other</option>');
				}
			});

			
		}
	});
	
	// get model in case of stock |Edit stock|
	$("#editstockmake").change(function(){
		var makeid = $("#editstockmake").val();
		var hwid = $("#editstockhardware").val();
		if (hwid != 3) {
			$("#editstockmodel").empty().append('<option value="-1" >----Select Model----</option>');
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
							$("#editstockmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#editstockmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
						}
					});
				}
			});
		}
	});

	// get model in case of printer selected |Edit stock|
	$("#editstockprintertype").change(function(){
		var printertypeid = $("#editstockprintertype").val();
		var hwid = $("#editstockhardware").val();

		$("#editstockmodel").empty().append('<option value="-1" >----Select Model----</option>');

		if (printertypeid != 0 && printertypeid != 'NONE' && hwid == 3) {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
				    data:"functype=geteprintermodel&printertypeid=" + printertypeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$("#editstockmodel").empty().append('<option value="-1" >----Select Model----</option>');
					$.each(arr, function(key,val){
						$("#editstockmodel").append('<option value="'+key+'" >'+ val +'</option>');
					});
				}
			});

			
		}
	});
	
	// get model in case of other it asset
	$("#txtotheritmake").change(function(){
		var makeid = $("#txtotheritmake").val();

		if (makeid != 0 && makeid != 'NONE') {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
			    data:"functype=getemodel&makeid=" + makeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$.each(arr, function(key,val){
						if (key == 'model') {
							$("#txtotheritmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#txtotheritmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
						}
					});
				}
			});
		}
	});
	
	// get model in case of other it asset stock
	$("#txtaddothermake").change(function(){
		var makeid = $("#txtaddothermake").val();
		var hwid = $("#txtaddotherhardware").val();

		if (makeid != 0 && (hwid == 13 || hwid == 14 ) && makeid != 'NONE') {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
			    data:"functype=getemodel&makeid=" + makeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$.each(arr, function(key,val){
						if (key == 'model') {
							$("#txtaddothermodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#txtaddothermodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
							$("#txtaddothermodel").append('<option value="0">Other</option>');
						}
					});
				}
			});
		}
	});
	
	// get model in case of critical asset
	$("#criticalmake").change(function(){
		var makeid = $("#criticalmake").val();
		//var hwid = $("#txtaddotherhardware").val();

		if (makeid != 0 && makeid != 'NONE') {
			$.ajax({
			    url:"getrequest.php",
			    type:"post",
			    data:"functype=getemodel&makeid=" + makeid,
				success: function(result) {
				var arr = $.parseJSON(result);
					$.each(arr, function(key,val){
						if (key == 'model') {
							$("#criticalmodel").empty().append('<option value="-1" >----Select Model----</option>');
							$.each(val, function(key,val){
								$("#criticalmodel").append('<option value="'+key+'" >'+ val +'</option>');
							});
							//$("#criticalmodel").append('<option value="0">Other</option>');
						}
					});
				}
			});
		}
	});
	

});		