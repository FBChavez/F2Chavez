<?php
    session_start();
    include 'connect.php';
    include 'includes/header.php';
    include("userApi.php");
?>

<body>
    <div class="body-container">
        <div class="container" id="container">
            <div class="form-container" style="overflow: auto;">
                <form method="POST">
                    <h1>Create Account</h1>

                    <span>using your school details</span>
                    <input type="text" name="txtfirstname" placeholder="First Name">
                    <input type="text" name="txtlastname" placeholder="Last Name">

                    Gender:
                    <select name="txtgender" placeholder="Gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    User Type:
                    <select name="txtusertype" placeholder="User Type">
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Officer">Officer</option>
                    </select>

                    Year Level:
                    <select name="txtyearlevel" placeholder="Year Level">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>

                    <input type="text" name="txtprogram" placeholder="Program">
                    <input type="email" name="txtemail" placeholder="Email" required>
                    <input type="text" name="txtusername" placeholder="Username" required>
                    <input type="password" name="txtpassword" placeholder="Password" required>

                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            toRegister();
                        }
                    ?>

                    <input type="submit" name="btnRegister" value="Register">
                </form>
            </div>

            <div class="prompt-container">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <a href="login.php">
                    <button class="hidden" id="login">Log In</button>
                </a>
            </div>
        </div>
    </div>
<body>


<?php require_once 'includes/footer.php'; ?>

