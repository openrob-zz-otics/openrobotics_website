$(function() {
  $("img[class~='badge_image']").each(function() {
    console.log($(this).data("title"));
    $(this).tooltip();
  });
});
