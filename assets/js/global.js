$(function () {
  //This code controlls the horizontal line that in the main open robotics banner
  //It needs to be resized with the window and removed on mobile.
  //the fixed values will need to be changed if the mobile transition width is ever
  //changed.
  $("#left_line").fadeIn("fast");
  $("#right_line").fadeIn("fast");
  $("#logo").fadeIn("fast");

  //poppup on main page for new (non-cookied) viewers
  $("#nav_container").popover({
    trigger: "manual",
    html: "true",
    content: '<span id="popover_span" style="float:right;" class="glyphicon glyphicon-remove"></span><center><p>Welcome! Have you considered signing up for our mailing list? Click on the x to dismiss this message, we won\'t bug you again!</p><a href="/email/register_email"><button class="btn btn-danger">Click here...</button></a></center>',
    placement: "bottom"
  });

  $("#nav_container").on("shown.bs.popover", function () {
    $("#popover_span").click(function () {
      $("#nav_container").popover("destroy");
    });
    $("div[class~='popover']").css("position", "fixed");
  });
});

$(window)
  .resize(function () {
    var width = $("#nav_container").width();
    var top = $("#left_line").css("top");
    console.log("Nav-container width: " + width);
    var dif = 0;
    if (width < 1000) {
      $("#left_line").css("top", 140);
      $("#right_line").css("top", 140);
    } else {
      $("#left_line").css("top", 120);
      $("#right_line").css("top", 120);
    }
    $("#left_line").width(width / 2 - 75);
    $("#right_line").width(width / 2 - 75);
    $("#left_line").css("left", 10 + dif / 2);
    $("#logo").css("left", width / 2 - 65);
    $("#right_line").css("left", (dif + width) / 2 + 65);

  })
  .trigger("resize");