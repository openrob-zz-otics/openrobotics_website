$(function() {

	function validate() {
		var last_name = $("#form_last_name").val();
		var first_name = $("#form_first_name").val();
		var email = $("#form_email").val();
		var password = $("#form_password").val();
		var password_check = $("#form_password_check").val();
		
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
		
		if(password.length >=6) {
			setSuccess("#control_password");
		} else {
			setError("#control_password", "Password must be at least of length 6.");
			isValidate = false;
		}
		
		if(password == password_check) {
			setSuccess("#control_password_check");
		} else {
			setError("#control_password_check", "Passwords must Match.");
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
	
	$("#form_last_name").on('input', function() {validate();});
	$("#form_first_name").on('input', function() {validate();});
	$("#form_email").on('input', function() {validate();});
	$("#form_password").on('input', function() {validate();});
	$("#form_password_check").on('input', function() {validate();});
});