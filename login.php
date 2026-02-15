<?php
include "db.php";

if(isset($_POST['login'])){

$email=$_POST['email'];
$password=$_POST['password'];

$stmt=$conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows>0){

$user=$result->fetch_assoc();

if(password_verify($password,$user['password'])){

$_SESSION['client']=$user;

header("Location: booking.php");
exit;

}else{
echo "Wrong password";
}

}else{
echo "Email not registered";
}

}
?>
