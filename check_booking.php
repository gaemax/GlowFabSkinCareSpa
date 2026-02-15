<?php
session_start();
include "db.php";

if(!isset($_SESSION['client'])){
    http_response_code(403);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$service = $data['service'];
$date = $data['date'];
$time = $data['time'];
$user_email = $_SESSION['client']['email'];

$response = ['available'=>false];

// Check if booked
$stmt = $conn->prepare("SELECT id FROM bookings WHERE date=? AND time=? AND service=?");
$stmt->bind_param("sss",$date,$time,$service);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows == 0){
    // Insert booking
    $insert = $conn->prepare("INSERT INTO bookings (user_email, service, date, time, status) VALUES (?, ?, ?, ?, 'Pending')");
    $insert->bind_param("ssss",$user_email,$service,$date,$time);
    $insert->execute();
    $response['available'] = true;
}

$stmt->close();
echo json_encode($response);
