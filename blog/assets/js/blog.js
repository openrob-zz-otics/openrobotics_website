$(function() {
	$("#disp-content img").addClass("img-responsive");
	$("#disp-content iframe").each(function() {
		var width = $(this).width();
		var height = $(this).height();
		$(this).css("max-width", width+"px");
		$(this).css("max-height", height+"px");		
	});
	
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
	});

	$("h4[class~='expand']").click(function() {
		var id = "#"+$(this).data("id");
		if ($(id).is(":visible")) {
			$(id).slideUp();
		} else {
			$(id).slideDown();
		}
	});
});