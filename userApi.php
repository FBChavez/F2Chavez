<?php
    include 'connect.php';

    // Initialize stored users array
    $stored_users = array();

    // Query to fetch data from tbluseraccount
    $userAccountQuery = "SELECT * FROM tbluseraccount";
    $userAccountResult = $connection->query($userAccountQuery);

    // Check if query was successful
    if ($userAccountResult->num_rows > 0) {
        // Loop through each row of tbluseraccount
        while ($userAccountRow = $userAccountResult->fetch_assoc()) {
            // Fetch data from tbluserprofile based on the user's ID
            $userId = $userAccountRow['acctid'];

            /*
            $userProfileQuery = "SELECT * FROM tbluserprofile WHERE userid = $userId";
            $userProfileResult = $connection->query($userProfileQuery);

            // Check if user profile data exists
            if ($userProfileResult->num_rows > 0) {
                $userProfileData = $userProfileResult->fetch_assoc();
            */

            $userData = $userAccountRow;
            $stored_users[] = $userData;
        }
    }

    function toLogin(){
        global $stored_users, $connection;
        foreach($stored_users as $user){
            if(isset($_POST['btnLogin'])){
                $uname=$_POST['txtusername'];
                $pwd=$_POST['txtpassword'];

                $sql = "Select * from tbluseraccount where username='".$uname."'";
                $result = mysqli_query($connection,$sql);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);

                if($count== 0){
                    echo "<div class='message-box error'>Username not existing.</div>";
                }
                else if(password_verify($pwd, $row[6])){
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['acctid'] = $row['acctid'];
                    $_SESSION['firstname'] = $row['firstname'];

                    // will merge userprofile and useraccount later or
                    // remove the userid in userprofile and change into acctid FK from useraccount

                    echo "<script>alert('You are logged in. Hello {$_SESSION['username']}')</script>";
                    header("location: home.php");
                }
                else{
                    echo "<div class='message-box error'>Incorrect password.</div>";
                }
            }
        }
    }

    function toRegister(){
            global $stored_users, $connection;
        if(isset($_POST['btnRegister'])){
            $fname=$_POST['txtfirstname'];
            $lname=$_POST['txtlastname'];
            $gender=$_POST['txtgender'];

            $email=$_POST['txtemail'];
            $uname=$_POST['txtusername'];
            $pword=$_POST['txtpassword'];
            $utype=$_POST['txtusertype'];
            $yrlvl=$_POST['txtyearlevel'];
            $prog=$_POST['txtprogram'];

            $hashedPassword = password_hash($pword, PASSWORD_DEFAULT);

            $sql2 ="Select * from tbluseraccount where username='".$uname."'";
            $result = mysqli_query($connection,$sql2);
            $row = mysqli_num_rows($result);
            if($row == 0){
            /*
                $sql1 ="Insert into tbluserprofile(firstname,lastname,gender) values('".$fname."','".$lname."','".$gender."')";
                mysqli_query($connection,$sql1);
            */

                $user_id = mysqli_insert_id($connection);
                $sql ="Insert into tbluseraccount(firstname,lastname,gender,emailadd,username,password,usertype,yearlevel, program)
                values('".$fname."', '".$lname."', '".$gender."', '".$email."', '".$uname."', '".$hashedPassword."', '".$utype."', '".$yrlvl."', '".$prog."')";
                mysqli_query($connection,$sql);

                header("location: login.php");
            } else{
                echo "<div class='message-box error'>Username already existing.</div>";
            }
        }
    }

    function allEvents() {
        global $stored_users, $connection;
        $query = "SELECT e.*, a.name AS adminName FROM tblevent e INNER JOIN tbladmin a ON e.adminid = a.adminid";
        
        // Execute the query
        $result = $connection->query($query);
        
        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Loop through each row
            while ($row = $result->fetch_assoc()) {
                // Output event details
                echo '
                    <div class="all-events">
                        <center>
                            <a href="events.php?eventid='.$row['eventid'].'">
                                <h2>' . $row['eventtitle'] . '</h2>
                            </a>
                        </center>

                        <hr style="margin-top:10;margin-bottom:10;">

                        <p>◦ Administrator: ' . $row['adminName'] . '</p>
                        <p>◦ Description: ' . $row['eventdescription'] . '</p>
                        <p>◦ Venue: ' . $row['eventvenue'] . '</p>
                        <p>◦ Fee: $' . $row['eventfee'] . '</p>
                        <p>◦ Date: ' . $row['date'] . '</p>
                        <p>◦ Time: ' . $row['time'] . '</p>

                        <form method="POST" action="eventAPI.php">
                            <input type="hidden" name="eventid" value="' . $row['eventid'] . '">
                            <input type="hidden" name="acctid" value="' . $_SESSION['acctid'] . '">
                            <input type="hidden" name="joinEvent" value="true">
                            <input type="submit" name="submit" value="Request to Join"
                            onclick="return confirm(\'Are you sure you want to request to join this event?\')"
                            <?php if($eventIsJoined) echo "disabled"; ?>
                        </form>
                    </div>
                ';
            }
        } else {
            echo 'No events found.';
        }
    }
?>
