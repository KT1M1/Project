// Select all delete buttons
var deleteButtons = document.querySelectorAll('.delete-cube');

// Attach a click event listener to each button
deleteButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        // Show confirmation dialog
        var confirmDelete = confirm('Biztos ki szeretnéd törölni ezt a receptet?');
        if (!confirmDelete) {
            // If user clicks 'Cancel', prevent the form from submitting
            event.preventDefault();
        }
    });
});

