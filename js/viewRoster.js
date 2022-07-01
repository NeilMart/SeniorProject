var triggerRemoval = document.getElementsByClassName("remove-entry");
var timeSection = document.getElementsByClassName("time");

var xmlhttp = new XMLHttpRequest();

for (var i = 0; i < triggerRemoval.length; i++) {
  triggerRemoval[i].addEventListener("click", function() {
    var id   = this.previousElementSibling.innerText;
    var name = this.previousElementSibling.previousElementSibling.innerText;
    if (window.confirm("Are you sure you want to delete " + name + "?")) {
      xmlhttp.open("POST", "../php/removeTarget.php?id=" + id, true);
      xmlhttp.send();
    }
  })
}

xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    location.reload();
  }
}