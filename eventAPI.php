<?php
    include 'connect.php';

    // Note: Also used for notificationAPI

    if (isset($_SESSION['adminid'])){
        $adminid = $_SESSION['adminid'];
    }

    if(isset($_POST['joinEvent'])){
        $eventid = $_POST['eventid'];
        $acctid = $_POST['acctid'];

        if($acctid === null) {
            echo "<script>alert('Error: User ID not found.');</script>";
            exit();
        }

        $check_sql = "SELECT * FROM tbluserevent WHERE acctid = ? AND eventid = ?";
        $check_stmt = $connection->prepare($check_sql);
        $check_stmt->bind_param("ii", $acctid, $eventid);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if($check_result->num_rows > 0) {
            $check_stmt->close();
            echo "<script>alert('Already requested to join the event!');</script>";

            // Adding debugging message
            echo "<script>console.log('Already requested to join the event!');</script>";

            // Redirecting after 3 seconds for debugging purposes
            echo "<script>setTimeout(function(){ window.location.href = 'userDashboard.php'; }, 10);</script>";
            exit();
        }

        // Prepare and execute the SQL statement
        $sql = "INSERT INTO tbluserevent (acctid, eventid) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $acctid, $eventid);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Event join request submitted successfully!');</script>";
        echo "<script>console.log('Event join request submitted successfully!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'userDashboard.php'; }, 10);</script>";
    }

    function displayJoinRequests() {
        global $connection, $admin;

        if (isset($_POST['accept_join'])) {
            $acctid = $_POST['acctid'];
            $eventid = $_POST['eventid'];

            $adminid = $_SESSION['adminid'];
            $insert_sql = "INSERT INTO tbladminuserevent (adminid, acctid, eventid) VALUES (?, ?, ?)";
            $insert_stmt = $connection->prepare($insert_sql);
            $insert_stmt->bind_param("iii", $adminid, $acctid, $eventid);
            $insert_stmt->execute();
            $insert_stmt->close();

            $update_sql = "UPDATE tbluserevent SET status = 'accepted' WHERE acctid = ? AND eventid = ?";
            $update_stmt = $connection->prepare($update_sql);
            $update_stmt->bind_param("ii", $acctid, $eventid);
            $update_stmt->execute();
            $update_stmt->close();

            header("Location: administratorNotification.php");
            exit();
        }

        if (isset($_POST['reject_join'])) {
            $acctid = $_POST['acctid'];
            $eventid = $_POST['eventid'];

            $update_sql = "UPDATE tbluserevent SET status = 'rejected' WHERE acctid = ? AND eventid = ?";
            $update_stmt = $connection->prepare($update_sql);
            $update_stmt->bind_param("ii", $acctid, $eventid);
            $update_stmt->execute();
            $update_stmt->close();

            header("Location: administratorNotification.php");
            exit();
        }

        $sql = "SELECT * FROM tbluserevent WHERE status = 'pending'";
        $result = $connection->query($sql);


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $acctid =  $row['acctid'];
                $eventid = $row['eventid'];

                $user_sql = "SELECT * FROM tbluseraccount WHERE acctid = $acctid";
                $event_sql = "SELECT * FROM tblevent WHERE eventid = $eventid";

                $user_result = $connection->query($user_sql);
                $event_result = $connection->query($event_sql);

                if ($user_result && $user_result->num_rows > 0) {
                    $user_row = $user_result->fetch_assoc();
                    $firstname = $user_row['firstname'];
                    $lastname = $user_row['lastname'];
                }

                if ($event_result && $event_result->num_rows > 0) {
                    $event_row = $event_result->fetch_assoc();
                    $eventtitle = $event_row['eventtitle'];
                }

                echo '
                    <div class="the-event" style="width: 100%;">
                        <table id="tblUserEvents" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Account ID</th>
                                    <th>Full Name</th>
                                    <th>Event ID</th>
                                    <th>Event Name</th>
                                    <th id="request-message">Request Message</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>' . $acctid . '</td>
                                    <td>' . $firstname . ' ' . $lastname . '</td>
                                    <td>' . $eventid . '</td>
                                    <td>' . $eventtitle . '</td>
                                    <td>' . $firstname . ' requests to join the event <b>"' . $eventtitle . '".</b></td>
                                    <td style="border-right:none;">
                                        <form method="post">
                                            <input type="hidden" name="acctid" value="' . $row['acctid'] . '">
                                            <input type="hidden" name="eventid" value="' . $row['eventid'] . '">
                                            <button type="submit" name="accept_join" id="accept_req">Accept</button>
                                        </form>
                                    </td>
                                    <td style="border-left:none;">
                                        <form method="post">
                                            <input type="hidden" name="acctid" value="' . $row['acctid'] . '">
                                            <input type="hidden" name="eventid" value="' . $row['eventid'] . '">
                                            <button type="submit" name="reject_join">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                ';
            }
        } else {
            echo '
                <div class="body-container" style="height: 40vh; text-align: center;">
                    No notifications found. Sad :(
                </div>
            ';
        }
    }
?>
