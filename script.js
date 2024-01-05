const cells = document.querySelectorAll(".cell");
var buttonSave = document.querySelectorAll(".saveBtn");
var buttons = document.querySelectorAll(".btn");

// Create an array to store emotions with dots
let emotionsWithDots = [];
//creates an array to store activities selected
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
        //if statment to only select one emotion
        if(emotionsWithDots.length < 5){
        const dot = document.createElement("div");
        dot.classList.add("dot");

        // Append the dot to the cell
        cell.appendChild(dot);

        // Remove the "hovered" class from the cell
        cell.classList.remove("hovered");
    
           // Get the emotion ID from the cell
        const emotionId = cell.id;

        // Add the emotion to the array if not already added
        if (!emotionsWithDots.includes(emotionId)) {
            emotionsWithDots.push(emotionId);
        }}
        else {
            //error message for only having five emotions needs adding 
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
            const index = emotionsWithDots.indexOf(emotionId);
            if (index !== -1) {
                emotionsWithDots.splice(index, 1);
            }
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
        const emotionsText = emotionIds.map(emotionId => {
            const selectedEmotion = document.getElementById(emotionId);
            return selectedEmotion.textContent;
        }).join(', ');

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

              // Get the activity ID from the btns
        const activityId = button.id;
            //adds activitiy to array if it has not already been added
                     // Check if the button was clicked for the second time
            if (clickCounts[activityId] % 2 === 0) {
                // If it was clicked for the second time, remove the activity from the array
                const index = activities.indexOf(activityId);
                if (index !== -1) {
                    activities.splice(index, 1);
                }
            } else {
                // If it was clicked for the first time, add the activity to the array
                if (!activities.includes(activityId)) {
                    activities.push(activityId);
                }
            }
console.log(activities);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    buttonSave.forEach(function (button) {
        button.addEventListener("click", function () {
            // Toggle the 'clicked' class on the clicked button
            button.classList.toggle("saved");

             // Send emotions and activities data to the server using AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "save_data.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            const emotionsData = "emotions=" + JSON.stringify(emotionsWithDots);
            const activitiesData = "activities=" + JSON.stringify(activities);

            xhr.send(emotionsData + "&" + activitiesData);

             // Remove the 'clicked' class from all buttons
            buttons.forEach(function (btn) {
                btn.classList.remove("clicked");
         
            });
    });
});
});

// Function to get the current date and time
function getCurrentDate() {
  const dateTime = new Date();
  return dateTime.toLocaleDateString();

 
}

// Target an HTML element to display the current date and time
const dateDisplay = document.getElementById("date-container");

// Set the innerHTML of the element to the current date and time returned by the function
dateDisplay.innerHTML = getCurrentDate();
