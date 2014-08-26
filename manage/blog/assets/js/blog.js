$(function() {
	//mode 0:add, 1:edit
	var mode = 0;
	var blog_id = 0;

	$('a[class~="edit"]').click(function() {
		var id = $(this).data("id");
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/blog/cgi/blog.php?task=0",
			data: {
				id: id
			}
		}).done(function(data) {
			$("#form_title").val(data.title);
			$("#form_subtitle").val(data.subtitle);
			$("#form_content").val(data.content);
			blog_id = id;
			mode = 1;
			$("#form_submit").html("Update Post");
			$("#form_delete").prop("disabled", false);
		});
	});
	
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
			if (mode == 0) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "/manage/blog/cgi/blog.php?task=1",
					data: {
						title: $("#form_title").val(),
						subtitle: $("#form_subtitle").val(),
						content: $("#form_content").val()
					}
				}).done(function(data) {
					if (data.success) {
						$("#status_message").html("Post added successfully.");
						window.location.href = "/blog";
					} else {
						$("#status_message").html("Error adding post.");
					}
				});
			} else if (mode == 1) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "/manage/blog/cgi/blog.php?task=2",
					data: {
						id: blog_id,
						title: $("#form_title").val(),
						subtitle: $("#form_subtitle").val(),
						content: $("#form_content").val()
					}
				}).done(function(data) {
					if (data.success) {
						$("#status_message").html("Post updated successfully.");
					} else {
						$("#status_message").html("Error updating post.");
					}
				});
			}
		} else {
			$("#status_message").html("Please fill out both title and content.");
		}
	});
	
	$("#reset_form").click(function() {
		mode = 0;
		$("#form_title").val("");
		$("#form_subtitle").val("");
		$("#form_content").val("");
		$("#form_submit").html("Post to Blog");
		$("#form_delete").prop("disabled", true);
	});
	
	$("#form_delete").click(function() {
		if (mode == 1) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/blog/cgi/blog.php?task=3",
				data: {
					id : blog_id
				}
			}).done(function(data) {
				if (data.success) {
					$("#status_message").html("Post deleted successfully.");
					$("#reset_form").trigger("click");
				} else {
					$("#status_message").html("Error delete post.");
				}
			});
		}
	});
	
});