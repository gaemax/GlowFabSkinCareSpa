<?php
session_start();
include "db.php"; // make sure db.php connects to gfspa_db

$msg = "";

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if($password !== $confirm_password){
        $msg = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $msg = "Email is already registered!";
        } else {
            // Hash password and insert new client
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO clients (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashed_password);

            if($insert->execute()){
                $msg = "Registration successful! You can now log in.";
            } else {
                $msg = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial; background: #f4f6fb; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,.1); max-width: 400px; margin: auto; }
        form input { width: 100%; padding: 10px; margin: 5px 0; border-radius: 8px; border: 1px solid #ccc; }
        form button { padding: 12px 20px; border: none; border-radius: 10px; background: #ff4da6; color: white; cursor: pointer; }
        form button:hover { background: #e60073; }
        .message { padding: 10px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Register</h2>

    <!-- Message -->
    <?php if($msg != ""): ?>
        <div class="message"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button name="register">Register</button>
    </form>
</div>

</body>
</html>
