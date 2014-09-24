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
		var title = $("#form_title").val();
		var subtitle = $("#form_subtitle").val();
		var content = $("#form_content").val();
		var ok = true;
		
		if (typeof title === 'undefined' || title.length < 1) {
			ok = false;
		}
		
		if (typeof content === 'undefined' || content.length < 1) {
			ok = false;
		}
		
		if (ok) {		
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/training/post/assets/cgi/post.php?task=2",
				data: {
					title: $("#form_title").val(),
					subtitle: $("#form_subtitle").val(),
					content: $("#form_content").val(),
					visible: $("#form_visible").prop("checked"),
					id: getUrlParameter("id")
				}
			}).done(function(data) {
				if (data.success) {
					$("#status_message").html("Post updated successfully.");
					$("#status_message").addClass("bg-success");
					$("#status_message").removeClass("bg-danger");
				} else {
					$("#status_message").html("Error adding post.");
					$("#status_message").removeClass("bg-success");
					$("#status_message").addClass("bg-danger");
				}
			});		
		} else {
			$("#status_message").html("Please fill out both title and content.");
			$("#status_message").removeClass("bg-success");
			$("#status_message").addClass("bg-danger");
		}
	});
	
	
	$("#form_delete").popover({
		placement: 'right',
		html: 'true',
		content: "<p>Are you Sure?</p><button class='btn btn-danger' id='form_delete_confirm'>Yes, Delete</button>"
	}); 

	$("#form_delete").click(function() {
		$("#form_delete_confirm").click(function() {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/blog/training/assets/cgi/post.php?task=3",
				data: {
					id : getUrlParameter("id")
				}
			}).done(function(data) {
				if (data.success) {
					$("#status_message").html("Post deleted successfully.");
					location.replace("..");
				} else {
					$("#status_message").html("Error deleting post.");
				}
			});
			
		});
	});
	
});