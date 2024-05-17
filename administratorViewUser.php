<?php
    session_start();
    include 'includes/administratorHeader.php';
    include 'administratorApi.php';

    if (isset($_SESSION['adminid'])){
        $adminid = $_SESSION['adminid'];
    }
?>

<?php require_once 'includes/footer.php'; ?>