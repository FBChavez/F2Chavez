<?php
    include 'connect.php';
    $stored_admin;
    $stored_events = array();

    function toLogin() {
        global $connection, $stored_admin;

        if(isset($_POST['btnAdminLogin'])) {
            $uname = $_POST['txtusername'];
            $pwd = $_POST['txtpassword'];

            $sql = "SELECT * FROM tbladmin WHERE username='$uname'";
            $result = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($result);
            if($count == 1) {
                $adminData = mysqli_fetch_assoc($result);
                
                if(password_verify($pwd, $adminData['password'])) {
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
        
            $adminid = $_SESSION['adminid'];
            
            $sql1 = "INSERT INTO tblevent (eventtitle, adminid, eventdescription, eventvenue, eventfee, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql1);
            $stmt->bind_param("sisssss", $eventtitle, $adminid, $eventdesc, $eventvenue, $eventfee, $date, $time);
            $stmt->execute();
        
            $eventid = mysqli_insert_id($connection);
        
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
        $reverseEvents = array_reverse($stored_events);
        $query = "SELECT e.*, a.name AS adminName FROM tblevent e INNER JOIN tbladmin a ON e.adminid = a.adminid";
        
        $result = $connection->query($query);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              
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

            $adminid = $_SESSION['adminid'];

            $query = "SELECT * FROM tblevent WHERE adminid = '$adminid'";
            $result = $connection->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $query_name = "SELECT name FROM tbladmin WHERE adminid = '$adminid'";
                $result_name = $connection->query($query_name);
                $row_name = $result_name->fetch_assoc();

                $currentPage = basename($_SERVER['PHP_SELF'], ".php");
                $excludePages = array("administratorReports");
                if (!in_array($currentPage, $excludePages)) {
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
                        <div>Deactivate/Activate the "'. $row['eventtitle'] .'" Event? </div>
                        <input type="hidden" name="eventid" value="'.$row['eventid'].'">
                    ';
                
                    echo '<form method="post">
                            <input type="hidden" name="eventid" value="' . $row['eventid'] . '">
                            <input type="hidden" name="eventtitle" value="' . $row['eventtitle'] . '">
                            <input type="hidden" name="status" value="' . $row['status'] . '">
                    ';
                    
                        if($row['status'] == "active") {
                            echo '<input type="submit" name="btnDisplayDeactivationEventConfirmation" id="deactivate" value="Deactivate Event">';
                        } else {
                            echo '<input type="submit" name="btnDisplayActivationEventConfirmation" id="activate" value="Activate Event">';
                        }
                    
                    echo '</form>';
                    
                    echo '</div>';
                    
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
                                        <th>Status</th>
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
                                            <td>' . $row['status'] . '</td>
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
    if(isset($_POST['btnDisplayDeactivationEventConfirmation'])) {
        $eventid = $_POST['eventid'];
        $eventtitle = $_POST['eventtitle'];
        $status = $_POST['status'];
        echo '
            <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                <p>Are you sure you want to deactivate the event "' . $eventtitle . '"?</p>
                <form method="post">
                    <input type="hidden" name="eventid" value="' . $eventid . '">
                    <div style="text-align: center;">
                        <input type="hidden" name="eventid" value="' . $eventid . '">
                        <input type="hidden" name="eventtitle" value="' . $eventtitle . '">
                        <input type="hidden" name="status" value="' . $status . '">
                        <input type="submit" name="btnDeactivateEvent" value="Yes" style="width: 40%;">
                        <input type="submit" onclick="window.location.href = window.location.href;" value="No" style="width: 40%;">
                    </div>
                </form>
            </div>
        ';
    }

    if(isset($_POST['btnDisplayActivationEventConfirmation'])) {
        $eventid = $_POST['eventid'];
        $eventtitle = $_POST['eventtitle'];
        $status = $_POST['status'];
        echo '
            <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                <p>Activate the event "' . $eventtitle . '"?</p>
                <form method="post">
                <input type="hidden" name="eventid" value="' . $eventid . '">
                <div style="text-align: center;">
                    <input type="hidden" name="eventid" value="' . $eventid . '">
                    <input type="hidden" name="eventtitle" value="' . $eventtitle . '">
                    <input type="hidden" name="status" value="' . $status . '">
                    <input type="submit" name="btnActivateEvent" value="Yes" style="width: 40%;">
                    <input type="submit" onclick="window.location.href = window.location.href;" value="No" style="width: 40%;">
                </div>
                </form>
            </div>
        ';
    }

    if(isset($_POST['btnDeactivateEvent'])) {
        $eventid = $_POST['eventid'];
        $eventtitle = $_POST['eventtitle'];
        $status = 'deactivated';

        $sql = "UPDATE tblevent SET status=? WHERE eventid=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $status, $eventid);

        if ($stmt->execute()) {
            echo '
                <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                    <p>Deactivated the event "' . $eventtitle . '"!</p>
                    <form method="post">
                        <div style="text-align: center;">
                            <input type="submit" onclick="window.location.href = window.location.href;" value="DONE" style="width: 40%;">
                        </div>
                    </form>
                </div>
            ';
        } else {
            echo "Error updating user data: " . $stmt->error;
        }
    }

    if(isset($_POST['btnActivateEvent'])) {
        $eventid = $_POST['eventid'];
        $eventtitle = $_POST['eventtitle'];
        $status = 'active';

        $sql = "UPDATE tblevent SET status=? WHERE eventid=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $status, $eventid);

        if ($stmt->execute()) {
            echo '
                <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                    <p>Activated the event "' . $eventtitle . '"!</p>
                    <form method="post">
                        <div style="text-align: center;">
                            <input type="submit" onclick="window.location.href = window.location.href;" value="DONE" style="width: 40%;">
                        </div>
                    </form>
                </div>
            ';
        } else {
            echo "Error updating user data: " . $stmt->error;
        }
    }
    // if (isset($_POST['cancel'])) {
    //     $eventid = $_POST['eventid'];

    //     echo "Event ID: " . $eventid;

    //     $delete_adminevent_sql = "DELETE FROM tbladminevent WHERE eventid = ?";
    //     $delete_adminevent_stmt = $connection->prepare($delete_adminevent_sql);
    //     $delete_adminevent_stmt->bind_param("i", $eventid);
    //     $delete_adminevent_stmt->execute();
    //     $delete_adminevent_stmt->close();

    //     $sql = "DELETE FROM tblevent WHERE eventid = $eventid";

    //     echo "SQL Query: " . $sql;

    //     if ($connection->query($sql) === TRUE) {
    //         echo "Event canceled successfully";
    //     } else {
    //         echo "Error canceling event: " . $connection->error;
    //     }
    // }

    function updateUser() {
        global $connection;

        if(isset($_POST['update']) && isset($_POST['acctid']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['usertype'])) {
            $acctid = $_POST['acctid'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            $usertype = $_POST['usertype'];

            $sql = "UPDATE tbluseraccount SET emailadd=?, username=?, password=?, usertype=? WHERE acctid=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssi", $email, $username, $hashed_password, $usertype, $acctid);

            if ($stmt->execute()) {
                echo '<script>alert("User data updated successfully");</script>';
                echo '<script>window.location.href = "studentList.php";</script>';
            } else {
                echo "Error updating user data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "All fields are required for updating user data";
        }
    }

    function getUserData($acctid) {
        global $connection;

        $sql = "SELECT * FROM tbluseraccount WHERE acctid = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $acctid);

        $stmt->execute();

        $result = $stmt->get_result();

        $userData = $result->fetch_assoc();

        $stmt->close();

        return $userData;
    }


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
    function displayPaidEvents() {
        global $connection;
    
        $query = "SELECT * FROM tblevent WHERE eventfee > 0";
        $result = $connection->query($query);
    
        if ($result->num_rows > 0) {
            echo '
                <table>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Event Fee</th>
                    </tr>
            ';
    
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['eventid'] . '</td>
                        <td>' . $row['eventtitle'] . '</td>
                        <td>$' . $row['eventfee'] . '</td>
                    </tr>
                ';
            }
    
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No paid events found. Sad :(
                </div>
            ';
        }
    }
    function displayUserTypes() {
        global $connection;
    
        $query = "SELECT * FROM tbluseraccount WHERE usertype LIKE '%Teacher%' OR usertype LIKE '%Officer%'";
        $result = $connection->query($query);
    
        if ($result->num_rows > 0) {
            echo '
                <table>
                    <tr>
                        <th>Account ID</th>
                        <th>Name</th>
                        <th>User Type</th>
                    </tr>
            ';
    
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['acctid'] . '</td>
                        <td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>
                        <td>' . $row['usertype'] . '</td>
                    </tr>
                ';
            }
    
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No user types matching "teacher" or "officer" found. Sad :(
                </div>
            ';
        }
    }
    
    function displayNumberGenderParticipants() {
        global $connection;
    
        $query = "SELECT gender, COUNT(*) AS count FROM tbluseraccount WHERE gender IN ('Male', 'Female') GROUP BY gender";
        $result = $connection->query($query);
    
        if ($result->num_rows > 0) {
            echo '
                <table>
                    <tr>
                        <th>Gender</th>
                        <th>Count</th>
                    </tr>
            ';
    
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['gender'] . '</td>
                        <td>' . $row['count'] . '</td>
                    </tr>
                ';
            }
    
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No student data found. Sad :(
                </div>
            ';
        }
    }
    function displayEventsByEachAdmin() {
        global $connection;
    
        $query = "SELECT a.adminid, a.name AS admin_name, COUNT(e.eventid) AS event_count
                  FROM tbladmin a
                  LEFT JOIN tblevent e ON a.adminid = e.adminid
                  GROUP BY a.adminid";
        $result = $connection->query($query);
    
        if ($result->num_rows > 0) {
            echo '
                <table>
                    <tr>
                        <th>Admin ID</th>
                        <th>Admin Name</th>
                        <th>Number of Events Created</th>
                    </tr>
            ';
    
            while ($row = $result->fetch_assoc()) {
                echo '
                    <tr>
                        <td>' . $row['adminid'] . '</td>
                        <td>' . $row['admin_name'] . '</td>
                        <td>' . $row['event_count'] . '</td>
                    </tr>
                ';
            }
    
            echo '</table>';
        } else {
            echo '
                <div class="body-container" style="height: 50vh; text-align: center;">
                    No events created by any admin. Sad :(
                </div>
            ';
        }
    }
    

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

    function displayStudentList() {
        global $connection;

        $query = "SELECT * FROM tbluseraccount";
        $result = $connection->query($query);

        echo '
            <div class="userlist-container">
                <h1 style="padding: 10px;">List of All User Accounts</h1>
                <table id="tblUserAccounts" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <!-- <th>Account Id</th> -->
                            <th>Name</th>
                            <th>Email Address</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Year Level</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
        ';

        while ($row = $result->fetch_assoc()) {
                    echo '
                        <tr>
                            <!-- <td>' . $row['acctid'] . '</td> -->
                            <td style="text-align: left;">' . $row['firstname'] . '' . $row['lastname'] . '</td>
                            <td style="text-align: left;">' . $row['emailadd'] . '</td>
                            <td style="text-align: left;">' . $row['username'] . '</td>
                            <td>' . $row['usertype'] . '</td>
                            <td>' . $row['yearlevel'] . '</td>
                            <td>' . $row['program'] . '</td>
                            <td>' . $row['status'] . '</td>
                            <td>
                                <form action="viewUser.php" method="post">
                                    <input type="hidden" name="acctid" value="' . $row['acctid'] . '">
                                    <input type="submit" name="view" id="view" value="View">
                                </form>
                            </td>
                            <td>
                                <form action="updateUser.php" method="post">
                                    <input type="hidden" name="acctid" value="' . $row['acctid'] . '">
                                    <input type="submit" name="update" id="update" value="Update">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="acctid" value="' . $row['acctid'] . '">
                                    <input type="hidden" name="firstname" value="' . $row['firstname'] . '">
                                    <input type="hidden" name="lastname" value="' . $row['lastname'] . '">
                                    <input type="hidden" name="status" value="' . $row['status'] . '">
                            ';
                                    if($row['status'] == "active") {
                                        echo '<input type="submit" name="btnDisplayDeactivationConfirmation" id="deactivate" value="Deactivate">';
                                    } else {
                                        echo '<input type="submit" name="btnDisplayActivationConfirmation" id="activate" value="Activate">';
                                    }
                            echo '
                                </form>
                            </td>
                        </tr>
                    ';
        }

                echo '
                    </tbody>
                        </table>

                        <a href="administratorReports.php">
                            <button class="hidden" id="reports">Open Reports</button>
                        </a>
                    </div>
                ';

        if(isset($_POST['btnDisplayDeactivationConfirmation'])) {
            $acctid = $_POST['acctid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            echo '
                <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                    <p>Are you sure you want to deactivate the account of user "' . $firstname . ' ' . $lastname . '"?</p>
                    <form method="post">
                        <input type="hidden" name="acctid" value="' . $acctid . '">
                        <div style="text-align: center;">
                            <input type="hidden" name="acctid" value="' . $acctid . '">
                            <input type="hidden" name="firstname" value="' . $firstname . '">
                            <input type="hidden" name="lastname" value="' . $lastname . '">
                            <input type="submit" name="btnDeactivateUser" value="Yes" style="width: 40%;">
                            <input type="submit" onclick="window.location.href = window.location.href;" value="No" style="width: 40%;">
                        </div>
                    </form>
                </div>
            ';
        }

        if(isset($_POST['btnDisplayActivationConfirmation'])) {
            $acctid = $_POST['acctid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            echo '
                <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                    <p>Activate the account of user "' . $firstname . ' ' . $lastname . '"?</p>
                    <form method="post">
                        <input type="hidden" name="acctid" value="' . $acctid . '">
                        <div style="text-align: center;">
                            <input type="hidden" name="acctid" value="' . $acctid . '">
                            <input type="hidden" name="firstname" value="' . $firstname . '">
                            <input type="hidden" name="lastname" value="' . $lastname . '">
                            <input type="submit" name="btnActivateUser" value="Yes" style="width: 40%;">
                            <input type="submit" onclick="window.location.href = window.location.href;" value="No" style="width: 40%;">
                        </div>
                    </form>
                </div>
            ';
        }

        if(isset($_POST['btnDeactivateUser'])) {
            $acctid = $_POST['acctid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $status = 'deactivated';

            $sql = "UPDATE tbluseraccount SET status=? WHERE acctid=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("si", $status, $acctid);

            if ($stmt->execute()) {
                echo '
                    <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                        <p>Deactivated the account of user "' . $firstname . ' ' . $lastname . '"!</p>
                        <form method="post">
                            <div style="text-align: center;">
                                <input type="submit" onclick="window.location.href = window.location.href;" value="DONE" style="width: 40%;">
                            </div>
                        </form>
                    </div>
                ';
            } else {
                echo "Error updating user data: " . $stmt->error;
            }
        }

        if(isset($_POST['btnActivateUser'])) {
            $acctid = $_POST['acctid'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $status = 'active';

            $sql = "UPDATE tbluseraccount SET status=? WHERE acctid=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("si", $status, $acctid);

            if ($stmt->execute()) {
                echo '
                    <div id="confirmation_box" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black; z-index: 9999;">
                        <p>Activated the account of user "' . $firstname . ' ' . $lastname . '"!</p>
                        <form method="post">
                            <div style="text-align: center;">
                                <input type="submit" onclick="window.location.href = window.location.href;" value="DONE" style="width: 40%;">
                            </div>
                        </form>
                    </div>
                ';
            } else {
                echo "Error updating user data: " . $stmt->error;
            }
        }
    }
?>
