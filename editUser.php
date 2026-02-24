<?php
    require "db.php";
    session_start();

    echo '<pre>' . print_r($_POST, true) . '</pre>';

    $id = $_SESSION["user_id"];

    $userEditInfo = [];
    $userEditInfo["confirmPassword"] = $_POST["confirmPassword"];
    if ($_POST["editTarget"] === "1") {
        $userEditInfo["lastname"] = $_POST["lastname"];
        $userEditInfo["firstname"] = $_POST["firstname"];
        $userEditInfo["middlename"] = $_POST["middlename"];

        if (!confirmPassword($conn, $userEditInfo["confirmPassword"])) {
            header("Location: userprofile.php?errorMessage=Password+is+Wrong");
            exit;
        }

        $query = "
            UPDATE users
            SET 
                lastname = ?,
                firstname = ?,
                middlename = ?
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sssi",
            $userEditInfo["lastname"],
            $userEditInfo["firstname"],
            $userEditInfo["middlename"],
            $_SESSION["user_id"]);
        $stmt->execute();

        header("Location: userprofile.php?successMessage=Successfully+updated+your+name");
        exit;

    } else if ($_POST["editTarget"] === "2") {
        $userEditInfo["email"] = $_POST["email"];

        if (!confirmPassword($conn, $userEditInfo["confirmPassword"])) {
            header("Location: userprofile.php?errorMessage=Password+is+Wrong");
            exit;
        }

        $query = "
            UPDATE users
            SET 
                email = ?
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "si",
            $userEditInfo["email"],
            $_SESSION["user_id"]);
        $stmt->execute();

        header("Location: userprofile.php?successMessage=Successfully+updated+your+email");
        exit;


    }  else if ($_POST["editTarget"] === "3") {
        $userEditInfo["contactNumber"] = (string)$_POST["contactNumber"];

        if (!confirmPassword($conn, $userEditInfo["confirmPassword"])) {
            header("Location: userprofile.php?errorMessage=Password+is+Wrong");
            exit;
        }

        $query = "
            UPDATE users
            SET 
                contact_number = ?
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "si",
            $userEditInfo["contactNumber"],
            $_SESSION["user_id"]);
        $stmt->execute();

        header("Location: userprofile.php?successMessage=Successfully+updated+your+contact+number");
        exit;


    }  else if ($_POST["editTarget"] === "4") {
        $userEditInfo["oldPassword"] = $_POST["oldPassword"];
        $userEditInfo["newPassword"] = $_POST["newPassword"];
        $userEditInfo["confirmNewPassword"] = $_POST["confirmNewPassword"];

        if (!confirmPassword($conn, $userEditInfo["oldPassword"])) {
            header("Location: userprofile.php?errorMessage=Password+is+Wrong");
            exit;
        }

        if ($userEditInfo["newPassword"] != $userEditInfo["confirmNewPassword"]) {
            header("Location: userprofile.php?errorMessage=Passwords+do+not+match");
            exit;
        }

        $hashedPassword = password_hash($userEditInfo["newPassword"], PASSWORD_DEFAULT);

        $query = "
            UPDATE users
            SET 
                password = ?
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "si",
            $hashedPassword,
            $_SESSION["user_id"]);
        $stmt->execute();

        header("Location: userprofile.php?successMessage=Successfully+updated+your+password");
        exit;

    }

    function confirmPassword($conn, $password) {
        $query = "
            SELECT password
            FROM users
            WHERE user_id = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        return password_verify($password, $user["password"]);
    }

    echo '<pre>' . print_r($userEditInfo, true) . '</pre>';

?>