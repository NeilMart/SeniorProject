var pageForm           = document.getElementById("page-form");
var teacherSelection   = document.getElementById("teachers");
var teacherTemplate    = document.getElementById("teacher-option");
var topErrorText = document.getElementById("error-text-top");
var topErrorZone = document.getElementById("error-message-top");

var xmlhttp      = new XMLHttpRequest();
var namesxmlhttp = new XMLHttpRequest();

window.addEventListener("pageshow", function() {
  pageForm.reset();
  topErrorText.style.display = "none";
  topErrorZone.style.display = "none";
  namesxmlhttp.open("POST", "../php/returnUsernames.php", true);
  namesxmlhttp.send();
});

namesxmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    decodedResponse.forEach(item => buildOption(item));
  }
}

function buildOption(item) {
  var name = item[0];
  var clone = teacherTemplate.content.cloneNode(true);
  var option = clone.getElementById("target-option");
  option.value = name;
  option.innerText = name;
  teacherSelection.appendChild(clone);
}

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();
  xmlhttp.open("POST", "../php/staffRemove.php?name=" + teacherSelection.value, true);
  xmlhttp.send();
});

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodedResponse = JSON.parse(this.responseText);
    if (decodedResponse[0]) {
      topErrorText.style.display = "none";
      topErrorZone.style.display = "none";
      location.reload();
    } else {
      topErrorText.style.display = "block";
      topErrorZone.style.display = "block";
      topErrorText.innerText = decodedResponse[1];
    }
  }
}