$(function() {
	$("#form_submit").click(function() {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/badges/badge/assets/cgi/badges.php?task=0",
			data: {
				id: getUrlParameter('id'),
				visible: $("#form_visible").prop('checked'),
				name: $("#form_name").val(),
				difficulty: $("#form_difficulty").val(),
				category: $("#form_category option:selected").data("id"),
				description: $("#form_description").val(),
				instructions: $("#form_instructions").val()
			}
		}).done(function(data) {
			if (data.success) {
				$("#status_message").addClass("text-success");
				$("#status_message").removeClass("text-danger");
				$("#status_message").html("Update Success");
			} else {
				$("#status_message").removeClass("text-success");
				$("#status_message").addClass("text-danger");
				$("#status_message").html("Update Failed");
			}
		}).fail(function(data) {
			$("#status_message").removeClass("text-success");
			$("#status_message").addClass("text-danger");
			$("#status_message").html("Update Failed");
		});
	});

	$("#delete_popover").popover({
		placement: 'right',
		html: 'true',
		content: "<p>Are you Sure?</p><button class='btn btn-danger' id='form_delete'>Yes, Delete</button>"
	}).click(function() {
		$("#form_delete").click(function() {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/badges/badge/assets/cgi/badges.php?task=1",
				data: {
					id: getUrlParameter("id")
				}
			}).done(function(data) {
				if (data.success) {
					location.replace("..");
				} else {
					$("#status_message").removeClass("text-success");
					$("#status_message").addClass("text-danger");
					$("#status_message").html("Update Failed");
				}
			}).fail(function() {
				$("#status_message").removeClass("text-success");
				$("#status_message").addClass("text-danger");
				$("#status_message").html("Update Failed");
			});
		});
	});

	//Update for uploading images

});