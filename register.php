<?php
    session_start();
    include 'connect.php';
    include("userApi.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        toRegister();
    }
?>
<head>
    <link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
</head>
<header class="header-container">
    <div class="nav-container">
        <div class="row">
            <img src="images/TeknoLogo3.png", height = 40 width = 200/>
        </div>
    </div>
</header>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/teknoStyles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>TeknoEvents Register</title>
</head>

<div class="container" id="container" style="max-width: ; margin: 20px auto; height: auto ;">
    <div class="form-container sign-in" style="overflow-y: auto; max-height: 500px;">
        <form method="post">
            <h1>Create Account</h1>
            <span>using your school details</span>
            <input type="text" name="txtfirstname" placeholder="First Name">
            <input type="text" name="txtlastname" placeholder="Last Name">
            Gender:
            <select name="txtgender" placeholder="Gender">
                <option value="">----</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <!-- User Type:
            <select name="txtusertype" placeholder="User Type">
                <option value="">----</option>
                <option value="Student">Student</option>
                <option value="Teacher">Teacher</option>
                <option value="Officer">Officer</option>
            </select> 
            
            <div id="studentFields" style="display: none;">
                Year Level:
                <select name="txtyearlevel" placeholder="Year Level">
                    <option value="">----</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
                Program:
                <input type="text" name="txtprogram" placeholder="Program">
            </div> -->
            <input type="email" name="txtemail" placeholder="Email">
            <input type="text" name="txtusername" placeholder="Username">
            <input type="password" name="txtpassword" placeholder="Password">
            <input type="submit" name="btnRegister" value="Register">
            
        </form>
    </div>

    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account? We got you! </p>
                <a href="login.php">
                    <button class="hidden" id="login">Log In</button>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 
<?php require_once 'includes/footer.php'; ?> -->

