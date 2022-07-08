/*******************************************************************************
 * This is the software that allows the user to upload an entire student roster
 * at once
 * 
 * PHP: largeUpload.php
 * 
 * HTML: uploadRoster.php
 ******************************************************************************/

var uploadForm  = document.getElementById("upload-form");
var errorText   = document.getElementById("error-text");
var errorBox    = document.getElementById("error-message");
var fileSection = document.getElementById("customFileInput");

var xmlhttp = new XMLHttpRequest(); // AJAX that handles the .csv file / SQL

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
    } else { // the user provided a valid file
      errorText.style.display = "none";
      errorBox.style.display = "none";
      window.alert("File successfully uploaded");
      history.back();
      history.back();
    }
  }
}