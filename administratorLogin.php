<?php
    session_start();
    include 'connect.php';
    include 'includes/administratorHeader.php';
    include("administratorApi.php");
?> 

<head>
    <style>
        .prompt-container {
            background: linear-gradient(to right, #9B870C, #800000);
        }
    </style>
</head>

<body>
    <div class="body-container">
        <div class="container" id="container">
            <div class="form-container" style="justify-content: center;">
                <form method ="POST">
                    <h1>Admin Log In</h1>
                    <input type="text" name="txtusername" placeholder="Username">
                    <input type="password" name="txtpassword" placeholder="Password">
                    <input type="submit" name="btnAdminLogin" value="Login">
                    <?php
                         if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            toLogin();
                        }
                    ?>
                    <h5>Are you a Student? <a href = "login.php">Login</a></h5>
                </form>
            </div>

            <div class="prompt-container">
                <h1>Hello Admin!</h1>
                <p>Are you an admin? If not, please click the button to redirect to user's log in.</p>
                <a href="login.php">
                    <button id="login">Back to User Log In</button>
                </a>
            </div>
        </div>
    </div>
</body>

<?php
    require_once 'includes/footer.php';
?>

