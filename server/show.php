<?php

require_once(__DIR__ . "/db.php");

function get_recipe_by_id($id) {
    global $db;

    $stmt = $db->prepare('SELECT * FROM food WHERE id = :id;');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_categories_for_recipe($id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT name
        FROM contains_category 
        INNER JOIN category ON category_id = category.id
        WHERE food_id = :id;'
    );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_allergens_for_recipe($id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT icon
        FROM contains_allergen
        INNER JOIN allergen ON allergen_id = allergen.id
        WHERE food_id = :id;'
    );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_ingredients_for_recipe($id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT ingredient.name AS ingredient, contains_ingredient.quantity AS quantity, unit.name AS unit
        FROM contains_ingredient
        JOIN food ON contains_ingredient.food_id = food.id
        JOIN ingredient ON contains_ingredient.ingredient_id = ingredient.id
        JOIN unit ON contains_ingredient.unit_id = unit.id
        WHERE food.id = :id;'
        );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_steps_for_recipe($id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT step.description
        FROM step 
        INNER JOIN food ON food.id = food_id
        WHERE food_id = :id;'
    );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

?>