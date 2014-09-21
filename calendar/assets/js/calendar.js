$(function() {
	$(window).resize(function() {
		var width = $("#div_container").width();
		$("#issu_doc").width(width);
	});
	$(window).trigger("resize");
});