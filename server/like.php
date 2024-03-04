<?php
// search.php
header('Content-Type: application/json');
require_once(__DIR__ . "/show.php");

if(isset($_GET['food_id']) && isset($_GET['user_id'])) {

    set_like( $_GET['food_id'], $_GET['user_id'] );
    
    echo json_encode((object)[
        "result" => "success"
    ]);
}
?>
