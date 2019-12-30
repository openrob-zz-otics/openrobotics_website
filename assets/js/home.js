$(function() {
  $(window).resize(function() {
    //Get the current dimensions we need
    var width = $(window).width();

    // if (width > 1170)
    // 	width = 1170;

    var height = width / 3;

    //Apply the current dimensions
    $(".carousel_resize").width(width);
    $(".carousel_resize").height(height);
    $("#carousel-overlay").css("margin", width / 200);
    $("#carousel-overlay").css("font-size", 15 + width / 50);
  });
  //Set the dimensions immediately
  $(window).trigger("resize");

  //reset the dimensions on carousel events, just in case
  $("#myCarousel").on("slide.bs.carousel", function() {
    $(window).trigger("resize");
  });
  $("#myCarousel").on("slid.bs.carousel", function() {
    $(window).trigger("resize");
  });
});
