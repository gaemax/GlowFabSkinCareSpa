<?php
    require "db.php";
    session_start();

    if(!isset($_SESSION["loggedin"])){
        header("Location: login.php");
        exit;
    }

    if (isset($_GET['booking_id'])) {
        $bookingId = $_GET['booking_id'];
        $bookingId = (int)$bookingId;
    } else {
        die('Booking ID not specified.');
    }

    $status = 4;
    $query = "
        UPDATE bookings
        SET 
            status_id = ?
        WHERE booking_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ii",
        $status,
        $bookingId     
    );
    $stmt->execute();

    header("Location: mybookings.php");
    exit;

?>