<?php
header('Content-Type: application/json');
require_once(__DIR__ . "/db.php");


$name_filter = "%%";

if(isset($_GET["name"])) {
    $name_filter = "%" . $_GET["name"] . "%";
}


$sql = 
    "SELECT * 
    FROM food
    WHERE name LIKE :name
    LIMIT 10";

$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name_filter, PDO::PARAM_STR);

$stmt->execute();

$result = $stmt->fetchAll( PDO::FETCH_ASSOC );

echo json_encode($result);
?>
