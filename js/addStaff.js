/*******************************************************************************
 * Allows the user to add a single staff member at a time to the staff roster
 * 
 * PHP: staffUpload.php
 * 
 * HTML: addStaff.php
 ******************************************************************************/

var pageForm     = document.getElementById("student-form");
var name         = document.getElementById("name");
var username     = document.getElementById("username");
var password     = document.getElementById("password");
var pin          = document.getElementById("pin");
var adminRights  = document.getElementById("admin");
var topErrorText = document.getElementById("error-text-top");
var topErrorZone = document.getElementById("error-message-top");

var xmlhttp = new XMLHttpRequest(); // AJAX used to send a SQL request

window.addEventListener("pageshow", function() {
  pageForm.reset();
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";
});

// This allows the user to check the box with their enter key, which prevents
// the form from also being submitted
adminRights.addEventListener("keypress", function(event) {
  if (event.key == "Enter") {
    event.preventDefault();
    adminRights.click();
  }
});

pageForm.onsubmit = function(event) {
  event.preventDefault();

  var hasAdmin = 0;

  if (adminRights.checked) {
    hasAdmin = 1;
  }

  xmlhttp.open("POST", "../php/staffUpload.php?name=" + name.value + 
                                    "&username=" + username.value  +
                                    "&password=" + password.value  +
                                    "&pin="      + pin.value +
                                    "&hasAdmin=" + hasAdmin, true);
  xmlhttp.send();
  pageForm.reset();
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      window.alert("Staff successfully added");
    } else { // something went wrong when you tried to add a staff member
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}