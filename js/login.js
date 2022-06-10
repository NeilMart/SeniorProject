var xmlhttp = new XMLHttpRequest();
var xmlhttpLO = new XMLHttpRequest();
var accessForm = document.getElementById("login-form");
var errorText = document.getElementById("error-text");
var errorBox = document.getElementById("error-message");

window.addEventListener("pageshow", function() {
  accessForm.reset();
  errorText.style.display = "none";
  errorBox.style.display = "none";
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
    } else {
      const destination = document.getElementById("status");
      errorText.style.display = "none";
      errorBox.style.display = "none";
      if (destination.value === "teacher") {
        window.location.href = './teacher/checkout.php';
      } else if (destination.value === "admin") {
        window.location.href = './admin/menu.php';
      }
    }
  }
}