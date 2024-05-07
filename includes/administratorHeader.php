<head>
    <title>TeknoEvents - Admin</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
    <link rel="stylesheet" type="text/css" href="css/teknoStyles.css">
<!--
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
-->
    <style>
        body{
            /* background-image: url('images/background/metroevent2.png'); */
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: center;
            background-attachment: fixed;
            color:black;
        }

        .header-container {
            background-color: #800000;
            color: #ffffff;
            padding: 20px;
        }

        .nav a{
            color: black;
            text-decoration: none;
            background-color: white;
            border-radius: 5px
        }

        .nav a:hover{
            color: white;
            background-color: #9B870C;
            transition: 0.1s ease-in;
        }

        hr{
            margin:0;
        }

        .userlist-container {
            padding: 30px;
            background-color: #fff;
            border-radius: 50px;
        }

        .create-inner-container{
            width: 25%;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            /* background-color: rgb(255, 255, 255, 85%); */
            background-color: #31322f;
            border: 1px solid rgb(255, 255, 255) ;
        }

        .edit-container{
            width: 25%;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            /* background-color: rgb(255, 255, 255, 85%); */
            background-color: #31322f;
            border: 1px solid rgb(255, 255, 255) ;
        }

        .back-link {
            color: #fff;
        }
    </style>
</head>

<?php
    $currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>

<div class="header-container">
    <div class="nav-container">
        <div>
            <img src="images/TeknoLogo3.png", height = 40 width = 200/>
        </div>

        <?php
            $excludePages = array("administratorLogin");
            if (!in_array($currentPage, $excludePages)) {
        ?>

        <span class="nav">
            <a href="administratorDashboard.php" class="nav-link" >
                Events
            </a>
        </span>

        <span class="nav">
            <a href="administratorEventsCreator.php" class="nav-link" >
                Create Events
            </a>
        </span>
        <span class="nav">
            <a href="administratorStudentList.php" class="nav-link" >
                All Users
            </a>
        </span>
        <span class="nav">
            <a href="administratorNotification.php" class="nav-link" >
                Notification
            </a>
        </span>

        <span class="nav">
            <a href="administratorLogin.php" class="nav-link" >
                Log Out
            </a>
        </span>

        <div style="position: absolute; top: 30px; right: 20px;">
            Hello admin, <?php echo $_SESSION['name']; ?>!
        </div>
        <?php } ?>
    </div>
</div>
