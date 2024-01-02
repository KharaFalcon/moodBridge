const cells = document.querySelectorAll(".cell");
var buttonSave = document.querySelectorAll(".saveBtn");
var buttons = document.querySelectorAll(".btn");

// Create an array to store emotions with dots
let emotionsWithDots = [];

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
        }

        console.log(emotionsWithDots);
        displayEmotion(emotionsWithDots);
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



document.addEventListener("DOMContentLoaded", function () {


    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            // Toggle the 'clicked' class on the clicked button
            button.classList.toggle("clicked");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
   
    buttonSave.forEach(function (button) {
        button.addEventListener("click", function () {
            // Toggle the 'clicked' class on the clicked button
            button.classList.toggle("saved");

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
