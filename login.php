<?php
    require "db.php";
    session_start();

    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        $query = "SELECT user_id, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["loggedin"] = true;
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["role"] = $user["role"];
            } else {
                $errorMessage = "Email or Password is wrong";
            }

        } else {
            $errorMessage = "Email or Password is wrong";
        }
    }

    if(isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }

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
                <form method="POST">
                    <input type="text" name="email" placeholder="Your Email" required>
                    <input type="password" name="password" placeholder="Your Password" required>
                    <input type="submit">
                </form>
                <p class="errorMessage"><?= htmlspecialchars($errorMessage) ?></p>
                <a href="register.php" class="loginLink">Don't have an account? Make one now!</a>
        </div>
        </section>
    </body>
</html>
