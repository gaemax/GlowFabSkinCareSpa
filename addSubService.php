<?php
    require "db.php";

    $name = trim($_POST["name"]);
    $parentService = trim($_POST["parentService"]);
    $desc = trim($_POST["desc"]);
    $price = trim($_POST["price"]);

    $query = "
        SELECT service_id
        FROM services
        WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "s",
        $parentService
    );
    $stmt->execute();
    $serviceId = $stmt->get_result();

    $query = "
        SELECT subservice_id
        FROM subservices
        WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "s",
        $name
    );
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $query = "
            UPDATE subservices 
            SET name = ?, service_id = ?, description = ?, price = ?
            WHERE name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sisis",
            $name,
            $serviceId,
            $desc,
            $price,
            $name
        );
        $stmt->execute();
    } else {
        $query = "INSERT INTO subservices 
        (name, service_id, description, price)
        VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sisi",
            $name,
            $serviceId,
            $desc,
            $price
        );
        $stmt->execute();
    }


    

    header("Location: admin.php?page=servicemanager");
    exit();

?>