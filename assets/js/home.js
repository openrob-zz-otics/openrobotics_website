$(function () {
  $(window).resize(function () {
    //Get the current dimensions we need
    var width = $(window).width();

    // if (width > 1170)
    // 	width = 1170;

    var height = width / 1.9;

    //Apply the current dimensions
    $(".carousel_resize").width(width);
    $(".carousel_resize").height(height);
    $("#carousel-overlay").css("width", width * 5 / 7);
    $("#carousel-overlay").css("height", height * 2 / 6);
    $("#carousel-overlay").css("margin-left", width * 1 / 6);
    $("#carousel-overlay").css("margin-top", height * 2 / 6);
    $("#carousel-overlay-slogan").css("margin-top", height / 12);
    $("#carousel-overlay-title").css("font-size", width / 15);
    $("#carousel-overlay-slogan").css("font-size", width / 30);
  });
  //Set the dimensions immediately
  $(window).trigger("resize");

  //reset the dimensions on carousel events, just in case
  $("#myCarousel").on("slide.bs.carousel", function () {
    $(window).trigger("resize");
  });
  $("#myCarousel").on("slid.bs.carousel", function () {
    $(window).trigger("resize");
  });
});

$(document).ready(function () {
  $(this).scrollTop(0);
});

$(document).ready(function () {
  /* Every time the window is scrolled ... */
  $(window).scroll(function () {
    /* Check the location of each desired element */
    $(".hideme").each(function (i) {
      var bottom_of_object = $(this).position().top + $(this).outerHeight();
      var bottom_of_window = $(window).scrollTop() + $(window).height();

      /* If the object is completely visible in the window, fade it it */
      if (bottom_of_window + 400 > bottom_of_object) {
        $(this).animate({
          opacity: "1"
        }, 700);
      }
    });
  });
});