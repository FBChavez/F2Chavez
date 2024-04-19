<?php
    session_start();
    include('connect.php');
    include("includes/administratorHeader.php");
    include("administratorApi.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['create'])){
            createEvent();
        }
        // if (isset($_POST['cancel'])){
        //     $eventId = $_POST['eventid'];
        //     // $cancellationReason = $_POST['cancellationReason'];
        //     // eventCancel($eventId, $cancellationReason);
        // }
    }

?>

<div class="create-container">
    <div class="create-inner-container">

        <h2>Create New Event</h2>

        <form id="eventForm" action="" method="POST" >
            <div class="txt_field">
                <input type="text" id="eventName" name="eventName" method="POST" required>
                <label for="eventName">Event Title: </label>
            </div>

            <div class="txt_field">
                <input type="text" id="eventDescription" name="eventDescription" method="POST" required>
                <label for="eventDescription">Description: </label>
            </div>
            <div class="txt_field">
                <input type="text" id="eventVenue" name="eventVenue" method="POST" required>
                <label for="eventVenue">Venue: </label>
            </div>
            <div class="txt_field">
                <input type="text" id="eventFee" name="eventFee" method="POST" required>
                <label for="eventFee">Fee: </label>
            </div>
            <div class="txt_field">
                <input type="date" id="eventDate" name="eventDate" method="POST" placeholder="" required>
                <label for="eventDate">Date: </label>
            </div>

            <div class="txt_field">
                <input type="time" id="eventTime" name="eventTime" method="POST" placeholder="" required>
                <label for="eventTime">Time: </label>
            </div>

            <input type="submit" name="create" value="Create Event">
        </form>
    </div>

    <div class="admin-events">
        <div>
            <!-- display sa mga gipang create na events -->
            <?php
                 echo adminEvents();
            ?>
        </div>
    </div>
</div>
<?php
    
?>