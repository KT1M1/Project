function triggerFileInput() {
    document.getElementById('file-input').click();
}

function displayImage(input) {
    const dropContainer = document.getElementById('drop-container');
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
        dropContainer.innerHTML = `<img class="uploaded-img" src="${e.target.result}" alt="Uploaded Image">`;
        };

        reader.readAsDataURL(file);
    }
}

function displaySelect() {
    var foEtelformDiv = document.getElementById('foEtelformDiv');
    var kozEtelformDiv = document.getElementById('kozEtelformDiv');
    var deszertformDiv = document.getElementById('deszertformDiv');

    foEtelformDiv.style.display = 'none';
    kozEtelformDiv.style.display = 'none';
    deszertformDiv.style.display = 'none';

    var selectedValue = document.getElementById('kategoria').value;
    document.getElementById('foEtelformDiv').style.display = 'block';
}

function addIngredient() {
    var newIngredient = document.createElement("div");
    newIngredient.className = "hozzavalo-div";
    newIngredient.innerHTML = `
        <div>
            <label class="hozzavalo-lbl">Hozzávaló:</label>
            <input type="text" class="hozzavalo" name="ingredient_name[]" oninput="suggest_ingredients(this)" required>
            <div></div>
        </div>
        
        <label class="hozzavalo-lbl">Mennyiség:</label>
        <input type="number" class="hozzavalo" name="ingredient_quantity[]" min="1" required>

        ${units_template}

        <button type="button" class="remove-btn" onclick="removeElement(this)">x</button>
    `;

    document.querySelector(".ingredient-container").appendChild(newIngredient);
}

function addStep() {
    var newStep = document.createElement("div");
    newStep.className = "lepes-div";
    newStep.innerHTML = `
        <input type="text" class="lepes lepes-x" name="step[]" required>
        <button type="button" class="remove-btn" onclick="removeElement(this)">x</button>
    `;

    document.querySelector(".step-container").appendChild(newStep);
}

function removeElement(element) {
    var parentElement = element.parentNode;
    parentElement.parentNode.removeChild(parentElement);
}

//Textarea
document.addEventListener('DOMContentLoaded', function () {
    var textarea = document.getElementById('description');
    var charCount = document.getElementById('charCount');

    textarea.addEventListener('input', function () {
        var currentLength = textarea.value.length;
        charCount.textContent = `${currentLength}/300`;
    });
});

//Modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("modalBtn");
var span = document.getElementsByClassName("close")[0];
var body = document.body;

btn.onclick = function() {
    modal.style.display = "block";
    body.style.overflow = "hidden"; // Prevent body scrolling
};

span.onclick = function() {
    modal.style.display = "none";
    body.style.overflow = "";
};

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        body.style.overflow = "";
    }
};


//Suggest Ingredient
document.getElementById('ingredient_name').addEventListener('input', function() {
    suggest_ingredients(this)
});

function suggest_ingredients(input) {
    let suggest_area = input.nextElementSibling;

    let keyword = input.value;
    if (keyword.length >= 1) {
        // Fetch data from server
        fetch('/server/suggest_ingredient.php?keyword=' + keyword)
            .then(response => response.json())
            .then(data => {
                var suggestionHTML = '';
                data.forEach(function(ingredient) {
                    suggestionHTML += '<div class="suggestion" onclick="selectIngredient(this, \'' + ingredient.name + '\')">' + ingredient.name + '</div>';
                });
                suggest_area.innerHTML = suggestionHTML;
            });
    } else {
        suggest_area.innerHTML = '';
    }
}

function selectIngredient(element, value) {
    element.parentElement.previousElementSibling.value = value
    element.parentElement.innerHTML = ''
}

