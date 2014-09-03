$(function() {
	$('tr[class="expand_tr"]').click(function() {
		if ($(event.target).is("input") || $(event.target).is("button"))
			return;
		var id = $(this).data("id");
		if ($(this).data("down") == "1") {
			$("#"+id+"_row").hide();
			$(this).data("down", "0");
		} else {
			$(this).data("down", "1");
			$("#"+id+"_row").show();
		}
	});
		
	$('button[class~="update_perms"]').click(function() {
		var id = $(this).data("id");
		var manage_users = $("#"+id+"_manage_users").prop("checked");
		var add_projects = $("#"+id+"_add_projects").prop("checked");
		var manage_all_projects = $("#"+id+"_manage_all_projects").prop("checked");
		var add_blog_post = $("#"+id+"_add_blog_post").prop("checked");
		var manage_all_blog_posts = $("#"+id+"_manage_all_blog_posts").prop("checked");
		var in_contact_list = $("#"+id+"_in_contact_list").prop("checked");
		var send_email = $("#"+id+"_send_email").prop("checked");
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/users/cgi/users.php?task=0",
			data: {
				id: id,	
				manage_users: manage_users,
				add_projects: add_projects,
				manage_all_projects: manage_all_projects,
				add_blog_post: add_blog_post,
				manage_all_blog_posts: manage_all_blog_posts,
				in_contact_list: in_contact_list,
				send_email: send_email
			}	
		}).done(function(data) {
			if (data.update_success) {
				$("#"+id+"_perm_row").addClass("success");
				$("#"+id+"_perm_row").removeClass("danger");
			} else {
				$("#"+id+"_perm_row").removeClass("success");
				$("#"+id+"_perm_row").addClass("danger");
			}
		});
	});
	
	$('form').submit(function() {
		var id = $(this).data("id");
		var first_name = $("#"+id+"_form_first_name").val();
		var middle_name = $("#"+id+"_form_middle_name").val();
		var last_name = $("#"+id+"_form_last_name").val();
		var contact_email = $("#"+id+"_form_contact_email").val();
		var linkedin = $("#"+id+"_form_linkedin").val();
		var personal_site = $("#"+id+"_form_personal_site").val();
		var open_robotics_position = $("#"+id+"_form_open_robotics_position").val();
		var education = $("#"+id+"_form_education").val();
		var employment = $("#"+id+"_form_employment").val();
		var bio = $("#"+id+"_form_bio").val();
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/users/cgi/users.php?task=1",
			data: {
				id: id,
				first_name: first_name,
				middle_name: middle_name,
				last_name: last_name,
				contact_email: contact_email,
				linkedin: linkedin,
				personal_site: personal_site,
				open_robotics_position: open_robotics_position,
				education: education,
				employment: employment,
				bio: bio
			}	
		}).done(function(data) {
			if (data.update_success) {
				$("#"+id+"_row").addClass("success");
				$("#"+id+"_row").removeClass("danger");
			} else {
				$("#"+id+"_row").removeClass("success");
				$("#"+id+"_row").addClass("danger");
			}
		});
	});
	
	$('button[class~="form_update_password"]').click(function() {
		var id = $(this).data("id");
		var password = $("#"+id+"_form_password").val();
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "/manage/users/cgi/users.php?task=2",
			data: {
				id: id,
				password: password
			}	
		}).done(function(data) {
			if (data.update_success) {
				$("#"+id+"_row").addClass("success");
				$("#"+id+"_row").removeClass("danger");
			} else {
				$("#"+id+"_row").removeClass("success");
				$("#"+id+"_row").addClass("danger");
			}
		});
	});
	
	$('button[class~="form_delete_user"]').click(function() {
		var id = $(this).data("id");
		
		if ($("#"+id+"_form_delete_box").prop("checked")) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "/manage/users/cgi/users.php?task=3",
				data: {
					id: id,
				}	
			}).done(function(data) {
				if (data.update_success) {
					$("#"+id+"_row").addClass("success");
					$("#"+id+"_row").removeClass("danger");
				} else {
					$("#"+id+"_row").removeClass("success");
					$("#"+id+"_row").addClass("danger");
				}
			});
		}
	});
});