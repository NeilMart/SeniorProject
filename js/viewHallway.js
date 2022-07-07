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
  var wordChoice = "";
  var time = currentTime - noShow[i].innerText;

  // This wasn't very necessary, but I didn't like reading "1 minutes" all the
  // time ... so this fixes that
  if (time == '1') {
    wordChoice = "minute";
  } else {
    wordChoice = "minutes";
  }

  // Combine the student's time away from the office with the correct identifier
  timeSection[i].innerText = time + " " + wordChoice;
}