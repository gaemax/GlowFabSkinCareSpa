<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid access.");
}

if (!isset($_POST['subservice_id']) || !is_numeric($_POST['subservice_id'])) {
    die("Invalid request.");
}

$id = intval($_POST['subservice_id']);

$stmt = $conn->prepare("UPDATE subservices SET status='inactive' WHERE subservice_id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: services.php?deleted=1");
    exit;
} else {
    echo "Database error.";
}
?>