<?php
    require "db.php";

    $name = trim($_POST["name"]);
    $desc = trim($_POST["desc"]);

    $query = "
    SELECT service_id
    FROM services
    WHERE name = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "s",
        $name
    );
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $query = "
        UPDATE services 
        SET name = ?, description = ?
        WHERE name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sss",
            $name,
            $desc,
            $name
        );
        $stmt->execute();
    } else {
        $query = "INSERT INTO services 
        (name, description)
        VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ss",
            $name,
            $desc
        );
        $stmt->execute();
    }


    

    header("Location: admin.php?page=servicemanager");
    exit();

?>