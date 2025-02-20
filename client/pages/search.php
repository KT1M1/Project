<?php
    require_once("./server/recipe.php");

    $main_cats = get_main_categories();
    $sub_cats = get_sub_categories();
    $other_cats = get_other_categories();
    $other_cat_types = get_other_category_types();

    $cat_hierarchy = format_main_sub_cat_hierarchy($main_cats, $sub_cats);

    $allergens = get_allergens();

    
    $default_filter_array = [];

    // If the occasion is set in the URL add this into the filter array
    if(isset($_GET["occasion"])) {
        array_push($default_filter_array,
            (object) [
                "type" => "Category",
                "text" => isset($_GET["text"]) ? $_GET["text"] : "",
                "value" => $_GET["occasion"]
            ]
        );
    }

    // If the difficulty is set in the URL add this into the filter array
    if(isset($_GET["difficulty"])) {
        array_push($default_filter_array,
            (object) [
                "type" => "Category",
                "text" => isset($_GET["text"]) ? $_GET["text"] : "",
                "value" => $_GET["difficulty"]
            ]
        );
    }

    // If the category is set in the URL add this into the filter array
    if(isset($_GET["category"])) {
        array_push($default_filter_array,
            (object) [
                "type" => "Category",
                "text" => isset($_GET["text"]) ? $_GET["text"] : "",
                "value" => $_GET["category"]
            ]
        );
    }
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
        <div class="close-div">
            <h3>Részletes keresés</h3>
            <button class="btn close-filter">&#x2715</button>
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
                                <label for="allergen_' . $allergen["id"] . '" class="allergen-lbl">' . ucfirst($allergen["name"]) . "-mentes" . '</label>
                            </div>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="search-btn-div">
            <button id="search-button">Keresés</button>
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
        <div id="filter-list"></div>
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

<script>
    // After the page loaded display the recipes with the php generated default filter
    get_filtered_recipes(<?php echo json_encode($default_filter_array); ?>);
</script>