<?php

require_once(__DIR__ . "/db.php");

function get_units() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM unit ORDER BY id;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_allergens() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM allergen;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_categories() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM category;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_main_categories() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM category WHERE category_type_id = 1;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_sub_categories() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM category WHERE category_type_id = 2;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_other_categories() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM category WHERE category_type_id not in (1, 2) ORDER BY category_type_id;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_other_category_types() {
    global $db;

    $stmt = $db->prepare('SELECT * FROM category_type WHERE id not in (1, 2) ORDER BY id;');
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function format_main_sub_cat_hierarchy($main_cats, $sub_cats) {
    $cat_array = [];

    foreach($main_cats as $mcat) {
        $sub_cats_array = [];

        foreach($sub_cats as $scat) {
            if($scat['parent_id'] == $mcat['id']) {
                array_push($sub_cats_array, (object)[
                    'id' => $scat['id'],
                    'name' => $scat['name'],
                ] );
            }
        }

        array_push($cat_array, (object)[
            'id' => $mcat['id'],
            'name' => $mcat['name'],
            'subcategories' => $sub_cats_array,
        ]);
    }

    return $cat_array;
}
/*
//Recept feltöltése

function insert_ingredient($name){
    global $db;

    try {
        $sql="INSERT INTO `ingredient`(`name`) VALUES (:name)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_food($portion, $name, $description, $img_url, $time_min, $upload_date, $user_id){
    global $db;

    try {
        $sql="INSERT INTO `food`(`portion`,`name`, `description`, `img_url`, `time_min`, `upload_date`, `user_id`) 
        VALUES (:portion, :name, :description, :img_url, :time_min, :upload_date, :user_id)";
        
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':portion', $portion, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':img_url', $img_url, PDO::PARAM_STR);
        $stmt->bindParam(':time_min', $time_min, PDO::PARAM_STR);
        $stmt->bindParam(':upload_date', $upload_date, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_allergen($allergen_id, $food_name){
    global $db;

    try {
        $sql="INSERT INTO `contains_allergen`(`allergen_id`, `food_id`) 
        VALUES (
            :allergen_id, 
            'SELECT id
            FROM food
            WHERE name = :food_name'
        )";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':allergen_id', $allergen_id, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_category($category_id, $food_name){
    global $db;

    try {
        $sql="INSERT INTO `contains_category`(`category_id`, `food_id`) 
        VALUES (
            :category_id, 
            'SELECT id
            FROM food
            WHERE name = :food_name'
        )";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_ingredient($ingredient_id, $unit_id, $quantity, $food_name){
    global $db;

    try {
        $sql="INSERT INTO `contains_ingredient`(`ingredient_id`, `unit_id`, `quantity`, `food_id`) 
        VALUES (
            :ingredient_id, 
            :unit_id,
            :quantity,
            'SELECT id
            FROM food
            WHERE name = :food_name'
        )";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ingredient_id', $ingredient_id, PDO::PARAM_STR);
        $stmt->bindParam(':unit_id', $unit_id, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_step($description, $food_name){
    global $db;

    try {
        $sql="INSERT INTO `step`(`description`, `food_id`) 
        VALUES (
            :description,
            'SELECT id
            FROM food
            WHERE name = :food_name'
        )";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function upload($ingredient_name, $portion, $food_name, $description, $img_url, $time_min, $upload_date, $user_id, $allergen_ids, $category_ids, $ingredient_ids, $unit_ids, $quantities, $description) {
    insert_ingredient($ingredient_name);
    insert_food($portion, $food_name, $description, $img_url, $time_min, $upload_date, $user_id);
    foreach ($allergen_ids as $id) {
        insert_contains_allergen($id, $food_name);
    }
    foreach ($category_ids as $id) {
        insert_contains_category($id, $food_name);
    }
    for ($i = 0; $i < count($ingredient_ids); $i++) {
        insert_contains_ingredient($ingredient_ids[$i], $unit_id, $quantity, $food_name);
    }

    ($ingredient_id, $unit_id, $quantity, $food_name)
   
}
*/

?>