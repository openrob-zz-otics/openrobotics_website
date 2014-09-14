$(function() {

	function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) {
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) {
				return sParameterName[1];
			}
		}
	}

	$(window).resize(function() {		
		var width = $(window).width();
		if (width < 975) {
			$("#contributor-left").width($("#form_description").width());
			$("#contributor-right").width($("#form_description").width());
		} else {
			$("#contributor-left").width(25);
			$("#contributor-right").width(25);
		}
	});	
	$(window).trigger("resize");
	
	$("#form_start_time").datepicker({
		format: 'yyyy-mm-dd'
	});
	$("#form_finish_time").datepicker({
		format: 'yyyy-mm-dd'
	});
	
	//Enable popover
	$("#delete-popover").popover({
		placement: 'right',
		html: 'true',
		content: "<p>Are you Sure?</p><button class='btn btn-danger' id='form_delete'>Yes, Delete</button>"
	}); 
	
	
	//Move things from left to right
	$("#contributor-right").click(function() {
		var selected_ids = [];
		var selected_names = [];
		var all_ids_on_left = [];
		var all_names_on_left = [];
		var i;
		$("#select-left option:selected").each(function() {
			selected_ids.push($(this).val());
			selected_names.push($(this).html());
		});
		
		$("#select-left option").each(function() {
			if (selected_ids.indexOf($(this).val()) == -1) {
				all_ids_on_left.push($(this).val());
				all_names_on_left.push($(this).html());
			}
		});
		
		for (i = 0; i < selected_ids.length; i++) {
			$("#select-right").append("<option value='"+selected_ids[i]+"'>"+selected_names[i]+"</option>");				
		}
		
		$("#select-left").empty();
		
		for (i = 0; i < all_ids_on_left.length; i++) {
			$("#select-left").append("<option value='"+all_ids_on_left[i]+"'>"+all_names_on_left[i]+"</option>");				
		}
	});	
	
	//Move things from right to left
	$("#contributor-left").click(function() {
		var selected_ids = [];
		var selected_names = [];
		var all_ids_on_right = [];
		var all_names_on_right = [];
		var i;
		$("#select-right option:selected").each(function() {
			selected_ids.push($(this).val());
			selected_names.push($(this).html());
		});
		
		$("#select-right option").each(function() {
			if (selected_ids.indexOf($(this).val()) == -1) {
				all_ids_on_right.push($(this).val());
				all_names_on_right.push($(this).html());
			}
		});
		
		for (i = 0; i < selected_ids.length; i++) {
			$("#select-left").append("<option value='"+selected_ids[i]+"'>"+selected_names[i]+"</option>");				
		}
		
		$("#select-right").empty();
		
		for (i = 0; i < all_ids_on_right.length; i++) {
			$("#select-right").append("<option value='"+all_ids_on_right[i]+"'>"+all_names_on_right[i]+"</option>");				
		}
	});	
	
	$("#delete-popover").click(function() {
		$("#form_delete").click(function() {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/projects/project/assets/cgi/project.php?task=0",
				data: {
					id: getUrlParameter("id")
				}
			}).done(function(data) {
				if (data.success) {
					location.replace("..");
				} else {
					$("#error-message").html("Failed to Delete");
					$("#error-message").addClass("bg-danger");					
					$("#error-message").removeClass("bg-success");
				}
			});
		});
	});
	
	$("#form_submit").click(function() {
		var visible = $("#form_visible").prop("checked");
		var is_featured = $("#form_featured").prop("checked");
		var start_time = $("#form_start_time").val();
		var finish_time = $("#form_finish_time").val();
		var name = $("#form_name").val();
		var description = $("#form_description").val();
		var selected_ids = [];
		$("#select-right option").each(function() {
			selected_ids.push($(this).val());
		});
		var project_contributors = selected_ids.join();
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/projects/project/assets/cgi/project.php?task=1",
			data: {
				id: getUrlParameter("id"),
				visible: visible,
				is_featured: is_featured,
				start_time: start_time,
				finish_time: finish_time,
				name: name,
				description: description,
				project_contributors: project_contributors
			}
		}).done(function(data) {
			if (data.success) {
				$("#error-message").html("Update Successful");
				$("#error-message").removeClass("bg-danger");					
				$("#error-message").addClass("bg-success");
			} else {
				$("#error-message").html("Update Unsuccessful");
				$("#error-message").addClass("bg-danger");					
				$("#error-message").removeClass("bg-success");
			}
		});
		
	});
	
	$("#main_image_upload").fileupload({
		dataType: "json",
		formData: {id: getUrlParameter("id") },
		done: function (e, data) {
			$("#main_image_upload_progress .progress-bar").css("background-color", "#5cb85c");
			imageLoad();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$("#main_image_upload_progress .progress-bar").css("width", progress + "%");			
		}		
	});
	
	$("#additional_image_upload").fileupload({
		dataType: "json",
		formData: {id: getUrlParameter("id") },
		done: function (e, data) {
			$("#additional_image_upload_progress .progress-bar").css("background-color", "#5cb85c");
			imageLoad();
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$("#additional_image_upload_progress .progress-bar").css("width", progress + "%");			
		}		
	});
	
	function imageLoad() {
		$.ajax({
			type: "POST",
			url: "/manage/projects/project/assets/cgi/project.php?task=5",
			data: {
				id: getUrlParameter("id"),
			}
		}).done(function(data) {
			$("#manage_images").empty();
			$("#manage_images").append(data);
			imageDelete();
		});
	}	
	
	function imageDelete() {
		$("button[class~='image_delete']").click(function() {
			$.ajax({
				type: "POST",
				url: "/manage/projects/project/assets/cgi/project.php?task=4",
				data: {
					id: getUrlParameter("id"),
					file: $(this).data("file")
				}
			}).done(function() {
				imageLoad();
			});
		});
	};
	imageDelete();
	
	$("#form_finished_project").change(function() {
		if ($(this).prop("checked")) {
			$("#form_finish_time").prop("disabled", false);
		} else {
			$("#form_finish_time").prop("disabled", true);
			$("#form_finish_time").val("");
		}
	});
	
});