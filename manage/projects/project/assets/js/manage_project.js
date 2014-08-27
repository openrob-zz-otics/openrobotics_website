$(function() {
	$(window).resize(function() {
		var width = $(window).width();
		if (width < 992) {
			$("#contributor-left").width($("#form_description").width());
			$("#contributor-right").width($("#form_description").width());
		} else {
			$("#contributor-left").width(25);
			$("#contributor-right").width(25);
		}
	});	
	$(window).trigger("resize");
	
	$("#form_start_time").datepicker({
		format: 'yyyy-mm-dd'
	});
	$("#form_finish_time").datepicker({
		format: 'yyyy-mm-dd'
	});
});