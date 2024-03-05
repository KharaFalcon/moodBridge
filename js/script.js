const cells = document.querySelectorAll(".cell");
var buttonSubmit = document.querySelectorAll(".submitBtn");
var buttons = document.querySelectorAll(".btn");

// Create an array to store emotions with dots
let emotionsWithDots = [];
// Creates an array to store activities selected
let activities = [];

// Loop through each cells element
cells.forEach(cell => {
    // When a draggable element is dragged over a cell element
    cell.addEventListener("dragover", (e) => {
        e.preventDefault(); // Prevent default behavior
        cell.classList.add("hovered");
    });

    // When a draggable element leaves the cell element
    cell.addEventListener("dragleave", () => {
        cell.classList.remove("hovered");
    });

    // When a draggable element is dropped on a cell element
    cell.addEventListener("drop", (e) => {
        e.preventDefault(); // Prevent default behavior

        // Create a dot element
        // if statement to only select one emotion
        if (emotionsWithDots.length < 5) {
            const dot = document.createElement("div");
            dot.classList.add("dot");

            // Append the dot to the cell
            cell.appendChild(dot);

            // Remove the "hovered" class from the cell
            cell.classList.remove("hovered");

            // Get the emotion ID from the cell
            const emotionId = cell.id;
            const emotionName = cell.textContent;

            // Add the emotion to the array if not already added
            if (!emotionsWithDots.some(emotion => emotion.id === emotionId)) {
                emotionsWithDots.push({ id: emotionId, name: emotionName });
            }
        } else if (emotionsWithDots.length >= 5) {
            // error message for only having five emotions
            const emotionError = document.getElementById('errorMsg');
            // Check if there is an error

            var errorMsgContent = "Maximum Emotions Exceeded. You can select up to 5 emotions. If you want to add a new emotion, please remove one of your existing selections by clicking on it.";
            if (errorMsgContent != null) {
                // If there is an error, set the border
                errorMsg.style.border = "solid rgb(190, 61, 61)";
                errorMsg.style.padding = "10px";
                errorMsg.style.background = "rgba(224, 118, 118, 0.559)";

                // Display the error message for 30 seconds
                setTimeout(function () {
                    // Remove the border and reset the content after 30 seconds
                    errorMsg.style.border = "none";
                    errorMsg.style.padding = "none";
                    emotionError.textContent = "";
                    errorMsg.style.background = "none";
                }, 15000); // 30 seconds in milliseconds

                emotionError.textContent = errorMsgContent;
                console.log("error");
            }
        }

        else if (emotionsWithDots.length === 3) {
            emotionError.textContent = "";  // Set the error message content to an empty string
            emotionError.style.border = "none";  // Reset the border style
            emotionError.style.padding = "none";  // Reset the padding style
            console.log("no error")
        }
        console.log(emotionsWithDots);
        displayEmotion(emotionsWithDots);

        cell.addEventListener("click", (e) => {
            const dot = e.target.closest(".dot");
            if (dot) {
                // Remove the dot from the cell
                dot.remove();

                // Get the emotion ID from the cell
                const emotionId = cell.id;

                // Remove the emotion from the array
                emotionsWithDots = emotionsWithDots.filter(emotion => emotion.id !== emotionId);
            }

            displayEmotion(emotionsWithDots);
            console.log(emotionsWithDots);
        });
    });
});



function displayEmotion(emotionIds) {
    // Get the display area element
    const displayArea = document.getElementById('selectedEmotion');

    // Check if there are any emotions to display
    if (emotionIds.length > 0) {
        // Get the text content of each emotion and join them into a string
        const emotionsText = emotionIds.map(emotion => emotion.name).join(', ');

        // Display the emotions text in the <p> tag
        displayArea.textContent = emotionsText;
    } else {
        // If there are no emotions, display a default message
        displayArea.textContent = 'No emotions selected';
    }

}

const clickCounts = {};
document.addEventListener("DOMContentLoaded", function () {
    buttons.forEach(function (button) {
        clickCounts[button.id] = 0;
        button.addEventListener("click", function () {
            clickCounts[button.id]++;
            // Toggle the 'clicked' class on the clicked button
            button.classList.toggle("clicked");

            // Get the activity ID and name from the button
            const activityId = button.id;
            const activityName = button.value;

            // Check if the button was clicked for the second time
            if (clickCounts[activityId] % 2 === 0) {
                // If it was clicked for the second time, remove the activity from the array
                const index = activities.findIndex(activity => activity.id === activityId);
                if (index !== -1) {
                    activities.splice(index, 1);
                }
            } else {
                // If it was clicked for the first time, add the activity to the array
                if (!activities.some(activity => activity.id === activityId)) {
                    activities.push({ id: activityId, name: activityName });
                }
            }
            console.log(activities);
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    // Assuming buttonSubmit, emotionsWithDots, buttons, and activities are defined
    buttonSubmit.forEach(function (button) {
        button.addEventListener("click", function () {
             const notes = document.getElementById('notesInput').value;
            console.log(notes)
            // Toggle the 'saved' class on the clicked button
          if (canSaveToday()) {
                // Toggle the 'saved' class on the clicked button
                button.classList.toggle("saved");

                // Send emotions and activities data to the server using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "save_data.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // Modify this part to include both name and id in emotionsData
                const emotionsData = "emotions=" + JSON.stringify(emotionsWithDots.map(emotion => ({ id: emotion.id, name: emotion.name })));
                const activitiesData = "activities=" + JSON.stringify(activities.map(activity => ({ id: activity.id, name: activity.name })));
                const notesData = "notes=" + encodeURIComponent(notes); // Encode notes to handle special characters

                console.log("Emotions data sent:", emotionsData);
                console.log("Activities data sent:", activitiesData);
                console.log("Notes data sent:", notesData);

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            console.log(xhr.responseText); // Log the server's response
                        } else {
                            console.error("Error occurred during the request.");
                        }
                    }
                };

                // Send the data to the server
                xhr.send(emotionsData + '&' + activitiesData  + '&' + notesData);

                // Save the current date as the last saved date
                saveCurrentDate();

                // Remove the 'clicked' class from all buttons
                buttons.forEach(function (btn) {
                    btn.classList.remove("clicked");
                });
            } else {
                // Display an error message or take any appropriate action
                console.log("You have already saved today.");
                const errorDayMax = document.getElementById('errorDayMax');
                // Check if there is an error
                var errorDayMsgContent = "You have already added your daily entry";
                   errorDayMax.textContent = errorDayMsgContent;


                   
            }
        });
    });

    // Function to check if the user can save today
    function canSaveToday() {
        const lastSavedDate = localStorage.getItem("lastSavedDate");
        const currentDate = getCurrentDate();
        return lastSavedDate !== currentDate;
    }

    // Function to save the current date
    function saveCurrentDate() {
        const currentDate = getCurrentDate();
        localStorage.setItem("lastSavedDate", currentDate);
    }
});

// Function to get the current date and time
function getCurrentDate() {
    const dateTime = new Date();
    return dateTime.toLocaleDateString();
}
document.addEventListener('DOMContentLoaded', function () {
  const dateDisplay = document.getElementById('date-container');
  if (dateDisplay) {
    dateDisplay.innerHTML = getCurrentDate();
  } else {
    console.error('date-container element not found.');
  }
});
