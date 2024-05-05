<head>
    <title>TeknoEvents</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
    <link rel="stylesheet" type="text/css" href="css/teknoStyles.css">
    <link rel="stylesheet" href="css/notification.css">
</head>

<?php
    $currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>

<header class="header-container">
    <div class="nav-container">
        <div>
            <img src="images/TeknoLogo3.png", height = 40 width = 200/>
        </div>

        <?php
            $excludePages = array("index", "login", "register");
            if (!in_array($currentPage, $excludePages)) {
        ?>

        <span class="nav">
            <a href="home.php" class="nav-link" >
                Home
            </a>
        </span>
        <span class="nav">
            <a href="userDashboard.php" class="nav-link">
                Events
            </a>
        </span>
        <!-- might not use
        <span class="nav">
            <a href="eventsOrganizer.php" class="nav-link">
                Events Organizer
            </a>
        </span>
        -->
        <span class="nav">
            <a href="notification.php" class="nav-link">
                Notification
            </a>
        </span>

        <span class="nav">
            <a href="about.php" class="nav-link">
                About Us
            </a>
        </span>

        <span class="nav">
            <a href="contact.php" class="nav-link">
                Contact Us
            </a>
        </span>
        <span class="nav">
            <a href="login.php" class="nav-link">
                Logout
            </a>
        </span>

        <?php } ?>
    </div>
</header>
