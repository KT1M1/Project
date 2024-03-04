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
        if (typeof food_id !== 'undefined' && typeof user_id !== 'undefined') {
            fullHeart.style.display = 'block';
            emptyHeart.style.display = 'none';

            set_like(food_id, user_id);
        }
    });

    fullHeart.addEventListener('click', function () {
        if (typeof food_id !== 'undefined' && typeof user_id !== 'undefined') {
            fullHeart.style.display = 'none';
            emptyHeart.style.display = 'block';

            remove_like(food_id, user_id);
        }
    });

});

function set_like(food_id, user_id) {
    var emptyHeart = document.getElementById('heart');

    console.log("Lefutott")

    fetch(`/server/like.php?food_id=${food_id}&user_id=${user_id}`)
        .then(response => response.json())
        .then(data => {
            console.log( data );
            emptyHeart.nextElementSibling.innerHTML = (emptyHeart.nextElementSibling.innerHTML * 1) + 1;
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

function remove_like(food_id, user_id) {
    var emptyHeart = document.getElementById('heart');

    console.log("Lefutott")

    fetch(`/server/remove_like.php?food_id=${food_id}&user_id=${user_id}`)
        .then(response => response.json())
        .then(data => {
            console.log( data );
            emptyHeart.nextElementSibling.innerHTML = (emptyHeart.nextElementSibling.innerHTML * 1) - 1;
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}