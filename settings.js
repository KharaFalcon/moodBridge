function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();


     function updateAvatar() {
        var input = document.getElementById('avatar-input');
        var image = document.getElementById('avatar-image');

        var file = input.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function (e) {
                image.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    }

     function removeAvatar() {
        var image = document.getElementById('avatar-image');
        image.src = 'avatar.png'; // Set the default avatar image path
    }