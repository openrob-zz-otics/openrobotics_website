$(function() {
	var page_id = -1;
	$("#location_button").click(function() {
		page_id = $("#location_select option:selected").val();

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/display/assets/cgi/display.php?task=0",
			data: {
				id: page_id
			}
		}).done(function(data) {
			if(data['success']) {
				$("#form_area").html(data['append_data']);
				if (page_id > 0) {
					$("#submit_button").click(function() {
						formSubmit();
					});
					$("#update_form").submit(function() {
						formSubmit();
					});
				} else if (page_id == -1) {
					$("#carousel_upload").fileupload({
						dataType: "json",
						done: function (e, data) {
							$("#carousel_upload_progress .progress-bar").css("background-color", "#5cb85c");
							$("#location_button").trigger('click');
						},
						progressall: function (e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$("#carousel_upload_progress .progress-bar").css("width", progress + "%");			
						}		
					});	
					$(".delete_image").click(function() {
						deleteImage($(this).data('val'));
					});			
				}
			} else {
				$("#form_area").html('<p class="bg-warning">Failed to load data.</p>');
			}
		});
	});
	
	function deleteImage(val) {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/display/assets/cgi/display.php?task=3",
			data: {
				val: val
			}
		}).done(function() {
			$("#img_"+val.replace( /(:|\.|\[|\])/g, "\\$1" )).fadeOut();
		});
	}

	function formSubmit() {
		var ids = [];
		var vals = [];
		$("#update_form input").each(function() {
			ids.push($(this).attr('id'));
			vals.push($(this).val());
		});
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/display/assets/cgi/display.php?task=1",
			data: {
				id: page_id,
				ids: ids.join('_;!_'),
				vals: vals.join('_;!_')
			}
		}).done(function(data) {
			if(data['success']) {
				$("#message_text").html("Success");
				$("#message_text").addClass("bg-success");
				$("#message_text").removeClass("bg-warning");
			} else {
				$("#message_text").html("Failed to update database.");
				$("#message_text").addClass("bg-warning");
				$("#message_text").removeClass("bg-success");
			}
		});
	}
});