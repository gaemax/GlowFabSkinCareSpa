<?php
    require "db.php";
    session_start();

    if(!isset($_SESSION["loggedin"])) {
        header("location: login.php");
    }

    $query = "
        SELECT *
        FROM users
        WHERE user_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $currentUser = $result;

    $editing = false;
    $editingTarget = 0;
    if (isset($_GET["edit"])) {
        $editing = true;
        $editingTarget = match($_GET["edit"]) {
            "name" => 1,
            "email" => 2,
            "contact_number" => 3,
            "password" => 4
        };
    }

    if (isset($_GET['errorMessage']) && $_GET['errorMessage'] !== '') {
        $message = htmlspecialchars($_GET['errorMessage'], ENT_QUOTES, 'UTF-8');
        echo "<script>alert('$message');</script>";
    }

    if (isset($_GET['successMessage']) && $_GET['successMessage'] !== '') {
        $message = htmlspecialchars($_GET['successMessage'], ENT_QUOTES, 'UTF-8');
        echo "<script>alert('$message');</script>";
    }

?>

<html>

    <head>
        <title>Profile - Glow Fab</title>
        <link rel="stylesheet" href="styles/global.css">
        <link rel="stylesheet" href="styles/userprofile.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>

    <body>
        
        <header>
            <div class="navigatorBar">
                <h1>Glow Fab</h1>
                <ul>
                    <li><a href="index.php">Back</a></li>
                </ul>
            </div>
        </header>
        
        <div class="userInfoCard">
            <i class="fa-regular fa-circle-user profileIcon"></i>
            <form method="POST" action="editUser.php" class="userForm">
                <div class="userInfo">
                    <h4>Name</h4>
                    <?php if($editing && $editingTarget === 1): ?>
                        <div class="editGroup">
                            <input type="hidden" name="editTarget" value="1">
                            <input type="text" class="editInput" name="lastname" placeholder="Last Name" value="<?= $currentUser["lastname"] ?>">
                            <input type="text" class="editInput" name="firstname" placeholder="First Name" value="<?= $currentUser["firstname"] ?>">
                            <input type="text" class="editInput" name="middlename" placeholder="Middle Name" value="<?= $currentUser["middlename"] ?>">
                            <input type="password" class="editInput" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                    <?php else: ?>
                        <p><?= $currentUser["lastname"] ?>, <?= $currentUser["firstname"] ?> <?= $currentUser["middlename"] ?></p>
                    <?php endif; ?>
                    <?php if($editing && $editingTarget === 1): ?>
                        <div class="editGroup">
                            <button type="submit" class="editInput">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <a href="userprofile.php"><i class="fa-solid fa-x"></i></i></a>
                        </div>
                    <?php else: ?>
                        <a href="userprofile.php?edit=name"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php endif; ?>
                    

                    <h4>Email</h4>
                    <?php if($editing && $editingTarget === 2): ?>
                        <div class="editGroup">
                            <input type="hidden" name="editTarget" value="2">
                            <input type="email" class="editInput" name="email" placeholder="Email" value="<?= $currentUser["email"] ?>">
                            <input type="password" class="editInput" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                    <?php else: ?>
                        <p><?= $currentUser["email"] ?></p>
                    <?php endif; ?>
                    <?php if($editing && $editingTarget === 2): ?>
                        <div class="editGroup">
                            <button type="submit" class="editInput">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <a href="userprofile.php"><i class="fa-solid fa-x"></i></i></a>
                        </div>
                    <?php else: ?>
                        <a href="userprofile.php?edit=email"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php endif; ?>

                    <h4>Contatct No.</h4>
                    <?php if($editing && $editingTarget === 3): ?>
                        <div class="editGroup">
                            <input type="hidden" name="editTarget" value="3">
                            <input type="text" class="editInput" name="contactNumber" placeholder="Contact Number" value="<?= $currentUser["contact_number"] ?>">
                            <input type="password" class="editInput" name="confirmPassword" placeholder="Confirm Password">
                        </div>
                    <?php else: ?>
                        <p><?= $currentUser["contact_number"] ?></p>
                    <?php endif; ?>
                    <?php if($editing && $editingTarget === 3): ?>
                        <div class="editGroup">
                            <button type="submit" class="editInput">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <a href="userprofile.php"><i class="fa-solid fa-x"></i></i></a>
                        </div>
                    <?php else: ?>
                        <a href="userprofile.php?edit=contact_number"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php endif; ?>

                    <h4>Password</h4>
                    <?php if($editing && $editingTarget === 4): ?>
                        <div class="editGroup">
                            <input type="hidden" name="editTarget" value="4">
                            <input type="password" class="editInput" name="oldPassword" placeholder="Current Password">
                            <input type="password" class="editInput" name="newPassword" placeholder="New Password">
                            <input type="password" class="editInput" name="confirmNewPassword" placeholder="Confirm New Password">
                        </div>
                    <?php else: ?>
                        <p>●●●●●●●●●●●●</p>
                    <?php endif; ?>
                    <?php if($editing && $editingTarget === 4): ?>
                        <div class="editGroup">
                            <button type="submit" class="editInput">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <a href="userprofile.php"><i class="fa-solid fa-x"></i></i></a>
                        </div>
                    <?php else: ?>
                        <a href="userprofile.php?edit=password"><i class="fa-solid fa-pen-to-square"></i></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

    </body>

</html>