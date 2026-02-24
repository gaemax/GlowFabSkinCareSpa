<?php
    require "db.php";

    $bookingId = (int)$_POST["booking_id"];
    $statusId = (int)$_POST["status_id"];

    //die($bookingId . ' ' . $statusId);

    $query = "
        UPDATE bookings 
        SET status_id = ?
        WHERE booking_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ii",
        $statusId,
        $bookingId
    );
    $stmt->execute();

    header("Location: admin.php?page=appointments");
    exit();
?>