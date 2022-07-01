var triggerRemoval = document.getElementsByClassName("remove-entry");

var xmlhttp = new XMLHttpRequest();

for (var i = 0; i < triggerRemoval.length; i++) {
  triggerRemoval[i].addEventListener("click", function() {
    var name     = this.previousElementSibling.innerText;
    var username = this.previousElementSibling.previousElementSibling.innerText;
    if (window.confirm("Are you sure you want to delete " + name + "?")) {
      xmlhttp.open("POST", "../php/staffRemove.php?name=" + username, true);
      xmlhttp.send();
    }
  })
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    location.reload();
  }
}