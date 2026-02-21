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
                <h1>Register an Account</h1>
                <form action="">
                    <div class ="nameContainer">
                        <input type="text" placeholder="Last Name" required>
                        <input type="text" placeholder="First name" required>
                        <input type="text" placeholder="Middle Name" required>
                    </div>
                    <input type="text" placeholder="Email" required>
                    <input type="password" placeholder="Password" required>
                    <input type="password" placeholder="Confirm Password" required>
                    <input type="submit">
                </form>
                <a href="login.php" class="loginLink">Back to Login</a>
            </div>
        </section>
    </body>
</html>
