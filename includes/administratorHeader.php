<title>TeknoEvents - Admin</title>
<link rel="icon" type="image/x-icon" href="images/TeknoLogo4.png">
<link rel="stylesheet" type="text/css" href="css/teknoStyles.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>

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
</style>

<div class="header-container">
    <div class="nav-container">
        <div class="row" style="display: flex; justify-content: center; align-items: center;">
            <img src="images/TeknoLogo3.png", height = 40 width = 200/>
        </div>
        <span class="nav">
            <a href="administratorDashboard.php" class="nav-link" >
                Events
            </a>
        </span>

        <span class="nav">
            <a href="eventsCreator.php" class="nav-link" >
                Create Events
            </a>
        </span>
        <span class="nav">
            <a href="studentList.php" class="nav-link" >
                All Users
            </a>
        </span>
        <span class="nav">
            <a href="administratorNotification.php" class="nav-link" >
                Notification
            </a>
        </span>

        <span class="nav">
            <a href="administratorLogin.php">
                Log Out
            </a>
        </span>
    </div>
</div>
