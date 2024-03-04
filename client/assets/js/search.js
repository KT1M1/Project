document.addEventListener('DOMContentLoaded', function () {
    initialize_filter_menu();
    initialize_search_action();
});

function initialize_filter_menu() {
    const filterButton = document.querySelector('.filter-button');
    const filterContainer = document.querySelector('.filter-container');
    const closeButton = document.querySelector('.close-filter');

    filterButton.addEventListener('click', function () {
        filterContainer.classList.toggle('is-visible');
    });

    closeButton.addEventListener('click', function () {
        filterContainer.classList.remove('is-visible');
    });
}

function initialize_search_action() {
    const searchButton = document.getElementById('search-button');
    const searchTextButton = document.getElementById('search-text-button');

    searchButton.addEventListener('click', function () {
        generate_filter_array();
    });

    searchTextButton.addEventListener('click', function () {
        generate_filter_array();
    });
}

function generate_filter_array() {
    const filterList = document.getElementById('filter-list');
    filterList.innerHTML = '';
    const selectedFilters = [];

    // Handle category filters
    document.querySelectorAll('select[name="category[]"]').forEach(select => {
        const selectedText = select.options[select.selectedIndex].text;
        const selectedValue = select.value;

        // Check if the selectedValue is numeric
        if (!isNaN(+selectedValue)) {
            const label = document.createElement('label');
            label.className = 'filter-checkbox';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = true;
            checkbox.setAttribute('data-value', selectedValue);

            label.appendChild(checkbox);
            const textNode = document.createTextNode(` ${selectedText} `);
            label.appendChild(textNode);

            filterList.appendChild(label);

            selectedFilters.push({ type: 'Category', text: selectedText, value: selectedValue });
        }
    });

    // Handle allergen filters
    document.querySelectorAll('input[name="allergen[]"]:checked').forEach(checkbox => {
        const allergenText = checkbox.nextElementSibling.textContent;
        const allergenValue = checkbox.value;


        const label = document.createElement('label');
        label.className = 'filter-checkbox';

        const newCheckbox = document.createElement('input');
        newCheckbox.type = 'checkbox';
        newCheckbox.checked = true;
        newCheckbox.setAttribute('data-value', allergenValue);

        label.appendChild(newCheckbox);
        const textNode = document.createTextNode(` ${allergenText} `);
        label.appendChild(textNode);

        filterList.appendChild(label);

        selectedFilters.push({ type: 'Allergen', text: allergenText, value: allergenValue });
    });


    selectedFilters.push({
        type: 'Text',
        text: search_bar_input.value,
        value: search_bar_input.value
    });

    console.log(selectedFilters);
    get_filtered_recipes(selectedFilters);
}

function displayRecipes(data) {
    const resultsRow = document.getElementById('results-row');
    resultsRow.innerHTML = '';
    counter = 0;
    data.forEach((recipe, index) => {
        const colDiv = document.createElement('div');
        colDiv.className = 'col-md-4 col-sm-6 mb-4';
        counter++;
        colDiv.innerHTML = `
            <a href="/page/show_recipe/${recipe.id}">
                <div class="card-div">
                    <div class="card-top">
                        <img class="card-pic" src="/uploads/imgs/${recipe.img_url}" alt="${recipe.name}">
                    </div>
                    <div class="card-bottom">
                        <div class="card-text">
                            <p>
                                ${recipe.name}
                            </p>
                            <p class="card-desc">
                                ${recipe.description.substring(0,50)}...
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        `;
        resultsRow.appendChild(colDiv);
    });
    document.getElementById('recipe-count').textContent = `Találat: ${counter} db`;
}

function get_filtered_recipes(filter_array) {
    generate_presets(filter_array);

    fetch('http://localhost/server/search.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(filter_array)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        displayRecipes(data);
    })
    .catch(error => console.error('Error:', error));
}
//Not implemented yet
function generate_presets(filter_array) {
    let filterList = document.getElementById("filter-list");
    filterList.innerHTML = "";

    for(let i = 0; i < filter_array.length; i++) {
        const label = document.createElement('label');
        label.className = 'filter-checkbox';

        const newCheckbox = document.createElement('input');
        newCheckbox.type = 'checkbox';
        newCheckbox.checked = true;
        newCheckbox.setAttribute('data-value', filter_array[i].text);

        label.appendChild(newCheckbox);
        const textNode = document.createTextNode(` ${filter_array[i].text} `);
        label.appendChild(textNode);

        filterList.appendChild(label);
    }
}