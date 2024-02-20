<?php
header('Content-Type: application/json');
require_once(__DIR__ . "/db.php");

// Get the raw POST data from the request
$json = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($json, true);



function get_all_filter( $type, $data_array ) {
    $tmp_array = [];

    foreach( $data_array as $item ) {
        if( $item['type'] == $type ) {
            array_push( $tmp_array, $item['value'] );
        }
    }

    return $tmp_array;
}


$filter_array = [];
$filter_string_array = [];

$text_filters = get_all_filter( "Text", $data );
$category_filters = get_all_filter( "Category", $data );
$allergen_filters = get_all_filter( "Allergen", $data );


if( count( $text_filters ) == 1 ) {
    array_push( $filter_string_array, "name LIKE ?" );
    array_push( $filter_array, "%" . $text_filters[0] . "%" );
}

if( count( $category_filters ) > 0 ) {
    $cat_count = count($category_filters);
    $placeholders = implode(',', array_fill(0, $cat_count, '?'));
    array_push( $filter_string_array, 
        "food.id IN (
            SELECT contains_category.food_id
            FROM contains_category
            WHERE contains_category.category_id IN ($placeholders)
            GROUP BY contains_category.food_id
            HAVING COUNT(contains_category.category_id) = ?
        )" 
    );

    $filter_array = array_merge( $filter_array, $category_filters );
    array_push( $filter_array, $cat_count );
}

if( count( $allergen_filters ) > 0 ) {
    $placeholders = implode(',', array_fill(0, count($allergen_filters), '?'));
    array_push( $filter_string_array, 
        "food.id NOT IN (
            SELECT contains_allergen.food_id
            FROM contains_allergen
            WHERE contains_allergen.allergen_id IN ($placeholders)
            GROUP BY contains_allergen.food_id
        )" 
    );
    $filter_array = array_merge($filter_array, $allergen_filters);
}

$filter_string = "";
if( count($filter_array) > 0 ) {
    $filter_string = "WHERE " . implode(' AND ', $filter_string_array);
}


$name_filter = "%%";

if(isset($_GET["name"])) {
    $name_filter = "%" . $_GET["name"] . "%";
}


$sql = 
    "SELECT food.*
    FROM food
    $filter_string 
    LIMIT 10;";

$stmt = $db->prepare($sql);

$stmt->execute(array_values($filter_array));

$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo json_encode($result);
?>
