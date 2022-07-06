/*******************************************************************************
 * Allows the user to add a single student at a time to the student roster
 * 
 * PHP: singleUpload.php
 * 
 * HTML: addStudent.php
 ******************************************************************************/

var pageForm     = document.getElementById("student-form");
var studentID    = document.getElementById("student-id");
var name         = document.getElementById("student-name");
var errorText    = document.getElementById("error");
var errorZone    = document.getElementById("error-message");
var topErrorText = document.getElementById("error-text-top");
var topErrorZone = document.getElementById("error-message-top");

var xmlhttp = new XMLHttpRequest(); // AJAX used to send a SQL request

window.addEventListener("pageshow", function() {
  pageForm.reset();
  errorText.style.display = "none";
  errorZone.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";
});

// Very simple one-line function that is used throughout the project to verify
// numerical user inputs
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

studentID.addEventListener("input", function() {
  var inputValue = studentID.value;

  if (isNumeric(inputValue) || inputValue == '') {
    studentID.style.border = 'none';
    errorText.style.display = "none";
    errorZone.style.display = "none";
  } else { // IDs pretty much have to be numbers, so...
    studentID.style.border = '5px solid red'
    errorText.style.display = "block";
    errorZone.style.display = "block";
    errorZone.style.gridColumn = "1 / 3";
    errorText.innerText = "Please only enter numbers";
  }
});

pageForm.onsubmit = function(event) {
  event.preventDefault();

  // Double verification might seem excessive, but even in my simple testing I 
  // found ways to get around my first line of defense. This just catches 
  // everything that misses the net, at least for now
  if (isNumeric(studentID.value)) {
    xmlhttp.open("POST", "../php/singleUpload.php?name=" + name.value + 
                                      "&id=" + studentID.value, true);
    xmlhttp.send();
    pageForm.reset();
  }
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      window.alert("Student successfully added");
    } else { // Something went wrong when you tried to add the student
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}