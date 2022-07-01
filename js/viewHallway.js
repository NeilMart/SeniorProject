var timeSection = document.getElementsByClassName("time");
var noShow      = document.getElementsByClassName("noshow");
var today       = new Date();
var currentTime = Math.round(today.getTime() / 1000 / 60);
var timeTotal   = 0;

for (var i = 0; i < noShow.length; i++) {
  noShow[i].style.display = 'none';
}

for (var i = 0; i < timeSection.length; i++) {
  timeSection[i].innerText = currentTime - noShow[i].innerText;
}

setInterval(function() {
  $( "#table-container" ).load( "ajax/viewHallway.php #table-container" );
}, 60 * 1000); // 60 * 1000 milsec