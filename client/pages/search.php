<?php
    require_once("./server/recipe.php");

        $main_cats = get_main_categories();
        $sub_cats = get_sub_categories();
        $other_cats = get_other_categories();
        $other_cat_types = get_other_category_types();

        $cat_hierarchy = format_main_sub_cat_hierarchy($main_cats, $sub_cats);

        $allergens = get_allergens();
?>

<link rel="stylesheet" href="/client/assets/css/search.css" />

<div>
    <button class="filter-button">
        <img class="filter-img" src="/client/assets/img/filter.png" alt="filter">
    </button>
</div>

<div class="container">
    <div class="filter-container">
        <!--Close the filter window-->
        <button class="close-filter">X</button>

        <div class="sort-div">
            <p>Rendezés</p>
            <select>
                <option value="like">Legkedveltebb</option>
                <option value="new">Legújabb</option>
            </select>
        </div>

        <div>
            <div class="selectContainer">
                <div id="main-category"></div>
                <div id="sub-category"></div>
            </div>

            <?php
                foreach ($other_cat_types as $type) {
                    echo '
                    <select name="category[]">
                        <option selected="true" disabled="disabled">' . $type["name"] . '</option>';

                    foreach ($other_cats as $cat) {
                        if($cat["category_type_id"] == $type["id"]) {
                            echo '<option value="' . $cat['id'] . '">' . $cat['name'] . '</option>';
                        }
                    }
                    echo '</select>';
                }
            ?>
        </div>
        <div>
            <div>
                <h3>Allergént tartalmazhat:</h3>
                <div class="allergen-div">
                    <?php
                            foreach($allergens as $allergen) {
                                echo '
                                <div class="cboxtags">
                                    <input type="checkbox" id="allergen_' . $allergen["id"] . '" name="allergen[]" value="' . $allergen["id"] . '"  checked>
                                    <label for="allergen_' . $allergen["id"] . '" class="allergen-lbl">' . ucfirst($allergen["name"]) . '</label>
                                </div>
                                ';
                            }
                        ?>
                </div>
            </div>
        </div>

        <div class="search-btn-div">
            <button id="search-button">Search</button>
        </div>
    </div>

    <div id="selected-filters">
        <h3>Selected Filters:</h3>
        <ul id="filter-list"></ul>
    </div>


    <!--First Row-->
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card-div">
                <div class="card-top">
                    <img class="card-pic" src="/client/assets/img/bologna.jpg" alt="">
                </div>
                <div class="card-bottom">
                    <div class="card-text">
                        <p>Bolognai Spagetti</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card-div">
                <div class="card-top">
                    <img class="card-pic" src="/client/assets/img/bologna.jpg" alt="">
                </div>
                <div class="card-bottom">
                    <div class="card-text">
                        <p>Bolognai Spagetti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Second Row-->
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card-div">
                <div class="card-top">
                    <img class="card-pic" src="/client/assets/img/bologna.jpg" alt="">
                </div>
                <div class="card-bottom">
                    <div class="card-text">
                        <p>Bolognai Spagetti</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card-div">
                <div class="card-top">
                    <img class="card-pic" src="/client/assets/img/bologna.jpg" alt="">
                </div>
                <div class="card-bottom">
                    <div class="card-text">
                        <p>Bolognai Spagetti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    categories = <?php echo json_encode($cat_hierarchy); ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const filterButton = document.querySelector('.filter-button');
        const filterContainer = document.querySelector('.filter-container');
        const closeButton = document.querySelector('.close-filter');

        filterButton.addEventListener('click', function () {
            filterContainer.classList.toggle('is-visible');
        });

        closeButton.addEventListener('click', function () {
            filterContainer.classList.remove('is-visible');
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        const searchButton = document.getElementById('search-button');

        if (searchButton) {
            searchButton.addEventListener('click', function () {
                const filterList = document.getElementById('filter-list');
                filterList.innerHTML = '';

                // Handle category filters
                document.querySelectorAll('select[name="category[]"]').forEach(select => {
                    const selectedText = select.options[select.selectedIndex].text;
                    const selectedValue = select.value;
                    console.log(`Selected Category: ${selectedText}, Value: ${selectedValue}`);

                    if (!select.options[select.selectedIndex].disabled) {
                        const label = document.createElement('label');
                        label.className = 'filter-checkbox';

                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.checked = true;
                        checkbox.setAttribute('data-value', selectedValue);
                        checkbox.onchange = function () {
                            if (!this.checked) {
                                this.parentNode.parentNode.removeChild(this.parentNode);
                            }
                            //Continue here
                        };

                        label.appendChild(checkbox);
                        const textNode = document.createTextNode(` ${selectedText} \u2715 `);
                        label.appendChild(textNode);

                        filterList.appendChild(label);
                    }
                });

                // Handle allergen filters
                document.querySelectorAll('input[name="allergen[]"]:checked').forEach(checkbox => {
                    const allergenText = checkbox.nextElementSibling.textContent;
                    const allergenValue = checkbox.value;
                    console.log(`Selected Allergen: ${allergenText}, Value: ${allergenValue}`);

                    const label = document.createElement('label');
                    label.className = 'filter-checkbox';

                    const newCheckbox = document.createElement('input');
                    newCheckbox.type = 'checkbox';
                    newCheckbox.checked = true;
                    newCheckbox.setAttribute('data-value', allergenValue);
                    newCheckbox.onchange = function () {
                        if (!this.checked) {
                            this.parentNode.parentNode.removeChild(this.parentNode);
                        }
                        // filter removal 
                    };

                    label.appendChild(newCheckbox);
                    const textNode = document.createTextNode(` ${allergenText} \u2715 `);
                    label.appendChild(textNode);

                    filterList.appendChild(label);
                });
            });
        }
    });





</script>

<script src="/client/assets/js/display_category.js"></script>