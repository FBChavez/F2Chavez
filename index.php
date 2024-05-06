<!--
    * index.php
    * Landing Page
-->

<?php
    include 'connect.php';
    include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<!-- redundant
<head>
    <title>TeknoEvents</title>
    <link rel="stylesheet" type="text/css" href="css/teknoStyles.css">

    // not used
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>
-->

<body>
    <div class="body-container" style="margin: 0%; height: 100%;">
        <h1> Welcome to TeknoEvents! </h1>

        <div class="nav-links">
            <span class="nav">
                <a href="register.php" class="nav-link">
                    Create an Account
                </a>
            </span>

            <span class="nav">
                <a href="login.php" class="nav-link">
                    Login to an account
                </a>
            </span>
        </div>
    </div>
</body>
</html>

<?php
    require_once 'includes/footer.php';
?>


