<?php
    session_start();
    include 'connect.php';
    include 'includes/administratorHeader.php';
    include 'administratorApi.php';    

    // Initialize $stored_admin array
    $stored_admin = [];

    // Query to select all data from tbladmin table
    $admin_query = "SELECT * FROM tbladmin";

    // Execute the query
    $admin_result = $connection->query($admin_query);

    // Check if there are any rows returned
    if ($admin_result->num_rows > 0) {
        // Loop through each row and store the data in the array
        while ($row = $admin_result->fetch_assoc()) {
            $stored_admin[] = $row;
        }
    }

    // Initialize $stored_event array
    $stored_event = [];

    // Query to select all data from tblevent table
    $event_query = "SELECT * FROM tblevent";

    // Execute the query
    $event_result = $connection->query($event_query);

    // Check if there are any rows returned
    if ($event_result->num_rows > 0) {
        // Loop through each row and store the data in the array
        while ($row = $event_result->fetch_assoc()) {
            $stored_event[] = $row;
        }
    }

    // Handle form submission to update event details
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['saveChanges'])) {
        $eventId = $_POST['eventId'];
        $eventDescription = $_POST['eventDescription'];
        $eventVenue = $_POST['eventVenue'];
        $eventFee = $_POST['eventFee'];
        $eventDate = $_POST['eventDate'];
        $eventTime = $_POST['eventTime'];

        // Query to update event details in tblevent table
        $update_query = "UPDATE tblevent SET eventdescription='$eventDescription', eventvenue='$eventVenue', eventfee='$eventFee', date='$eventDate', time='$eventTime' WHERE eventid='$eventId'";
        $connection->query($update_query);

        // Redirect to the same page to refresh the event details
        header("Location: {$_SERVER['PHP_SELF']}?eventid=$eventId");
        exit();
    }

    if (isset($_GET['eventid'])) {
        // Get the value of eventid from the URL
        $eventId = $_GET['eventid'];

        // Initialize eventDetail
        $eventDetail = null;

        // Loop through each event in stored_event array
        foreach ($stored_event as $event) {
            // Check if the eventid matches
            if ($event['eventid'] == $eventId) {
                $eventDetail = $event;
                break; // Exit the loop once the event is found
            }
        }

        // Check if eventDetail is set
        if ($eventDetail !== null) {
            // Now you have $eventDetail containing all details of the event with eventid = $eventId
            // Display the event details and form for editing
?>
            <div class="overview-container">
                <h1 id="eventTitle"><?= $eventDetail['eventtitle'] ?></h1>
                <hr color="white">
                <div class="overview-inner-container">
                    <div class="overview-details" id="eventDetails">
                        <form method="POST" action="">
                            <p>Event Description:</p>
                            <textarea name="eventDescription" placeholder="<?= $eventDetail['eventdescription'] ?>"></textarea>
                            <p>Event Venue:</p>
                            <input type="text" name="eventVenue" placeholder="<?= $eventDetail['eventvenue'] ?>">
                            <p>Event Fee:</p>
                            <input type="text" name="eventFee" placeholder="<?= $eventDetail['eventfee'] ?>">
                            <p>Date:</p>
                            <input type="date" name="eventDate" placeholder="<?= $eventDetail['eventdate'] ?>">
                            <p>Time:</p>
                            <input type="time" name="eventTime" placeholder="<?= $eventDetail['eventtime'] ?>">
                            <input type="hidden" name="eventId" value="<?= $eventId ?>">
                            <br>
                            <button type="submit" name="saveChanges">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
<?php 
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Event ID is missing!";
    }
?>
