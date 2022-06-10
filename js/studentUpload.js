var uploadForm = document.getElementById("upload-form");
var xmlhttp = new XMLHttpRequest();
var errorText = document.getElementById("error-text");
var errorBox = document.getElementById("error-message");
var fileSection = document.getElementById("customFileInput");

window.addEventListener("pageshow", function() {
  fileSection.value = null;
  errorText.style.display = "none";
  errorBox.style.display = "none";
});

uploadForm.onsubmit = function(event) {
  event.preventDefault();
  let formData = new FormData();
  formData.append("file", customFileInput.files[0]);
  xmlhttp.open("POST", "../php/largeUpload.php?submit=value");
  xmlhttp.send(formData);
  fileSection.value = null;
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    var decodeResponse = JSON.parse(this.responseText);
    if (decodeResponse[0] === false) {
      errorText.style.display = "block";
      errorBox.style.display = "block";
      errorText.innerText = "Unsupported file type";
    } else {
      errorText.style.display = "none";
      errorBox.style.display = "none";
      window.alert("File successfully uploaded");
      window.location.replace("./menu.php");
    }
  }
}