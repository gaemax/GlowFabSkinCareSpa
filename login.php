<?php
session_start();

/* =========================
   REDIRECT IF ALREADY LOGGED IN
========================= */
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: index.php");
    exit;
}

/* =========================
   LOGIN PROCESS
========================= */
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // sample static login (replace with database later)
    $valid_user = "admin";
    $valid_pass = "1234";

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if($username === $valid_user && $password === $valid_pass){

        session_regenerate_id(true);

        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;

        header("Location: index.php");
        exit;

    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Glow Fab</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
</head>
<body>

<header>
    <div class="navigatorBar">
        <h1>Glow Fab</h1>
        <ul>
            <li onclick="window.location.href='index.php'">Home</li>
        </ul>
    </div>
</header>

<section style="
    min-height:80vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background-color: var(--light-pink-color);
">

<form method="POST" style="
    background:white;
    padding:3rem;
    border-radius:1rem;
    width:350px;
    text-align:center;
">

    <h2 style="margin-bottom:1rem;">Login</h2>

    <?php if($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username" required
    style="width:100%; padding:10px; margin:10px 0;">

    <input type="password" name="password" placeholder="Password" required
    style="width:100%; padding:10px; margin:10px 0;">

    <button class="primaryButton" style="width:100%; margin-top:10px;">
        Login
    </button>

</form>

</section>

</body>
</html>
