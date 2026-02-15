<?php
session_start();
include "db.php";

$month = date('m');
$year = date('Y');

$result = $conn->query("SELECT date, time FROM bookings ORDER BY date ASC, time ASC");


$calendar = [];
while($row = $result->fetch_assoc()){
    $day = date('d', strtotime($row['date']));
    if(!isset($calendar[$day])) $calendar[$day] = [];
    $calendar[$day][] = $row['time'];
}

echo json_encode($calendar);
