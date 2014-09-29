$(function() {
	function active_search() {
		$.ajax({
			type: "POST",
			url: "/badge/list/assets/cgi/list.php",
			data: {
				name: $("#search_name").val(),
				difficulty: $("#search_difficulty").val(),
				category: $("#search_category").val()
			}
		}).done(function(data) {
			$("#list_container").html(data);
		});
	}
	$("#search_name").keyup(function() {active_search();});
	$("#search_difficulty").keyup(function() {active_search();});
	$("#search_category").keyup(function() {active_search();});
});