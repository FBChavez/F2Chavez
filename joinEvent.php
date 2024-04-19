<?php
session_start();
include 'connect.php';

if(isset($_POST['joinEvent'])){
    $eventid = $_POST['eventid'];
    $acctid = $_SESSION['acctid'];

    // Check if acctid is set
    if($acctid === null) {
        echo "Error: User ID not found.";
        // Handle the error as needed (e.g., redirect to login page)
        exit();
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO tbluserevent (acctid, eventid) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $acctid, $eventid);
    $stmt->execute();
    $stmt->close();
    header("Location: userDashboard.php");

}



?>