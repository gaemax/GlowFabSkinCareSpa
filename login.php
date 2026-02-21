<?php
session_start();
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
