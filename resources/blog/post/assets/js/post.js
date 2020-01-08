$(function() {
	//make all images responsive
	$("#disp-content img").addClass("img-responsive");

	//resize youtube videos to fit
	$(window).resize(function() {
		$("#disp-content iframe").each(function() {
			var width = parseInt($(this).css("max-width"));
			var height = parseInt($(this).css("max-height"));
			
			var newwidth = $("#disp-content").width();
			var newheight = newwidth * height / width;
			$(this).width(newwidth);
			$(this).height(newheight);
		});
	}).trigger("resize");
});