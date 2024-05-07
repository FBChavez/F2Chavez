<?php
    include 'connect.php';
    $stored_admin;
    $stored_events = array();

    function toLogin() {
        global $connection, $stored_admin;

        if(isset($_POST['btnAdminLogin'])) {
            $uname = $_POST['txtusername'];
            $pwd = $_POST['txtpassword'];

            // Query to fetch admin data
            $sql = "SELECT * FROM tbladmin WHERE username='$uname'";
            $result = mysqli_query($connection, $sql);
            // Get the number of rows returned
            $count = mysqli_num_rows($result);
            // Check if admin exists
            if($count == 1) {
                $adminData = mysqli_fetch_assoc($result);
                
                // Verify password
                if(password_verify($pwd, $adminData['password'])) {
                    // Admin authentication successful, store admin details
                    $stored_admin = $adminData;
                    $_SESSION['username'] = $adminData['username'];
                    $_SESSION['name'] = $adminData['name'];
                    $_SESSION['adminid'] = $adminData['adminid'];
                    header("location: administratorDashboard.php");
                    exit();
                }
            }
            echo "<div class='message-box error'>Incorrect username or password.</div>";
        }
    }

    function createEvent(){
        global $connection, $stored_events;
        $lastEvent = end($stored_events);
        if(isset($_POST['create'])){
            $eventtitle=$_POST['eventName'];
            $eventdesc=$_POST['eventDescription'];
            $eventvenue=$_POST['eventVenue'];
            $eventfee=$_POST['eventFee'];
            $date=$_POST['eventDate'];
            $time=$_POST['eventTime'];
        
            // Get adminid from session
            $adminid = $_SESSION['adminid'];
            
            // Save data to tblevent
            $sql1 = "INSERT INTO tblevent (eventtitle, adminid, eventdescription, eventvenue, eventfee, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql1);
            $stmt->bind_param("sisssss", $eventtitle, $adminid, $eventdesc, $eventvenue, $eventfee, $date, $time);
            $stmt->execute();
        
            // Get the auto-generated eventid
            $eventid = mysqli_insert_id($connection);
        
            // Save adminid and eventid to tbladminevent
            $sql2 = "INSERT INTO tbladminevent (adminid, eventid) VALUES (?, ?)";
            $stmt2 = $connection->prepare($sql2);
            $stmt2->bind_param("ii", $adminid, $eventid);
            $stmt2->execute();
        
            $stmt->close();
            $stmt2->close();
        }
    }

    function allEvents() {
        global $stored_admin, $connection, $stored_events;
        // Query to fetch event details from the database
        $reverseEvents = array_reverse($stored_events);
        $query = "SELECT e.*, a.name AS adminName FROM tblevent e INNER JOIN tbladmin a ON e.adminid = a.adminid";
        
        // Execute the query
        $result = $connection->query($query);
        
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Loop through each row
            while ($row = $result->fetch_assoc()) {
              
                // Output event details
                echo '
                    <div class="the-event" style="width: 80%;">
                        <center>
                        <h2>' . $row['eventtitle'] . '</h2>
                        </center>
                        <hr style="margin-top:10;margin-bottom:10;">
                        <p>◦  Administrator: ' . $row['adminName'] . '</p>
                        <p>◦ Description: ' . $row['eventdescription'] . '</p>
                        <p>◦ Venue: ' . $row['eventvenue'] . '</p>
                        <p>◦ Fee: $' . $row['eventfee'] . '</p>
                        <p>◦ Date: ' . $row['date'] . '</p>
                        <p>◦ Time: ' . $row['time'] . '</p>
                    </div>
                ';
            }
        } else {
            echo '
                <div class="body-container" style="height: 80vh; text-align: center;">
                    No events found. Sad :(
                </div>
            ';
        }
    }

    function adminEvents() {
        global $connection;
        global $adminid;
        // Get the adminid of the current administrator from session
            $adminid = $_SESSION['adminid'];
            // Query to fetch only the events created by the current administrator
            $query = "SELECT * FROM tblevent WHERE adminid = '$adminid'";
            $result = $connection->query($query);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Loop through each row
            while ($row = $result->fetch_assoc()) {
                $query_name = "SELECT name FROM tbladmin WHERE adminid = '$adminid'";
                $result_name = $connection->query($query_name);
                $row_name = $result_name->fetch_assoc();


                $currentPage = basename($_SERVER['PHP_SELF'], ".php");
                $excludePages = array("administratorReports");
                if (!in_array($currentPage, $excludePages)) {
                    // Output event details
                    echo '
                        <div class="the-event">
                            <a href="events.php?eventid='.$row['eventid'].'">
                                <h2 style="margin: 0;">'. $row['eventtitle'] .'</h2>
                            </a>
                            <hr style="margin-top:10;margin-bottom:10;">
                            <p>◦ Administrator: ' . $row_name['name'] . '</p>
                            <p>◦ Description: ' . $row['eventdescription'] . '</p>
                            <p>◦ Venue: ' . $row['eventvenue'] . '</p>
                            <p>◦ Fee: $' . $row['eventfee'] . '</p>
                            <p>◦ Date: ' . $row['date'] . '</p>
                            <p>◦ Time: ' . $row['time'] . '</p>
                            <div>Cancel the "'. $row['eventtitle'] .'" Event? </div>
                            <form action="" method="POST">
                                <input type="hidden" name="eventid" value = '.$row['eventid'].' >
                                <textarea id="cancelReason" name="cancellationReason" method="POST" placeholder="Explain the sudden cancellation of the event to the participants"></textarea>
                                <br>
                                <input type="submit" name="cancel" value="Cancel Event">
                            </form>
                        </div>
                    ';
                } else {
                    echo '
                        <div class="the-event">
                            <table id="tblUserAccounts" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Event ID</th>
                                        <th>Event Title</th>
                                        <th>Administrator Name</th>
                                        <th id="description">Description</th>
                                        <th>Venue</th>
                                        <th>Fee</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $row_name ?>
                                    <tr>
                                        <td>' . $row['eventid'] . '</td>
                                        <td>' . $row['eventtitle'] . '</td>
                                        <td>' . $row_name['name'] . '</td>
                                        <td id="description">' . $row['eventdescription'] . '</td>
                                        <td>' . $row['eventvenue'] . '</td>
                                        <td>' . $row['eventfee'] . '</td>
                                        <td>' . $row['date'] . '</td>
                                        <td>' . $row['time'] . '</td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    ';
                }
            }
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No events found. Sad :(
                </div>
            ';
        }
    }
    if (isset($_POST['cancel'])) {
        // Retrieve the event ID from the form submission
        $eventid = $_POST['eventid'];
        
        // Debugging: Echo the event ID to see if it's properly retrieved
        echo "Event ID: " . $eventid;
    
        // Delete related records in tbladminevent first
        $delete_adminevent_sql = "DELETE FROM tbladminevent WHERE eventid = ?";
        $delete_adminevent_stmt = $connection->prepare($delete_adminevent_sql);
        $delete_adminevent_stmt->bind_param("i", $eventid);
        $delete_adminevent_stmt->execute();
        $delete_adminevent_stmt->close();
    
        // Delete the event from the tblevent table
        $sql = "DELETE FROM tblevent WHERE eventid = $eventid";
    
        // Debugging: Echo the SQL query to see if it's constructed correctly
        echo "SQL Query: " . $sql;
    
        if ($connection->query($sql) === TRUE) {
            echo "Event canceled successfully";
        } else {
            echo "Error canceling event: " . $connection->error;
        }
    }

    function updateUser() {
        global $connection;

        // Check if all required fields are present
        if(isset($_POST['update']) && isset($_POST['acctid']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['usertype'])) {
            // Retrieve form data
            $acctid = $_POST['acctid'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $usertype = $_POST['usertype'];

            // Prepare update query
            $sql = "UPDATE tbluseraccount SET emailadd=?, username=?, password=?, usertype=? WHERE acctid=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssi", $email, $username, $hashed_password, $usertype, $acctid);

            // Execute the update query
            if ($stmt->execute()) {
                echo '<script>alert("User data updated successfully");</script>';
                echo '<script>window.location.href = "studentList.php";</script>';
            } else {
                echo "Error updating user data: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            echo "All fields are required for updating user data";
        }
    }

    function getUserData($acctid) {
        global $connection;

        // Prepare query to fetch user data
        $sql = "SELECT * FROM tbluseraccount WHERE acctid = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $acctid);

        // Execute query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        // Fetch user data
        $userData = $result->fetch_assoc();

        // Close statement
        $stmt->close();

        return $userData;
    }


    /* I added a table in the reports to show the number of students for each program */
    function displayUsersPerProgram() {
        global $connection;

        $query = "SELECT program, COUNT(program) AS count FROM tbluseraccount GROUP BY program";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            echo '
                <table id="displayCountProg">
                    <tr>
                        <th>Program</th>
                        <th>No. of accounts</th>
                    </tr>
            ';
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>" . $row['program'] . "</td>";
                    echo "<td>" . $row['count'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No accounts! Sad :(
                </div>
            ';
        }
    }

    /* table nis para participants per event */
    function displayParticipantsPerEvent() {
        global $connection;

        $query = "SELECT e.eventtitle AS 'Event Name', a.name AS 'Admin', COUNT(aue.acctid) AS 'No. of participants', e.eventid
                  FROM tblevent e
                  JOIN tbladmin a ON e.adminid = a.adminid
                  JOIN tbladminuserevent aue ON e.eventid = aue.eventid
                  GROUP BY e.eventid
                  ORDER BY e.eventtitle";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            echo '
                <table>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Admin</th>
                        <th>No. of participants</th>
                    </tr>
            ';
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['eventid'] . '</td>
                        <td>' . $row['Event Name'] . '</td>
                        <td>' . $row['Admin'] . '</td>
                        <td>' . $row['No. of participants'] . '</td>
                </tr>
                ';
            }
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No events! Sad :(
                </div>
            ';
        }
    }

    function displayUserEvents() {
        global $connection;

        $query = "SELECT e.eventid, e.eventtitle, ua.username, ue.status
                  FROM tbluserevent ue
                  INNER JOIN tbluseraccount ua ON ue.acctid = ua.acctid
                  INNER JOIN tblevent e ON ue.eventid = e.eventid";

        $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['eventid'] . '</td>
                        <td>' . $row['username'] . '</td>
                        <td>' . $row['eventtitle'] . '</td>
                        <td>' . $row['status'] . '</td>
                    </tr>
                ';
            }
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No user events! Sad :(
                </div>
            ';
        }
    }
?>
