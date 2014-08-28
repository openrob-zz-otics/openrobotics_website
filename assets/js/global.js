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
	
	$("#nav_container").popover({
		trigger: 'manual',
		html: 'true',
		content: '<span id="popover_span"><center><p>Welcome! Have you considered signing up for our mailing list? Click on this text bubble to dismiss it, we won\'t bug you again!</p><a href="/email/register_email"><button class="btn btn-danger">Click here...</button></a></center></span>',
		placement: 'bottom'
	});
	
	$("#nav_container").on('shown.bs.popover', function() {
		$("#popover_span").click(function() {
			$("#nav_container").popover('destroy');
		});
	});
});