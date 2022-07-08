/*******************************************************************************
 * Allows the user to view all of the students at one time, with the option to
 * them individually
 * 
 * PHP: removePermissions.php
 * 
 * HTML: viewPermissions.php
 ******************************************************************************/

 var triggerRemoval = document.getElementsByClassName("remove-entry");
 
 var xmlhttp = new XMLHttpRequest(); // AJAX that is used to remove a student
 
 for (var i = 0; i < triggerRemoval.length; i++) {
 
   // Some wacky code that adds an "onclick" event listener to a touch point
   // contained in every row of the table
   triggerRemoval[i].addEventListener("click", function() {
   
     // Due to the nature of an HTML table, I can get away with just looking at 
     // row adjacent table entries
     var name2 = this.previousElementSibling.innerText;
     var name1 = this.previousElementSibling.previousElementSibling.innerText;
 
     // Confirmation before deletion is typically a good thing, especially given
     // the accident potential of my current input method
     if (window.confirm("Are you sure you want to delete the restriction between " + name1 + " and " + name2 + "?")) {
       xmlhttp.open("POST", "../php/removePermission.php?name1=" + name1 + "&name2=" + name2, true);
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