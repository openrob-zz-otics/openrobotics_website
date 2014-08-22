$(function() {
	$(window).resize(function() {
		var width = $("#nav_container").width();
		var dif = 0;
		if (width > 1170) {
			dif = width - 1170;
			width = 1170;
		}
		$("#left_line").width( width / 2 - 50);
		$("#right_line").width( width / 2 - 95);
		$("#left_line").css("left", 10 + dif / 2);
		$("#right_line").css("left", (dif + width) / 2 + 85);
	});
	
	$(window).trigger("resize");
});