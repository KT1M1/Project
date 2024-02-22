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

document.addEventListener('DOMContentLoaded', function () {

    var fullHeart = document.getElementById('full-heart');
    var emptyHeart = document.getElementById('heart');

    emptyHeart.addEventListener('click', function () {
        fullHeart.style.display = 'block';
        emptyHeart.style.display = 'none';
    });

    fullHeart.addEventListener('click', function () {
        fullHeart.style.display = 'none';
        emptyHeart.style.display = 'block';
    });
});