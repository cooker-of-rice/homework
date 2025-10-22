let squareCount = 0;

function spawnSquare() {
    squareCount++;
    const container = document.getElementById('container');
    const square = document.createElement('div');
    square.className = 'square';
    square.textContent = '#' + squareCount;
    container.appendChild(square);

    // Show the delete button when there are squares
    document.getElementById('deleteBtn').style.display = 'block';
}

function deleteSquares() {
    const container = document.getElementById('container');
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }

    // Return to 0
    squareCount = 0;

    // Hide the delete button when there are no squares
    document.getElementById('deleteBtn').style.display = 'none';
}
