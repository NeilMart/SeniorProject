/*******************************************************************************
 * Deals with the ability of a student to choose where they will go - requires a
 * teacher PIN
 * 
 * PHP: loLoad.php
 *      returnNames.php
 *      releaseStudent.php
 * 
 * HTML: location.php
 ******************************************************************************/

var linkTarget = "";     // Just initializing some variables, nothing exciting
var targetLocation = "";

var studentNameSection = document.getElementById("stu-name");
var selectMenu         = document.getElementById("location");
var pageForm           = document.getElementById("page-form");
var approvalButton     = document.getElementById("approve");
var denialButton       = document.getElementById("deny");
var teacherSelection   = document.getElementById("teachers");
var teacherTemplate    = document.getElementById("teacher-option");
var pin                = document.getElementById("pin");
var topErrorText       = document.getElementById("error-text-top");
var topErrorZone       = document.getElementById("error-message-top");

var xmlhttp      = new XMLHttpRequest(); // AJAX for an approved check out
var olxmlhttp    = new XMLHttpRequest(); // AJAX on load
var namesxmlhttp = new XMLHttpRequest(); // AJAX used to grab staff names

approvalButton.addEventListener("click", grabButtonValue);
denialButton.addEventListener("click", grabButtonValue);

// Very simple one-line function that is used to figure out which of the two 
// form submission buttons the user clicked on
function grabButtonValue() {
  linkTarget = this.name;
}

window.addEventListener("pageshow", function() {
  pageForm.reset();
  teacherSelection.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";

  // When the page loads, two important things have to happen:
  olxmlhttp.open("POST", "../php/loLoad.php", true);
  olxmlhttp.send(); // display the student's name, and
  namesxmlhttp.open("POST", "../php/returnNames.php", true);
  namesxmlhttp.send(); // grab a list of all active staff members
});

olxmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    if (decodedResponse[0]) {
      studentNameSection.innerText = decodedResponse[1];
    } else { // They got to this page without using the typical path... bad
      window.location.href = "./homepage.php";
    }
  }
}

// see comment for "buildOption" function
namesxmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    decodedResponse.forEach(item => buildOption(item));
  }
}

// I have a templated selection menu on this page that is populated using the 
// AJAX script that runs when the page loads, containing all active staff...
// this function is what facilitates that event
function buildOption(item) {
  var name = item[0];

  var clone = teacherTemplate.content.cloneNode(true);
  var option = clone.getElementById("target-option");
  option.value = name;
  option.innerText = name;
  teacherSelection.appendChild(clone);
}

// If the student choose to go to a teacher, the list of names is displayed on
// the screen ... why else would they need to see it? helps to reduce clutter
selectMenu.addEventListener("change", function() {
  targetLocation = selectMenu.value;
  if (targetLocation == "teacher") {
    teacherSelection.style.display = "block"
  } else {
    teacherSelection.style.display = "none"
  }

  pin.value = "";
})

// Note that changing any of the page options after the PIN has been entered
// will actually clear the pin ... should prevent an excess of schenanigans
teacherSelection.addEventListener("change", function() {
  pin.value = "";
})

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();

  if (linkTarget == "deny") {
    window.location.href = "./homepage.php";
  } else { // the teacher decides to let this student go

    // Uses Javascript's time API to generate a "time out" for the student. Note
    // that this is in minutes since 1980, so it needs to be cleaned up a little
    // before it'll be suitable for display
    var today = new Date();
    var currentTime = Math.round(today.getTime() / 1000 / 60);

    var destination = selectMenu.value;
    if (destination == "teacher") {
      destination = teacherSelection.value;
    }

    xmlhttp.open("POST", "../php/releaseStudent.php?pin=" + pin.value +
                         "&time=" + currentTime + "&destination=" + destination);
    xmlhttp.send();
    pin.value = "";
  }
});

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    if (decodedResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      window.location.href = "./homepage.php";
    } else{ // something went wrong on approval
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodedResponse[1];
    }
  }
}