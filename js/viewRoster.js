/*******************************************************************************
 * Allows the user to view all of the students at one time, with the option to
 * them individually
 * 
 * PHP: removeTarget.php
 * 
 * HTML: viewRoster.php
 ******************************************************************************/

var triggerRemoval = document.getElementsByClassName("remove-entry");
var timeSection = document.getElementsByClassName("time");

var xmlhttp = new XMLHttpRequest(); // AJAX that is used to remove a student

for (var i = 0; i < triggerRemoval.length; i++) {

  // Some wacky code that adds an "onclick" event listener to a touch point
  // contained in every row of the table
  triggerRemoval[i].addEventListener("click", function() {
  
    // Due to the nature of an HTML table, I can get away with just looking at 
    // row adjacent table entries
    var id   = this.previousElementSibling.innerText;
    var name = this.previousElementSibling.previousElementSibling.innerText;

    // Confirmation before deletion is typically a good thing, especially given
    // the accident potential of my current input method
    if (window.confirm("Are you sure you want to delete " + name + "?")) {
      xmlhttp.open("POST", "../php/removeTarget.php?id=" + id, true);
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