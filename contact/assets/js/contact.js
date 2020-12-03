$(function() {
	function validate_form() {
	
		var name = $("#form_name").val();
		var message = $("#form_message").val();
		var email = $("#form_email").val();
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	var ok = true;
		
		if (typeof name != "undefined" && name.length > 0) 
		{
			$("#control_name").removeClass("has-error");
			$("#control_name").addClass("has-success");
		}
		else
		{
			$("#control_name").removeClass("has-success");
			$("#control_name").addClass("has-error");
			ok = false;
		}
		
		if (typeof message != "undefined" && message.length > 0)
		{
			$("#control_message").removeClass("has-error");
			$("#control_message").addClass("has-success");
		}
		else
		{
			$("#control_message").removeClass("has-success");
			$("#control_message").addClass("has-error");
			ok = false;
		}
		
		if (typeof email != "undefined" && re.test(email))
		{
			$("#control_email").removeClass("has-error");
			$("#control_email").addClass("has-success");
		}
		else
		{
			$("#control_email").removeClass("has-success");
			$("#control_email").addClass("has-error");
			ok = false;	
		}
		
		if (ok)
		{
			$("#form_submit").prop('disabled', false);
		}
		else
		{
			$("#form_submit").prop('disabled', true);
		}
		
		return ok;
	}
	
	$("#form_name").on('input', function()
	{
		validate_form();
	});
	$("#form_message").on('input', function()
	{
		validate_form();
	});
	$("#form_email").on('input', function()
	{
		validate_form();
	});

	$("form").submit(function(e) {
		var captcha = grecaptcha.getResponse();
		if (captcha.length == 0) {
			$("#captcha-error").css("display", "block");
			e.preventDefault();
		}
	});
});