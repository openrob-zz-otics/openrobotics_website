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
				new_category: $("#form_new_category").val(),
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
				if ($("#form_category option:selected").data("id") == 0) {
					$("#form_category option:selected").prop('selected', false);
					$("#form_category").append('<option data-id="'+ data.new_category_id+'" selected>'+$("#form_new_category").val()+'</option>');
					$("#new_category_group").fadeOut(function(){$("#form_new_category").val('')});
				}

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

	//new categories
	$("#form_category").change(function() {
		if ($("#form_category option:selected").data("id") == 0) {
			 $("#new_category_group").fadeIn();
		} else {
			$("#new_category_group").fadeOut();
		}
	});

	//Update for uploading images
	$("#icon_upload").fileupload({
		dataType: "json",
		formData: {id: getUrlParameter("id") },
		done: function (e, data) {
			$("#icon_upload_progress .progress-bar").css("background-color", "#5cb85c");
			imageLoad();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$("#icon_upload_progress .progress-bar").css("width", progress + "%");			
		}		
	});

});