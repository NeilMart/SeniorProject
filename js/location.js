/*******************************************************************************
 * Deals with the ability of a student to choose where they will go - requires
 * teacher PIN
 ******************************************************************************/

var linkTarget = "";
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

var olxmlhttp    = new XMLHttpRequest();
var namesxmlhttp = new XMLHttpRequest();
var xmlhttp      = new XMLHttpRequest();

approvalButton.addEventListener("click", grabButtonValue);
denialButton.addEventListener("click", grabButtonValue);

function grabButtonValue() {
  linkTarget = this.name;
}

window.addEventListener("pageshow", function() {
  pageForm.reset();
  teacherSelection.style.display = "none";
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";

  olxmlhttp.open("POST", "../php/loLoad.php", true);
  olxmlhttp.send();

  namesxmlhttp.open("POST", "../php/returnNames.php", true);
  namesxmlhttp.send();
});

olxmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    if (decodedResponse[0]) {
      studentNameSection.innerText = decodedResponse[1];
    } else {
      window.location.href = "./homepage.php";
    }
  }
}

namesxmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    decodedResponse.forEach(item => buildOption(item));
  }
}

function buildOption(item) {
  var name = item[0];

  if (name != "Admin") {
    var clone = teacherTemplate.content.cloneNode(true);
    var option = clone.getElementById("target-option");
    option.value = name;
    option.innerText = name;
    teacherSelection.appendChild(clone);
  }
}

selectMenu.addEventListener("change", function() {
  targetLocation = selectMenu.value;
  if (targetLocation == "teacher") {
    teacherSelection.style.display = "block"
  } else {
    teacherSelection.style.display = "none"
  }

  pin.value = "";
})

teacherSelection.addEventListener("change", function() {
  pin.value = "";
})

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();

  if (linkTarget == "deny") {
    window.location.href = "./homepage.php";
  } else {
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
    } else{
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodedResponse[1];
    }
  }
}