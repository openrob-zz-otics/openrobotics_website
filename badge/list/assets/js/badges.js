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
		}).done(function(results) {
			$("#list_container").html(results);
			window.history.replaceState(null, "title", "?search_name="+($("#search_name").val())+"&search_difficulty="+
															($("#search_difficulty").val())+"&search_category="+$("#search_category").val());
		});
	}
	$("#search_name").keyup(function() {active_search();});
	$("#search_difficulty").change(function() {active_search();});
	$("#search_category").change(function() {active_search();});
});
 
