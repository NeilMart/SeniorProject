/*******************************************************************************
 * Allows a user to login to the application, logging out the previous user
 * whenever the page is loaded ... in theory this should increase the security
 * of the application
 * 
 * PHP: logout.php
 *      login.php
 * 
 * HTML: index.html
 ******************************************************************************/

var accessForm = document.getElementById("login-form");
var errorText  = document.getElementById("error-text");
var errorBox   = document.getElementById("error-message");

var xmlhttp   = new XMLHttpRequest(); // AJAX used to log in the user
var xmlhttpLO = new XMLHttpRequest(); // AJAX used to logout the user

window.addEventListener("pageshow", function() {
  accessForm.reset();
  errorText.style.display = "none";
  errorBox.style.display = "none";

  // Whenever this page is displayed, logout the current user ... this works
  // well both from functional and user points of view
  xmlhttpLO.open("POST", "./php/logout.php", true);
  xmlhttpLO.send();
});

accessForm.onsubmit = function(event) {
  event.preventDefault();

  const username = document.getElementById("username");
  const password = document.getElementById("password");
  
  xmlhttp.open("POST", "./php/login.php?username=" + username.value + 
                                     "&password=" + password.value, true);
  xmlhttp.send();
  password.value = "";
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[1] === false) {
      errorText.style.display = "block";
      errorBox.style.display = "block";
      errorText.innerText = decodeResponse[0];
    } else { // the user provided valid credentials
      const destination = document.getElementById("status");
      errorText.style.display = "none";
      errorBox.style.display = "none";

      // The application's default destination is the signout splash screen, but
      // certain approved users might get thrown onto the admin page instead
      if (destination.value == "teacher") {
        window.location.href = './teacher/homepage.php';
      } else if (destination.value == "admin") {
        window.location.href = './admin/menu.php';
      }
    }
  }
}