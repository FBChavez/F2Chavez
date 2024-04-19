<?php
    session_start();
    include 'connect.php';
    include("administratorApi.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        toLogin();
    }
?> 

<!-- <head>
    <link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
</head> -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/teknoStyles.css">
    <link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>TeknoEvents Admin Login</title>
    <style>
        .header-container {
            background-color: #800000;
            color: #ffffff;
            padding: 20px;
        }

        .toggle-panel {
            background-color: #800000;
        }
    </style>
</head>
<header class="header-container">
    <div class="nav-container">
        <!-- <h2>TeknoEvents</h2> -->
        <div class="row">
            <img src="images/TeknoLogo3.png", height = 40 width = 200/>
        </div>
    </div>
</header>

<div class="container" id="container">
    <div class="form-container sign-in">
        <form method ="post">
            <h1>Admin Log In</h1>
            <input type="text" name="txtusername" placeholder="Username">
            <input type="password" name="txtpassword" placeholder="Password">
            <input type="submit" name="btnAdminLogin" value="Login">
            <h5>Are you a Student? <a href = "login.php">Login</a></h5> 
        </form>
    </div>
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <h1>Welcome, Teknoy!</h1>
                <p>Create an account and enter your personal details to use all of site features</p>
                <a href="register.php">
                    <button class="hidden" id="register">Register</button>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
    require_once 'includes/footer.php';
?>

