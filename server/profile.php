<?php

require_once(__DIR__ . "/db.php");

function get_uploads($user_id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT `food`.`name`, `food`.`id`, food.img_url
        FROM `user`
            LEFT JOIN `food` ON `food`.`user_id` = `user`.`id`
        WHERE `user`.`id` = :user_id AND `food`.`id` IS NOT NULL'
    );

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}

function get_liked($user_id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT COUNT(DISTINCT food_id) AS liked_recipes_count
        FROM heart
        WHERE user_id = :user_id'
    );

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['liked_recipes_count'] : 0;
}

function get_liked_recipes($user_id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT food.id, food.name, food.img_url
        FROM heart
        JOIN food ON heart.food_id = food.id
        WHERE heart.user_id = :user_id'
    );

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function delete_recipe($food_id, $user_id){
    global $db;

    try {
        $sql="DELETE FROM food WHERE food.id = :food_id AND food.user_id = :user_id;";
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':food_id', $food_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function get_user_data($user_id) {
    global $db;

    $stmt = $db->prepare(
        'SELECT id, full_name, user_name, password, email, profile_pic, DATE(registration_date) as registration_date FROM user WHERE id = :user_id;'
    );

    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there is at least one result. If so, return the first row (user data).
    // Otherwise, return NULL indicating no user was found with the provided ID.
    return count($result) >= 1 ? $result[0] : NULL;
}

?>