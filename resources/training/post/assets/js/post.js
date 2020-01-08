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

	$("#disp-content img").addClass("img-responsive");
	$("#disp-content iframe").each(function() {
		var width = $(this).width();
		var height = $(this).height();
		$(this).css("max-width", width+"px");
		$(this).css("max-height", height+"px");		
	});
	
	/*
	$(window).resize(function() {
		console.log("resize");
		$("#disp-content iframe").each(function() {
			var width = parseInt($(this).css("max-width"));
			var height = parseInt($(this).css("max-height"));
			
			var newwidth = $("#disp-content").width();
			var newheight = newwidth * height / width;
			$(this).width(newwidth);
			$(this).height(newheight);
		});
	});*/

	$("#check_completed").change(function() {
		var checked = false;
		if (this.checked) {
			checked = true;
		}

		$.ajax({
			type: "POST",
			url: "/training/post/assets/cgi/training.php",
			data: {
				is_checked: checked,
				training_id: getUrlParameter("id")
			}
		});
	});
});