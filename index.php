<?php
    session_start();
    if(isset($_SESSION["loggedin"])) {
        header("location: login");
    }
?>

<html>
    <head>
        <title>Glow Fab</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
    </head>
    <body>
        
    <header>
        <div class="navigatorBar" width="">
            <h1>Glow Fab</h1>
            <ul>
                <li>Home</li>
                <li>About</li>
                <li>Services</li>
                <li>Staff</li>
                <li>Reviews</li>
                <li>Contact Us</li>
            </ul>
        </div>
    </header>
    </body>
</html>