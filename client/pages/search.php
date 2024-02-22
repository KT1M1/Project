<?php
    require_once("./server/recipe.php");

    $main_cats = get_main_categories();
    $sub_cats = get_sub_categories();
    $other_cats = get_other_categories();
    $other_cat_types = get_other_category_types();

    $cat_hierarchy = format_main_sub_cat_hierarchy($main_cats, $sub_cats);

    $allergens = get_allergens();
?>

<link rel="stylesheet" href="/client/assets/css/search.css"/>

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
                        <option selected="true">' . $type["name"] . '</option>';

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
                <div class="allergen-div">
                    <?php
                        foreach($allergens as $allergen) {
                            echo '
                            <div class="cboxtags">
                                <input type="checkbox" id="allergen_' . $allergen["id"] . '" name="allergen[]" value="' . $allergen["id"] . '">
                                <label for="allergen_' . $allergen["id"] . '" class="allergen-lbl">' . ucfirst($allergen["name"]) . " mentes" . '</label>
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
</div>

<div class="container search-div">
    <div class="search-bar">
        <input type="text" id="search_bar_input" class="search-field" placeholder="Keresés..." />
        <button id="search-text-button" class="btn nav-btn search-icon" type="button">
            <img class="img-icon" src="/client/assets/img/search.png" alt="">
        </button>
    </div>
    <div>
        <p id="recipe-count"></p>
    </div>
</div>

<hr>

<div class="container filters">
    <div id="selected-filters">
        <ul id="filter-list"></ul>
    </div>
</div>

<div class="container results-container">
    <div class="row" id="results-row"></div>
</div>

<script>
    categories = <?php echo json_encode($cat_hierarchy); ?>;
</script>


<script src="/client/assets/js/display_category.js"></script>
<script src="/client/assets/js/search.js"></script>