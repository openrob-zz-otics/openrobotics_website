$(function() {

	function validate() {

		var email = $("#form_email").val();

		var isValidate = true;

		if(validateEmail(email)) {
			setSuccess("#control_email");
		} else {
			setError("#control_email", "Invalid Email");
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

	$("#form_email").on('input', function() {validate();});
});