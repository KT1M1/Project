// JavaScript code to handle checkbox changes
document.addEventListener('DOMContentLoaded', function () {
    const ingredientList = document.getElementById('ingredientList');
    ingredientList.addEventListener('change', function (event) {
        const checkbox = event.target;
        if (checkbox.classList.contains('ing-cb')) {
            const label = checkbox.nextElementSibling;
            if (checkbox.checked) {
                label.classList.add('completed');
            } else {
                label.classList.remove('completed');
            }
        }
    });
});