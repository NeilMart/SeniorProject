var linkTarget = "";
var targetLocation = "";

var studentNameSection = document.getElementById("stu-name");
var selectMenu         = document.getElementById("location");
var pageForm           = document.getElementById("page-form");
var approvalButton     = document.getElementById("approve");
var denialButton       = document.getElementById("deny");
var teacherSelection   = document.getElementById("teachers");
var teacherTemplate    = document.getElementById("teacher-option");

var olxmlhttp    = new XMLHttpRequest();
var namesxmlhttp = new XMLHttpRequest();

approvalButton.addEventListener("click", grabButtonValue);
denialButton.addEventListener("click", grabButtonValue);

function grabButtonValue() {
  linkTarget = this.name;
}

window.addEventListener("pageshow", function() {
  pageForm.reset();
  teacherSelection.style.display = "none";
  // errorText.style.display = "none";
  // errorZone.style.display = "none";
  // topErrorText.style.display = "none";
  // topErrorZone.style.display = "none";

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
  var clone = teacherTemplate.content.cloneNode(true);
  var option = clone.getElementById("target-option");
  option.value = name;
  option.innerText = name;
  teacherSelection.appendChild(clone);
}

selectMenu.addEventListener("change", function() {
  targetLocation = selectMenu.value;
  if (targetLocation == "teacher") {
    teacherSelection.style.display = "block"
  } else {
    teacherSelection.style.display = "none"
  }
})

pageForm.addEventListener("submit", function(event) {
  event.preventDefault();

  if (linkTarget == "deny") {
    window.location.href = "./homepage.php";
  } else {

  }
});