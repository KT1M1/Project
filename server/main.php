<?php

require_once(__DIR__ . "/db.php");

function get_populars() {
    global $db;

    $stmt = $db->prepare(
        'SELECT COUNT(heart.user_id) as likes, food.* 
        FROM food 
        LEFT JOIN heart ON heart.food_id = food.id 
        GROUP BY heart.food_id 
        ORDER BY likes DESC
        LIMIT 3;'
    );

    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    return $result;
}
?>