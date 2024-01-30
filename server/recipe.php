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
        $stmt->bindParam(':time_min', $time_min, PDO::PARAM_INT);
        $stmt->bindParam(':upload_date', $upload_date, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_allergen($allergen_id, $food_name){
    global $db;

    try {
        $sql = "INSERT INTO `contains_allergen`(`allergen_id`, `food_id`) 
        SELECT :allergen_id, id
        FROM food
        WHERE name = :food_name";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':allergen_id', $allergen_id, PDO::PARAM_INT);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_category($category_id, $food_name){
    global $db;

    try {
        $sql = "INSERT INTO `contains_category`(`category_id`, `food_id`) 
        SELECT :category_id, id
        FROM food
        WHERE name = :food_name";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_contains_ingredient($ingredient_name, $unit_id, $quantity, $food_name){
    global $db;

    try {
        $sql = "INSERT INTO `contains_ingredient`(`ingredient_id`, `unit_id`, `quantity`, `food_id`)
        SELECT ingredient.id, :unit_id, :quantity, food.id
        FROM ingredient, food
        WHERE ingredient.name = :ingredient_name AND food.name = :food_name";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ingredient_name', $ingredient_name, PDO::PARAM_STR);
        $stmt->bindParam(':unit_id', $unit_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function insert_step($description, $food_name){
    global $db;

    try {
        $sql = "INSERT INTO `step`(`description`, `food_id`) 
        SELECT :description, id
        FROM food
        WHERE name = :food_name";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':food_name', $food_name, PDO::PARAM_STR);

        $stmt->execute();

    } catch (PDOException $e) {
        return "Sikertelen " . $e->getMessage();
    }
}

function upload_recipe($food_name, $img_url, $description, $category_ids, $portion, $time_min, $allergen_ids, $ingredient_names, $quantities, $unit_ids, $steps, $upload_date, $user_id) {
    foreach ($ingredient_names as $name) {
        insert_ingredient($name);
    }

    insert_food($portion, $food_name, $description, $img_url, $time_min, $upload_date, $user_id);

    foreach ($allergen_ids as $id) {
        insert_contains_allergen($id, $food_name);
    }

    foreach ($category_ids as $id) {
        insert_contains_category($id, $food_name);
    }

    for ($i = 0; $i < count($ingredient_names); $i++) {
        insert_contains_ingredient($ingredient_names[$i], $unit_ids[$i], $quantities[$i], $food_name);
    }

    foreach ($steps as $step) {
        insert_step($step, $food_name);
    }
   
}

const MAX_FILE_SIZE_MB = 1;
function image_uploader($name, $tmp_name, $size) {
    $targetDir = "uploads/imgs/";
    $uploadedFileName = basename($name);
    $targetFile = $targetDir . $uploadedFileName;
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Generate a new filename if the file already exists
    $counter = 1;
    while (file_exists($targetFile)) {
        $newFileName = pathinfo($uploadedFileName, PATHINFO_FILENAME) . "_" . $counter . "." . $imageFileType;
        $targetFile = $targetDir . $newFileName;
        $counter++;
    }

    // Check file size
    if ($size > MAX_FILE_SIZE_MB * 1024 * 1024) {
        //echo "Error: File size is too large (limit is 5MB).";
        $uploadOk = false;
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png"];
    if (!in_array($imageFileType, $allowedFormats)) {
        //echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = false;
    }

    // Move the uploaded file to the specified directory
    if ($uploadOk) {
        if (move_uploaded_file($tmp_name, $targetFile)) {
            return basename($targetFile);
        } else {
            //echo "Error uploading file.";
        }
    }
}

?>