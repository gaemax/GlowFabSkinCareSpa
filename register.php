<?php
    require "db.php";
    session_start();

    if(isset($_SESSION["loggedin"])) {
        header("Location: index.php");
        exit();
    }

    $errorMessage = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $lastname = trim($_POST["lastname"]);
        $firstname = trim($_POST["firstname"]);
        $middlename = trim($_POST["middlename"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $confirmpassword = trim($_POST["confirmPassword"]);

        $query = "SELECT user_id FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($password != $confirmpassword) {
            $errorMessage = "Passwords do not match";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format";
        }

        if ($result->num_rows > 0) {
            $errorMessage = "User already exists";
        }

        if ($errorMessage === "") {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $defaultRole = "client";

            $query = "INSERT INTO users 
            (lastname, firstname, middlename, email, password, role)
            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param(
                "ssssss",
                $lastname,
                $firstname,
                $middlename,
                $email,
                $hashedPassword,
                $defaultRole
            );
            $stmt->execute();
        }
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register - Glow Fab</title>
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
                <form method="POST">
                    <div class ="nameContainer">
                        <input type="text" name="lastname" placeholder="Last Name" required>
                        <input type="text" name="firstname" placeholder="First name" required>
                        <input type="text" name="middlename" placeholder="Middle Name" required>
                    </div>
                    <input name="email" type="text" placeholder="Email" required>
                    <input name="password" type="password" placeholder="Password" required>
                    <input name="confirmPassword" type="password" placeholder="Confirm Password" required>
                    <input type="submit">
                </form>
                <p class="errorMessage"><?= htmlspecialchars($errorMessage) ?></p>
                <a href="login.php" class="loginLink">Back to Login</a>
            </div>
        </section>
    </body>
</html>
