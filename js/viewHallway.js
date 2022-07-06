/*******************************************************************************
 * Dynamic portion of the hallmonitor
 * 
 * HTML: viewHallway.php
 ******************************************************************************/

var timeSection = document.getElementsByClassName("time");
var noShow      = document.getElementsByClassName("noshow");

var today       = new Date();
var currentTime = Math.round(today.getTime() / 1000 / 60);

// Runs through the hall monitor table and removes all of the entries showing
// time since 1980
for (var i = 0; i < noShow.length; i++) {
  noShow[i].style.display = 'none';
}

// Creates a new entry in the table showing the much more useful time since the
// student has checked out
for (var i = 0; i < timeSection.length; i++) {
  timeSection[i].innerText = (currentTime - noShow[i].innerText) + " minutes";
}