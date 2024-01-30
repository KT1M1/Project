<?php
// search.php
header('Content-Type: application/json');
require_once(__DIR__ . "/db.php");

if(isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $filter = $keyword . "%";
    
    $sql = "SELECT * FROM ingredient WHERE name LIKE :filter";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);

    $stmt->execute();

    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    
    echo json_encode($result);
}
?>
