/*******************************************************************************
 * Dynamic portion of the hallmonitor
 * 
 * HTML: viewHallway.php
 ******************************************************************************/

var timeSection = document.getElementsByClassName("time");
var noShow      = document.getElementsByClassName("noshow");
var today       = new Date();
var currentTime = Math.round(today.getTime() / 1000 / 60);
var timeTotal   = 0;

for (var i = 0; i < noShow.length; i++) {
  noShow[i].style.display = 'none';
}

for (var i = 0; i < timeSection.length; i++) {
  timeSection[i].innerText = (currentTime - noShow[i].innerText) + " minutes";
}