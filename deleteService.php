<?php
    require "db.php";

    $id = $_GET["id"];

    $query = "DELETE FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "i", $id
    );
    $stmt->execute();

    header("Location: admin.php?page=servicemanager");
    exit();

?>