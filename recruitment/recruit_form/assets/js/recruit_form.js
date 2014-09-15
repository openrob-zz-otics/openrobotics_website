$(function() {
	$('h4[class="expand_tr"]').click(function() {
		if ($(event.target).is("input") || $(event.target).is("button"))
			return;
		var id = $(this).data("id");
		if ($(this).data("down") == "1") {
			$("#"+id).hide();
			$(this).data("down", "0");
			$("#"+id+"_Icon").toggleClass("glyphicon-chevron-up");
			$("#"+id+"_Icon").toggleClass("glyphicon-chevron-down");
		} else {
			$(this).data("down", "1");
			$("#"+id).show();
			$("#"+id+"_Icon").toggleClass("glyphicon-chevron-down");
			$("#"+id+"_Icon").toggleClass("glyphicon-chevron-up");
		}
	});
	
	$("#form_last_name").on('input', function() {validate();});
	$("#form_first_name").on('input', function() {validate();});
	$("#form_email").on('input', function() {validate();});
	$("#form_phone_number").on('input', function() {validate();});
	$("#form_year").on('input', function() {validate();});
	$("#form_major").on('input', function() {validate();});
	
	function validate() {
		var last_name = $("#form_last_name").val();
		var first_name = $("#form_first_name").val();
		var email = $("#form_email").val();
		var phone_number = $("#form_phone_number").val();
		var year = parseInt($("#form_year").val());
		var major = $("#form_major").val();	

		
		var isValidate = true;

		if(last_name.length >=2) {
			setSuccess("#control_last_name");
		} else {
			setError("#control_last_name", "Last name must be at least of length 2.");
			isValidate = false;
		}
		
		if(validateEmail(email)) {
			setSuccess("#control_email");
		} else {
			setError("#control_email", "Invalid Email");
			isValidate = false;
		}
		
		if(first_name.length >=2) {
			setSuccess("#control_first_name");
		} else {
			setError("#control_first_name", "First name must be at least of length 2.");
			isValidate = false;
		}
		
		if(phone_number.length >= 10) {
			setSuccess("#control_phone_number");
		} else {
			setError("#control_phone_number", "Please enter a 10 digit phone number.");
			isValidate = false;
		}

		if (year > 0) {
			setSuccess("#control_year");
		} else {
			setError("#control_year", "Please enter your year of studies.");
			isValidate = false;
		}

		if (major.length > 3) {
			setSuccess("#control_major");
		} else {
			setError("#control_major", "Please enter your major.");
			isValidate = false;
		}
		
		if (isValidate) {
			$("#form_submit").prop('disabled', false);
		} else {
			$("#form_submit").prop('disabled', true);		
		}
		
		return isValidate;
		
	}
	
	function setSuccess(control)  {
		$(control).removeClass("has-error");
		$(control).addClass("has-success");
		$(control+">.help-block").html("");
	}
	
	
	function setError(control,error)  {
		$(control).removeClass("has-success");
		$(control).addClass("has-error");
		$(control+">.help-block").html(error);
	}
	
	function validateEmail(email) {
		var emailReg = new RegExp("[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}");
		if(emailReg.test(email)) {
			return true;
		} else {
			return false;
		}
	}
});