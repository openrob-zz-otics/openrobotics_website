$(function() {
  $("img[class~='badge_image']").each(function() {
    console.log($(this).data("title"));
    $(this).tooltip();
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
      if (bottom_of_window + 900 > bottom_of_object) {
        $(this).animate({ opacity: "1" }, 1000);
      }
    });
  });
});
