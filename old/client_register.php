<?php
include "db.php";

if(isset($_SESSION['client'])){
    header("Location: booking.php");
    exit;
}

if(isset($_POST['email']) && isset($_POST['password'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($check->num_rows > 0){
        $error = "Email already registered!";
    } else {
        $conn->query("INSERT INTO users (name,email,phone,password) VALUES ('$name','$email','$phone','$password')");
        $_SESSION['client'] = [
            'name' => $name,
            'email' => $email
        ];
        header("Location: booking.php");
        exit;
    }
}
?>
