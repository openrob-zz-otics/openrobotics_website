$(function() {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "/manage/profile/assets/cgi/profile.php?task=0"
	}).done(function(data) {
		$("#form_first_name").val(data.first_name);
		$("#form_middle_name").val(data.middle_name);
		$("#form_last_name").val(data.last_name);
		$("#form_contact_email").val(data.contact_email);
		$("#form_linkedin").val(data.linkedin);
		$("#form_personal_site").val(data.personal_site);
		$("#form_education").val(data.education);
		$("#form_employment").val(data.employment);
		$("#form_bio").html(data.bio);
	});
	
	function verify() {
		var first_name = $("#form_first_name").val();
		var middle_name = $("#form_middle_name").val();
		var last_name = $("#form_last_name").val();
		var contact_email = $("#form_contact_email").val();
		var linkedin = $("#form_linkedin").val();
		var personal_site = $("#form_personal_site").val();
		var education = $("#form_education").val();
		var employment = $("#form_employent").val();
		var bio = $("#form_bio").html();
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	var success = true;
		
		if (first_name.length < 2) {
			success = false;
			$("#control_first_name").removeClass("has-success");
			$("#control_first_name").addClass("has-error");
		} else {
			$("#control_first_name").addClass("has-success");
			$("#control_first_name").removeClass("has-error");		
		}
			
		if (last_name.length < 2) {
			success = false;
			$("#control_last_name").removeClass("has-success");
			$("#control_last_name").addClass("has-error");
		} else {
			$("#control_last_name").addClass("has-success");
			$("#control_last_name").removeClass("has-error");		
		}
		
		$("#control_middle_name").addClass("has-success");
		$("#control_contact_email").addClass("has-success");
		$("#control_linkedin").addClass("has-success");
		$("#control_personal_site").addClass("has-success");
		$("#control_education").addClass("has-success");
		$("#control_employment").addClass("has-success");
		$("#control_bio").addClass("has-success");
	
		if (success) {
			$("#form_submit").prop("disabled", false);
		} else {
			$("#form_submit").prop("disabled", true);
		}
		return success;
	}
	
	$("#form").submit(function() {
		if (verify()) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/profile/assets/cgi/profile.php?task=1",
				data: {
					first_name: $("#form_first_name").val(),
					middle_name: $("#form_middle_name").val(),
					last_name: $("#form_last_name").val(),
					contact_email: $("#form_contact_email").val(),
					linkedin: $("#form_linkedin").val(),
					personal_site: $("#form_personal_site").val(),
					education: $("#form_education").val(),
					employment: $("#form_employment").val(),
					bio: $("#form_bio").val()
				}
			}).done(function(data) {
				if (data.update_success == false) {
					$("#error_message").html("Failed to update.");
					$("#error_message").addClass("bg-danger");
					$("#error_message").removeClass("bg-success");
				} else {
					$("#error_message").html("Update Successful.");	
					$("#error_message").removeClass("bg-danger");	
					$("#error_message").addClass("bg-success");				
				}
			});
		}
	});
	
	//$("#form").submit(function() {$("#form_submit").trigger("click");});
	
	$("#form_first_name").on("input",function() {verify();});
	$("#form_last_name").on("input",function() {verify();});
	
		
	$("#change_password").click(function() {
		var old_password = $("#form_old_password").val();
		var password = $("#form_password").val();
		var password_check = $("#form_password_check").val();
		var ok = true;
		
		if (password.length < 6) {
			$("#control_password").removeClass("has-success");
			$("#control_password").addClass("has-error");
			ok = false;
		} else {
			$("#control_password").addClass("has-success");
			$("#control_password").removeClass("has-error");
		}
		
		if (password != password_check) {
			$("#control_password_check").removeClass("has-success");
			$("#control_password_check").addClass("has-error");
			$("#password_error_message").html("Passwords do not match.");
			$("#password_error_message").addClass("text-danger");
			ok = false;
		} else {
			$("#control_password_check").addClass("has-success");
			$("#control_password_check").removeClass("has-error");
			$("#password_error_message").html("");
			$("#password_error_message").removeClass("text-danger");
			
		}
		
		if (ok) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/profile/assets/cgi/profile.php?task=3	",
				data: {
					old_password: old_password,
					password: password,
					password_check: password_check
				}
			}).done(function(data) {
				/*
				class ReturnUpdatePassword {
					public $old_password_ok = true;
					public $update_success = true;
					public $db_error = false;
				}
				*/
				if (data.update_success) {
					$("#password_error_message").html("Password Successfully Changed");
					$("#password_error_message").removeClass("text-danger");
				} else if (data.db_error) {
					$("#password_error_message").html("DB Error");
					$("#password_error_message").addClass("text-danger");
				} else if (!data.old_password_ok) {
					$("#password_error_message").html("Incorrect Old Password");
					$("#password_error_message").addClass("text-danger");
				}
			});		
		}
	});
	
	
	
	
	
});