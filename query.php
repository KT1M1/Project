<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "recipeshare";
        
        // Create a connection
        $conn = new mysqli($servername, $username, $password, $database);
        
        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



        // Perform a SELECT query
        $sql = "SELECT * FROM food";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Név: " . $row["name"] . "<br>";
                echo "Elkészítési idő: " . $row["time_min"] . "<br>";
                echo "Leírás: " . $row["description"] . "<br>";
                echo "Kép: <img src='" . $row["img_url"] . "' width='500'>";

                echo "<br><br>Tags: ";

                $tags = $conn->query("SELECT *
                FROM contains_tag INNER JOIN tag ON contains_tag.tag_id = tag.id
                WHERE contains_tag.food_id = " . $row["id"] . ";");

                if ($tags->num_rows > 0) {
                    while ($tag_row = $tags->fetch_assoc()) {
                        echo $tag_row["name"] . " ";
                    }
                }

                echo "<br><br>Hozzávalók:<br>";

                $ings = $conn->query("SELECT *
                FROM contains_ing INNER JOIN ingredient ON contains_ing.ing_id = ingredient.id
                WHERE contains_ing.food_id = " . $row["id"] . ";");

                if ($ings->num_rows > 0) {
                    while ($ing_row = $ings->fetch_assoc()) {
                        echo $ing_row["amount"] . " " . $ing_row["name"] . "<br>";
                    }
                }

            }
        } else {
            echo "No results found.";
        }

        // Close the connection
        $conn->close();
        
    ?>