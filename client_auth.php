<?php
session_start();
include "db.php"; // Make sure this connects to gfspa_db

$msg = "";

// ==========================
// Registration
// ==========================
if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password !== $confirm_password){
        $msg = "Passwords do not match!";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $msg = "Email is already registered!";
        } else {
            // Insert new client
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO clients (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $hashed_password);

            if($insert->execute()){
                // Auto-login after registration
                $_SESSION['client'] = [
                    'id' => $insert->insert_id,
                    'name' => $name,
                    'email' => $email
                ];
                header("Location: booking.php"); // Redirect to booking page
                exit;
            } else {
                $msg = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}

// ==========================
// Login
// ==========================
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_password);

    if($stmt->num_rows == 1){
        $stmt->fetch();
        if(password_verify($password, $hashed_password)){
            // Set session
            $_SESSION['client'] = [
                'id' => $id,
                'name' => $name,
                'email' => $email
            ];
            header("Location: booking.php"); // Redirect to booking page
            exit;
        } else {
            $msg = "Incorrect password!";
        }
    } else {
        $msg = "Email not found!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Login / Register</title>
    <style>
        body { font-family: Arial; background: #f4f6fb; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,.1); max-width: 400px; margin: auto; }
        form input { width: 100%; padding: 10px; margin: 5px 0; border-radius: 8px; border: 1px solid #ccc; }
        form button { padding: 12px 20px; border: none; border-radius: 10px; background: #ff4da6; color: white; cursor: pointer; }
        form button:hover { background: #e60073; }
        .message { padding: 10px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 15px; }
        .tab { display: flex; justify-content: space-around; margin-bottom: 20px; cursor: pointer; }
        .tab div { padding: 10px; font-weight: bold; }
        .active-tab { border-bottom: 2px solid #ff4da6; }
    </style>
    <script>
        function showForm(form) {
            document.getElementById('registerForm').style.display = (form=='register') ? 'block' : 'none';
            document.getElementById('loginForm').style.display = (form=='login') ? 'block' : 'none';
            document.getElementById('tabRegister').classList.toggle('active-tab', form=='register');
            document.getElementById('tabLogin').classList.toggle('active-tab', form=='login');
        }
    </script>
</head>
<body>

<div class="card">
    <div class="tab">
        <div id="tabRegister" class="active-tab" onclick="showForm('register')">Register</div>
        <div id="tabLogin" onclick="showForm('login')">Login</div>
    </div>

    <!-- Message -->
    <?php if($msg != ""): ?>
        <div class="message"><?= $msg ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="POST" id="registerForm">
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

    <!-- Login Form -->
    <form method="POST" id="loginForm" style="display:none;">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button name="login">Login</button>
    </form>
</div>

</body>
</html>
