/*******************************************************************************
 * Allows the admin to view all of the staff members at once, with the option to
 * individually remove them
 * 
 * PHP: staffRemove.php
 * 
 * HTML: viewStaff.php
 ******************************************************************************/

var triggerRemoval = document.getElementsByClassName("remove-entry");
var adminRights    = document.getElementsByClassName("has-admin");

var xmlhttp = new XMLHttpRequest(); // AJAX that is used to remove staff

for (var i = 0; i < triggerRemoval.length; i++) {

  // Some wacky code that adds an "onclick" event listener to a touch point
  // contained in every row of the table
  triggerRemoval[i].addEventListener("click", function() {

    // Due to the nature of an HTML table, I can get away with just looking at 
    // row adjacent table entries
    var name     = this.previousElementSibling.previousElementSibling.innerText;
    var username = this.previousElementSibling.previousElementSibling.previousElementSibling.innerText;

    // Confirmation before deletion is typically a good thing, especially given
    // the accident potential of my current input method
    if (window.confirm("Are you sure you want to delete " + name + "?")) {
      xmlhttp.open("POST", "../php/staffRemove.php?name=" + username, true);
      xmlhttp.send();
    }
  })
}

// Reload the page every time an entry is deleted
xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    location.reload();
  }
}

for (var i = 0; i < adminRights.length; i++) {
  if (adminRights[i].innerText == "1") {
    adminRights[i].innerText = "Yes";
  } else {
    adminRights[i].innerText = "No";
  }
}