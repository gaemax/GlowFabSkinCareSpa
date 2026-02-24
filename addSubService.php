<?php
require "db.php";

$name = trim($_POST["name"]);
$parentService = trim($_POST["parentService"]);
$desc = trim($_POST["desc"]);
$price = floatval($_POST["price"]);


$query = "SELECT service_id FROM services WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $parentService);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Parent service not found.");
}

$row = $result->fetch_assoc();
$serviceId = (int)$row["service_id"];

/* checks id service exits */
$query = "SELECT subservice_id FROM subservices WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

/*Update or insert */
if ($result->num_rows > 0) {

    $query = "UPDATE subservices 
              SET name = ?, service_id = ?, description = ?, price = ?
              WHERE name = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sids", $name, $serviceId, $desc, $price, $name);

} else {

    $query = "INSERT INTO subservices
              (name, service_id, description, price)
              VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sids", $name, $serviceId, $desc, $price);
}

$stmt->execute();

header("Location: admin.php?page=servicemanager");
exit();
?>