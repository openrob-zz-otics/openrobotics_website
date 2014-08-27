$(function() {

	function validate() {

		var subject = $("#form_subject").val();
		var message = $("#form_message").val();

		var isValidate = true;

		if(subject.length > 0) {
			setSuccess("#control_subject");
		} else {
			setError("#control_subject", "Subject can not be blank.");
			isValidate = false;
		}
		
		if(message.length > 0) {
			setSuccess("#control_message");
		} else {
			setError("#control_message", "Message can not be blank.");
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

	$("#form_subject").on('input', function() {validate();});
	$("#form_message").on('input', function() {validate();});

});