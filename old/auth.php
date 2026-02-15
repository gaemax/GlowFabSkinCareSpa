<!DOCTYPE html>
<html>
<head>
<title>GlowFab Account</title>
<link rel="stylesheet" href="style.css">
<style>
body{
font-family:Arial;
background:#fff0f6;
text-align:center;
padding-top:80px;
}

form{
background:white;
width:330px;
margin:auto;
padding:30px;
border-radius:20px;
box-shadow:0 5px 25px rgba(0,0,0,.15);
}

input{
width:100%;
padding:12px;
margin:6px 0;
border-radius:10px;
border:1px solid #ddd;
}

button{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#ff4da6;
color:white;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#e60073;
}

.switch{
margin-top:10px;
}
</style>
</head>
<body>

<h1 id="title">Login</h1>

<!-- LOGIN FORM -->
<form id="loginForm" action="login.php" method="POST">

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

<div class="switch">
No account? 
<a href="#" onclick="showRegister()">Register here</a>
</div>

</form>


<!-- REGISTER FORM -->
<form id="registerForm" action="register.php" method="POST" style="display:none;">

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="text" name="phone" placeholder="Phone Number" required>
<input type="password" name="password" placeholder="Password" required>

<button type="submit">Register</button>

<div class="switch">
Already have account? 
<a href="#" onclick="showLogin()">Login here</a>
</div>

</form>


<script>

function showRegister(){
document.getElementById("loginForm").style.display="none";
document.getElementById("registerForm").style.display="block";
document.getElementById("title").innerText="Register";
}

function showLogin(){
document.getElementById("loginForm").style.display="block";
document.getElementById("registerForm").style.display="none";
document.getElementById("title").innerText="Login";
}

</script>

</body>
</html>
