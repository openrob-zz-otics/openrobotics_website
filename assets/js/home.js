$(function() {
  $(window).resize(function() {
    //Get the current dimensions we need
    var width = $(window).width();

    // if (width > 1170)
    // 	width = 1170;

    var height = width / 1.9;

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

$(document).ready(function() {
  $(this).scrollTop(0);
});

$(document).ready(function() {
  /* Every time the window is scrolled ... */
  $(window).scroll(function() {
    /* Check the location of each desired element */
    $(".hideme").each(function(i) {
      var bottom_of_object = $(this).position().top + $(this).outerHeight();
      var bottom_of_window = $(window).scrollTop() + $(window).height();

      /* If the object is completely visible in the window, fade it it */
      if (bottom_of_window + 300 > bottom_of_object) {
        $(this).animate({ opacity: "1" }, 700);
      }
    });
  });
});
