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