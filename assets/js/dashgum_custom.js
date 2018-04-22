// $(document).ready(function () {
//   $("#date-popover").popover({html: true, trigger: "manual"});
//   $("#date-popover").hide();
//   $("#date-popover").click(function (e) {
//     $(this).hide();
//   });
//
//   $("#my-calendar").zabuto_calendar({
//     action: function () {
//       return myDateFunction(this.id, false);
//     },
//     action_nav: function () {
//       return myNavFunction(this.id);
//     },
//     ajax: {
//       url: "show_data.php?action=1",
//       modal: true
//     },
//     legend: [
//       {type: "text", label: "Special event", badge: "00"},
//       {type: "block", label: "Regular event", }
//     ]
//   });
// });

function myNavFunction(id) {
  $("#date-popover").hide();
  var nav = $("#" + id).data("navigation");
  var to = $("#" + id).data("to");
  console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}

$(function() {
  //    fancybox
  jQuery(".fancybox").fancybox();
});

// $.backstretch("assets/img/login-bg.jpg", {speed: 500});

function getTime()
{
  var today=new Date();
  var h=today.getHours();
  var m=today.getMinutes();
  var s=today.getSeconds();
  // add a zero in front of numbers<10
  m=checkTime(m);
  s=checkTime(s);
  document.getElementById('showtime').innerHTML=h+":"+m+":"+s;
  t=setTimeout(function(){getTime()},500);
}

function checkTime(i)
{
  if (i<10)
  {
    i="0" + i;
  }
  return i;
}
// $.backstretch("assets/img/login-bg.jpg", {speed: 500});
// jQuery(document).ready(function() {
//   TaskList.initTaskWidget();
// });

$(function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
});

//custom select box

$(function(){
  $('select.styled').customSelect();
});
