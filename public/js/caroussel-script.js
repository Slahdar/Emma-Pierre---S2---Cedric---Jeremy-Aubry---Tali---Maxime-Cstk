var timer = 4000;

var i = 0;
var max = $("#carousselAccueil > li").length;

$("#carousselAccueil > li").eq(i).addClass("active").css("left", "0");
$("#carousselAccueil > li")
  .eq(i + 1)
  .addClass("active")
  .css("left", "50%");
// $("#carousselAccueil > li")
//   .eq(i + 2)
//   .addClass("active")
//   .css("left", "50%");
// $("#carousselAccueil > li")
//   .eq(i + 3)
//   .addClass("active")
//   .css("left", "75%");

setInterval(function () {
  $("#carousselAccueil > li").removeClass("active");

  $("#carousselAccueil > li").eq(i).css("transition-delay", "0.25s");
  $("#carousselAccueil > li")
    .eq(i + 1)
    .css("transition-delay", "0.5s");
  // $("#carousselAccueil > li")
  //   .eq(i + 2)
  //   .css("transition-delay", "0.75s");
  // $("#carousselAccueil > li")
  //   .eq(i + 3)
  //   .css("transition-delay", "1s");

  if (i < max - 2) {
    i = i + 2;
  } else {
    i = 0;
  }

  $("#carousselAccueil > li")
    .eq(i)
    .css("left", "0")
    .addClass("active")
    .css("transition-delay", "1.25s");
  $("#carousselAccueil > li")
    .eq(i + 1)
    .css("left", "50%")
    .addClass("active")
    .css("transition-delay", "1.5s");
  $("#carousselAccueil > li");
  //   .eq(i + 2)
  //   .css("left", "50%")
  //   .addClass("active")
  //   .css("transition-delay", "1.75s");
  // $("#carousselAccueil > li")
  //   .eq(i + 3)
  //   .css("left", "75%")
  //   .addClass("active")
  //   .css("transition-delay", "2s");
}, timer);
