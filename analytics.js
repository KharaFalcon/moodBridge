document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('year-in-pixels');
  const colors = ['red', 'green', 'blue', 'yellow'];

  // Create cells for each day of the year
  for (let i = 0; i < 365; i++) {
    const cell = document.createElement('div');
    cell.className = 'cube';
    cell.addEventListener('click', function () {
      const colorIndex = Math.floor(Math.random() * colors.length);
      this.classList.remove(...colors); // Remove existing color classes
      this.classList.add(colors[colorIndex]); // Apply new color class
    });
    container.appendChild(cell);
  }
});
