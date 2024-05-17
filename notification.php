<?php
    session_start();
    include 'connect.php';
    include "includes/header.php";
    include 'eventAPI.php';
?>

<body>
    <div class="create-container">
        <div class="body-container">
            <?php
                echo displayNotifications($_SESSION['acctid']);
            ?>
        </div>
    </div>
</body>

<?php
    require_once 'includes/footer.php';
?>
