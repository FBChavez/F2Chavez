<?php
    session_start();
    include 'connect.php';
    include("administratorApi.php");
    include("includes/administratorHeader.php");

    if (!isset($_SESSION['username'])){
        header('location: administratorLogin.php');
    }
?>

<div id="content-placeholder">
  <?php
       echo allEvents();
  ?>
</div>

<?php
    require_once 'includes/footer.php';
?>


