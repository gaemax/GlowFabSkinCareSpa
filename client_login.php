<?php
include "db.php";

if(isset($_SESSION['client'])){
    header("Location: booking.php");
    exit;
}

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$password'");

    if($result && $result->num_rows > 0){
        $user = $result->fetch_assoc();
        $_SESSION['client'] = [
            'name' => $user['name'],
            'email' => $user['email']
        ];
        header("Location: booking.php");
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>
