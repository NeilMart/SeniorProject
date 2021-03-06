/*******************************************************************************
 * Connected to the sign in homepage, allows students to check out of or into 
 * the class
 * 
 * PHP: checkout.php
 *      checkIn.php
 *      coLoad.php
 * 
 * HTML: homepage.php
 ******************************************************************************/

var linkTarget = ""; // Just initializing some variables, nothing exciting
var currentTime = 0;

var checkOutButton = document.getElementById("checkout");
var checkInButton  = document.getElementById("checkin");
var pageForm       = document.getElementById("page-form");
var studentID      = document.getElementById("student-id");
var errorText      = document.getElementById("error");
var errorZone      = document.getElementById("error-message");
var topErrorText   = document.getElementById("error-text-top");
var topErrorZone   = document.getElementById("error-message-top");

var xmlhttp   = new XMLHttpRequest(); // AJAX for check out
var cixmlhttp = new XMLHttpRequest(); // AJAX for check in
var olxmlhttp = new XMLHttpRequest(); // AJAX on load

checkOutButton.addEventListener("click", grabButtonValue);
checkInButton.addEventListener("click", grabButtonValue);

window.addEventListener("pageshow", function() {
  pageForm.reset();
  errorText.style.display = "none";
  errorZone.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";

  // Like I mentioned above, this is an AJAX script that needs to run every time
  // the page is loaded ... it is a janitor service that cleans up the queue 
  // generated by this machine, preventing the scenario where a student becomes
  // trapped in a "half checked out" state
  olxmlhttp.open("POST", "../php/coLoad.php", true);
  olxmlhttp.send();
});

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();

  // Double verification might seem excessive, but even in my simple testing I 
  // found ways to get around my first line of defense. This just catches 
  // everything that misses the net, at least for now
  if (isNumeric(studentID.value)) {

    // There is a different PHP file for each type of submission - this allows
    // me to catch the unique outputs that each scenario is associated with
    if (linkTarget == "checkout") {
      xmlhttp.open("POST", "../php/checkOut.php?id=" + studentID.value, true);
      xmlhttp.send();
      pageForm.reset();
    } else if (linkTarget == "checkin") {
      cixmlhttp.open("POST", "../php/checkIn.php?id=" + studentID.value, true);
      cixmlhttp.send();
      pageForm.reset();
    }
  }
});

// Very simple one-line function that is used to figure out which of the two 
// form submission buttons the user clicked on
function grabButtonValue() {
  linkTarget = this.name;
}

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

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      window.location.href = './location.php';
    } else { // something went wrong when you checked out
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}

cixmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      window.alert("You've signed in");
    } else { // something went wrong when you checked in
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}