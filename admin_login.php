<?php
include "db.php";

$admin_user = "admin";
$admin_pass = "admin123";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username==$admin_user && $password==$admin_pass){
        $_SESSION['admin']=$username;
        header("Location: admin.php");
        exit;
    }else{
        $error="Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{ font-family:Arial; background:#f4f6fb; text-align:center; padding-top:80px; }
form{ background:white; width:300px; margin:auto; padding:30px; border-radius:15px; box-shadow:0 5px 20px rgba(0,0,0,.1); }
input{ width:100%; padding:12px; margin:6px 0; border-radius:10px; border:1px solid #ddd; }
button{ width:100%; padding:12px; border:none; border-radius:10px; background:#ff4da6; color:white; cursor:pointer; font-size:16px; }
button:hover{ background:#e60073; }
.error{color:red; margin-bottom:10px;}
</style>
</head>
<body>

<h2>Admin Login</h2>
<?php if(isset($error)){ echo "<p class='error'>$error</p>"; } ?>

<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="login">Login</button>
</form>

</body>
</html>
