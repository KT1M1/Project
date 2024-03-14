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

     // Like feature: When the empty heart is clicked, it sends a like request
    emptyHeart.addEventListener('click', function () {
        if (typeof food_id !== 'undefined' && typeof user_id !== 'undefined') {
            fullHeart.style.display = 'block';
            emptyHeart.style.display = 'none';

            set_like(food_id, user_id);
        }
    });

    // Remove like feature: When the full heart is clicked, it sends a remove like request
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

    console.log("Like Set")

    // Send a request to the server to set a like
    fetch(`/server/like.php?food_id=${food_id}&user_id=${user_id}`)
        .then(response => response.json())
        .then(data => {
            console.log( data );
             // Increment the like count displayed next to the heart icon
            emptyHeart.nextElementSibling.innerHTML = (emptyHeart.nextElementSibling.innerHTML * 1) + 1;
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}

function remove_like(food_id, user_id) {
    var emptyHeart = document.getElementById('heart');

    console.log("Like Removed")

    // Send a request to the server to remove a like
    fetch(`/server/remove_like.php?food_id=${food_id}&user_id=${user_id}`)
        .then(response => response.json())
        .then(data => {
            console.log( data );
            // Decrement the like count displayed next to the heart icon
            emptyHeart.nextElementSibling.innerHTML = (emptyHeart.nextElementSibling.innerHTML * 1) - 1;
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        });
}