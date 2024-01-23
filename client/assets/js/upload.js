
function displayMainCategory() {
    let element = document.getElementById("main-category");

    let html = `<select name="category[]" id="main-kategoria" required onchange="mainCategoryAction(this.value)">`;
    html += `<option selected="true" disabled="disabled">Főkategória</option>`;

    for(let cat of categories) {
        html += `<option value="${cat.id}">${cat.name}</option>`;
    }

    html += `</select>`;

    element.innerHTML = html;
}

function getSubCategories(main_cat_id) {
    for(let cat of categories) {
        if(main_cat_id == cat.id) {
            return cat.subcategories;
        }
    }

    return null;
}

function displaySubCategory(main_cat_id) {
    let element = document.getElementById("sub-category");

    let html = `<select name="category[]" id="sub-kategoria" required>`;
    html += `<option selected="true" disabled="disabled">Alkategória</option>`;

    subcategories = getSubCategories(main_cat_id);
    for(let cat of subcategories) {
        html += `<option value="${cat.id}">${cat.name}</option>`;
    }

    html += `</select>`;
    element.innerHTML = html;
}

function mainCategoryAction(id) {
    displaySubCategory(id);
}


displayMainCategory();





function triggerFileInput() {
    document.getElementById('file-input').click();
}

function displayImage(input) {
    const dropContainer = document.getElementById('drop-container');
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
        dropContainer.innerHTML = `<img src="${e.target.result}" alt="Uploaded Image">`;
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
        <label class="hozzavalo-lbl">Hozzávaló:</label>
        <input type="text" class="hozzavalo" name="hozzavalo_nev[]" required>

        <label class="hozzavalo-lbl">Mennyiség:</label>
        <input type="number" class="hozzavalo" name="hozzavalo_mennyiseg[]" min="1" required>

        ${units_template}

        <button type="button" class="remove-btn" onclick="removeElement(this)">x</button>
    `;

    document.querySelector(".ingredient-container").appendChild(newIngredient);
}

function addStep() {
    var newStep = document.createElement("div");
    newStep.className = "lepes-div";
    newStep.innerHTML = `
        <input type="text" class="lepes lepes-x" name="lepes[]" required>
        <button type="button" class="remove-btn" onclick="removeElement(this)">x</button>
    `;

    document.querySelector(".step-container").appendChild(newStep);
}

function removeElement(element) {
    var parentElement = element.parentNode;
    parentElement.parentNode.removeChild(parentElement);
}
