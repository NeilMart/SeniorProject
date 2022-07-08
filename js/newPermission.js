/*******************************************************************************
 * Updates the student permission JSON file so that the new restriction is
 * recorded
 * 
 * PHP: writePermission.php
 * 
 * HTML: addNewPermission.php
 ******************************************************************************/

var pageForm     = document.getElementById("student-form");
var studentID1   = document.getElementById("stuID1");
var studentID2   = document.getElementById("stuID2");
var errorText    = document.getElementById("error");
var errorZone    = document.getElementById("error-message");
var errorText2   = document.getElementById("error-2");
var errorZone2   = document.getElementById("error-message-2");
var topErrorText = document.getElementById("error-text-top");
var topErrorZone = document.getElementById("error-message-top");

var xmlhttp = new XMLHttpRequest(); // AJAX used to send a SQL request

window.addEventListener("pageshow", function() {
  pageForm.reset();
  errorText.style.display = "none";
  errorZone.style.display = "none";
  errorText2.style.display = "none";
  errorZone2.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";
});

// Very simple one-line function that is used throughout the project to verify
// numerical user inputs
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

// Error checking for the 1st student ID portion of the application
studentID1.addEventListener("input", function() {
  var inputValue = studentID1.value;

  if (isNumeric(inputValue) || inputValue == '') {
    studentID1.style.border = 'none';
    errorText.style.display = "none";
    errorZone.style.display = "none";
  } else { // IDs pretty much have to be numbers, so...
    studentID1.style.border = '5px solid red'
    errorText.style.display = "block";
    errorZone.style.display = "block";
    errorZone.style.gridColumn = "1 / 3";
    errorText.innerText = "Please only enter numbers";
  }
});

// Error checking for the 2nd student ID portion of the application
studentID2.addEventListener("input", function() {
  var inputValue = studentID2.value;

  if (isNumeric(inputValue) || inputValue == '') {
    studentID2.style.border = 'none';
    errorText2.style.display = "none";
    errorZone2.style.display = "none";
  } else { // IDs pretty much have to be numbers, so...
    studentID2.style.border = '5px solid red'
    errorText2.style.display = "block";
    errorZone2.style.display = "block";
    errorZone2.style.gridColumn = "1 / 3";
    errorText2.innerText = "Please only enter numbers";
  }
});

// Submit the user's form, assuming they did everything correctly
pageForm.onsubmit = function(event) {
  event.preventDefault();

  const ID1 = studentID1.value;
  const ID2 = studentID2.value;

  // If the values are not numbers, no submission is possible
  if (isNumeric(ID1) && isNumeric(ID2)) {
    xmlhttp.open("POST", "../php/writePermission.php?ID1=" + ID1 + 
                                      "&ID2=" + ID2, true);
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
      window.alert("Restriction added!");
    } else {
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}