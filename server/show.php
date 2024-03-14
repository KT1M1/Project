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

function get_user_data($id) {
    global $db;
    
    $stmt = $db->prepare(
        'SELECT user.user_name, user.registration_date, user.id
        FROM food
        LEFT JOIN user ON food.user_id = user.id
        WHERE food.id = :id'
    );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function get_likes($id) {
    global $db;
    
    $stmt = $db->prepare(
        'SELECT COUNT(user_id) AS like_count
        FROM heart 
        WHERE food_id = :id'
    );
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['like_count'];
}

function is_liked( $food_id, $user_id ) {
    global $db;

    $sql = "SELECT * FROM heart WHERE food_id = :food_id AND user_id = :user_id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result != NULL;
}

function set_like( $food_id, $user_id ) {
    global $db;

    $sql = "INSERT INTO heart (food_id, user_id) VALUES (:food_id, :user_id)";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();
}

function remove_like( $food_id, $user_id ) {
    global $db;

    $sql = "DELETE FROM heart WHERE food_id = :food_id AND user_id = :user_id;";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();
}