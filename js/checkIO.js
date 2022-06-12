var linkTarget = "";
var currentTime = 0;

var checkOutButton = document.getElementById("checkout");
var checkInButton  = document.getElementById("checkin");
var pageForm       = document.getElementById("page-form");
var studentID      = document.getElementById("student-id");
var errorText      = document.getElementById("error");
var errorZone      = document.getElementById("error-message");
var topErrorText   = document.getElementById("error-text-top");
var topErrorZone   = document.getElementById("error-message-top");

var xmlhttp = new XMLHttpRequest();

checkOutButton.addEventListener("click", grabButtonValue);
checkInButton.addEventListener("click", grabButtonValue);

window.addEventListener("pageshow", function() {
  pageForm.reset();
  errorText.style.display = "none";
  errorZone.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";
});

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();

  if (isNumeric(studentID.value)) {
    if (linkTarget == "checkout") {
      var today = new Date();
      currentTime = Math.round(today.getTime() / 1000 / 60);
      xmlhttp.open("POST", "../php/checkOut.php?id=" + studentID.value + "&time=" + currentTime, true);
      xmlhttp.send();
      pageForm.reset();
    }
    else {

    }
  }
});

function grabButtonValue() {
  linkTarget = this.name;
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

studentID.addEventListener("input", function() {
  var inputValue = studentID.value;
  if (isNumeric(inputValue) || inputValue == '') {
    studentID.style.border = 'none';
    errorText.style.display = "none";
    errorZone.style.display = "none";
  } else {
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
      window.alert("Checked out");
    } else {
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodeResponse[1];
    }
  }
}