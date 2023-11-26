const cells = document.querySelectorAll(".cell");
var buttonSave = document.querySelectorAll(".saveBtn");
var buttons = document.querySelectorAll(".btn");

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
        console.log(cell.id);
        displayEmotion(cell.id);
    });
});

   function displayEmotion(emotionId) {
            // Find the selected emotion div
            const selectedEmotion = document.getElementById(emotionId);
            // Get the text content of the selected emotion
            const emotionText = selectedEmotion.textContent;

            // Display the selected emotion text in the <p> tag
            const displayArea = document.getElementById('selectedEmotion');
            displayArea.textContent = emotionText;
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
