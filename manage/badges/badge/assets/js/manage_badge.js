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
		success: function (e, data) {
			$("#icon_upload_progress .progress-bar").css("background-color", "#5cb85c");
			$("#badge_image").attr("src", $("#badge_image").attr("src") + "?" + (new Date).getTime());
		},
		progressall: function (e, data) {
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$("#icon_upload_progress .progress-bar").css("width", progress + "%");			
		}		
	});

	$("#give_user_badge").keyup(function() {
		if ($("#give_user_badge").val().length == 0) {
			$("#search_user_list").empty();
			return;
		}
		$.ajax({
			type: "POST",
			url: "/manage/badges/badge/assets/cgi/badges.php?task=3",
			data: {
				id: getUrlParameter("id"),
				search: $("#give_user_badge").val()
			}
		}).done(function(data) {
			$("#search_user_list").html(data);
			$("li[class~='user_select']").click(function() {
				var t =  $(this);
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "/manage/badges/badge/assets/cgi/badges.php?task=4",
					data: {
						id: getUrlParameter("id"),
						user_id: t.data("id")
					}
				}).done(function(data) {
					console.log(data);
					if (data.success) {
						t.slideUp(function() {
							reDrawUserList();
						});
					} else {
						t.css("background-color","#f2dede");
						t.html(t.html() + " - Error");
					}
				}).
				fail(function() {
					t.css("background-color","#f2dede");
					t.html(t.html() + " - Error");
				});
			});
		});
	});

	function reDrawUserList() {
		$.ajax({
			type: "POST",
			url: "/manage/badges/badge/assets/cgi/badges.php?task=5",
			data: {
				badge_id: getUrlParameter("id"),
			}
		}).done(function(data) {
			$("#user_list").html(data);
			$("span[class~='delete_user']").click(function() {
				clickDelete($(this).data('id'), $(this).parent());
			});
		});	
	}

 	function clickDelete(user_id, p) {
 		p.slideUp(function() {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/badges/badge/assets/cgi/badges.php?task=6",
				data: {
					id: getUrlParameter("id"),
					user_id: user_id
				}
			}).done(function(data) {
				if (data.success) {
					reDrawUserList();
				}
			});
		});
 	}

	$("span[class~='delete_user']").click(function() {
		clickDelete($(this).data('id'), $(this).parent());
	});

});