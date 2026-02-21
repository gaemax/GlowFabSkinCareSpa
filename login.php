<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login - Glow Fab</title>
        <link rel="stylesheet" href="styles/global.css">
        <link rel="stylesheet" href="styles/login.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    </head>
    <body>

        <header>
            <div class="navigatorBar">
                <h1>Glow Fab</h1>
            </div>
        </header>

        <section class="loginSection">
            <div class="loginCard">
                <h1>Login</h1>
                <form action="">
                    <input type="text" placeholder="Your Email" required>
                    <input type="password" placeholder="Your Password" required>
                    <input type="submit">
                </form>
                <a href="register.php" class="loginLink">Don't have an account? Make one now!</a>
        </div>
        </section>
    </body>
</html>
