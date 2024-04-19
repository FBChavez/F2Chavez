<?php
    include 'connect.php';
    include ("includes/header.php");
?>
<?php
    // include ("header.php");
    // include('userApi.php');

    // if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //     $requestorId = $_POST['requestorId'];
    //     $eid = $_POST['eventId'];

    //     if (isset($_POST['accept'])){
    //         acceptRequest($requestorId, $eid);
    //         removeNotification($requestorId, $eid);
    //     }
    //     if (isset($_POST['decline'])){
    //         declineRequest($requestorId, $eid);
    //         removeNotification($requestorId, $eid);
    //     }
    // }
?>

<style>
    input[type="submit"]{
    width: 25%;
    height: 20px;
    font-size: 12px;
}
</style>

<div class="events-container">
    <?php
        // echo eventOrganizer();
    ?>
</div>