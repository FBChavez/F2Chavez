<?php
    session_start();
    include 'connect.php';
    include 'includes/header.php';
    include("userApi.php");
?>

<body>
    <div class="body-container">
        <div class="container" id="container">
            <div class="form-container" style="justify-content: center;">
                <form method="POST">
                    <h1>Log In</h1>
                    <input type="text" name="txtusername" placeholder="Username" required>
                    <input type="password" name="txtpassword" placeholder="Password" required>
                    <input type="submit" name="btnLogin" value="Login">
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            toLogin();
                        }
                    ?>
                    <h5>Are you an Admin? <a href = "administratorLogin.php">Login</a></h5>
                </form>
            </div>

            <div class="prompt-container">
                <h1>Welcome, Teknoy!</h1>
                <p>Create new account and enter your personal details to use all of site features.</p>
                <a href="register.php">
                    <button id="register">Register</button>
                </a>
            </div>
        </div>
    </div>
</body>

<?php require_once 'includes/footer.php'; ?>

