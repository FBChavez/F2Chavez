<?php
    
    $adminJSON = "data/admin.json";
    $stored_admin = json_decode(file_get_contents($adminJSON), true);
    $new_admin;
       
    // Creates a new event and stores it in the stored_events which will then be used for other functions
    
    $eventJSON = "data/events.json";
    $stored_events = json_decode(file_get_contents($eventJSON), true);

    function createEvent() {
        global $eventJSON;
        global $stored_events;

        $lastEvent = end($stored_events);
        $eventId = isset($lastEvent['eventId']) ? $lastEvent['eventId'] + 1 : 1; // Kani para malain2 ang event id niya
        
        $new_event = [
            "eventId" => $eventId,
            "adminId" => $_SESSION['uid'],
            "orgId" => null,
            "participants" => [],
            "eventName" => $_POST['eventName'],
            "eventType" => $_POST['eventType'],
            "eventDate" => $_POST['eventDate'],
            "eventTime" => $_POST['eventTime']
        ];
        $votesJSON = "data/votes.json";
        $stored_votes = json_decode(file_get_contents($votesJSON), true);
        
        $new_vote = [
            "upVote" => 0,
            "downVote" => 0,
            "eventId" => $eventId,
            "done" => []
        ];
        if (!isEventExist($new_event, $stored_events)) {

            array_push($stored_events, $new_event);
            array_push($stored_votes, $new_vote);

            if (file_put_contents($eventJSON, json_encode($stored_events, JSON_PRETTY_PRINT))) {
                //echo "<script>alert('Event creation successful')</script>";
                // echo "<script> window.location.href= = 'create-events.php'; </script>";
                // header("Location: create-events.php");
            } else {
                echo "<script>alert('Failed to create event. Please try again.')</script>";
            }
            //to put contents of votes
            if (file_put_contents($votesJSON, json_encode($stored_votes, JSON_PRETTY_PRINT))) {
                //echo "<script>alert('Event creation successful')</script>";
            } else {
                echo "<script>alert('Failed to create event. Please try again.')</script>";
            }
        //end
        } else {
            // echo '<script>alert("Event Already Created")</script>';
            echo '
            <script>
                showNotification("Event already exists");
            </script>
            ';
        }
    }
    // This is to check if an event already exists

    function isEventExist($new_event, $stored_events) {
        foreach ($stored_events as $event) {
            if ($event['eventName'] == $new_event['eventName'] &&
                $event['eventType'] == $new_event['eventType']  &&
                $event['eventDate'] == $new_event['eventDate'] &&
                $event['eventTime'] == $new_event['eventTime'] ) {
                return true;
            }
        }
        return false; 
    }

    // Displays events organized by the logged-in admin 
    // So simply makita ra tanan gi create nga events diri sa dashboard sa admin
    function adminEvents(){
        global $eventJSON;
        global $stored_events;
        $stored_users = json_decode(file_get_contents("data/user.json"), true);

        $reverseEvents = array_reverse($stored_events);

        foreach($reverseEvents as $event){
            if ($event['adminId'] == $_SESSION['uid']){
                
                $orgName;
                //Ikuha ang name sa organizer
                foreach($stored_users as $org){
                    if ($event['orgId'] == $org['uid']){
                        $orgName = $org['name'];
                        break;
                    } else {
                        $orgName = null;
                    }
                }

                $lastP = end($event['participants']);
                $noParts = isset($lastP['partId']) ? $lastP['partId'] : 0;
                
                echo '
                    <div class="the-event">
                        <h2>' . $event['eventName'] . '</h2>
                        <hr>
                        <h3>'. 
                            '<p style="font-size: 15px;margin-top: 0;">• Category: '. $event['eventType'] . '<br>• Date: ' . $event['eventDate'] . '<br>• Time: ' . $event['eventTime'] .
                        '</p></h3> 
                        
                        <hr>
                        <p>• Event Organizer: '.$orgName.'</p>
                        <p>• Number of Participants: '. $noParts .'</p>
                    
                        <div>Cancel the "'. $event['eventName'] .'" Event? </div>
                         <form action="" method="POST">   
                            <input type="hidden" name="eventId" value = '.$event['eventId'].' >
                            <textarea id="cancelReason" name="cancellationReason" method="POST" placeholder="Explain the sudden cancellation of the event to the participants"></textarea>
                            <br>
                            <input type="submit" name="cancel" value="Cancel Event">
                        </form>
                    </div>
                ';
            }
        }
    }
    

    // Cancels an event and sends notifications
    function eventCancel($eventId, $cancellationReason) {
        // echo '<script> console.log('.$cancellationReason.'); </script>';

        global $eventJSON;
        global $stored_events;
        $eventName;

        foreach ($stored_events as $key => $event) {
            if ($event['eventId'] === intval($eventId)) {
                $eventName = $event['eventName'];
                unset($stored_events[$key]);
                break;
            }
        }

        // $stored_events = array_values($stored_events);

        $temp = array();
        foreach($stored_events as $event){
            $temp[] = $event;
        }
    
        $json_encoded = json_encode($temp, JSON_PRETTY_PRINT);
        
        file_put_contents($eventJSON, $json_encoded, LOCK_EX);

        if (!file_put_contents($eventJSON, $json_encoded, LOCK_EX)) {
            echo json_encode(["success" => false, "error" => "Failed to write to file"]);
            exit();
        }
        echo json_encode(["success" => true]);

        //send notification to org and participants about the matter
        cancelNotif($_SESSION['uid'], $eventName, $cancellationReason);

        // exit();
    }

    function cancelNotif($uid, $eventName, $cancellationReason){
        $notifJSON = "data/notif.json";
        $stored_notif = json_decode(file_get_contents($notifJSON), true);

        $lastNotif = end($stored_notif);
        $notifId = isset($lastNotif['notifId']) ? $lastNotif['notifId'] + 1 : 1;
        
        $new_notif = [
            "notifId" => $notifId,
            "uid" => intval($uid),
            "eventId" => null,
            "toAdmin" => false,
            "type" => "event-cancel",
            "title" => "Cancelling of Event " . $eventName,
            "body" => $eventName . " has been called of due to " . $cancellationReason . ". Apologies for the inconvenience." 
        ];

        array_push($stored_notif, $new_notif);

        if (file_put_contents($notifJSON, json_encode($stored_notif, JSON_PRETTY_PRINT))) {
            //echo "<script>alert('Event creation successful')</script>";
        } else {
            echo "<script>alert('Failed to send request. Please try again.')</script>";
        }
    }

    Displays all events stored in the system
    function allEvents(){
        global $eventJSON;
        global $stored_events;
        global $stored_admin;
        $stored_users = json_decode(file_get_contents("data/user.json"), true);
        
        $reverseEvents = array_reverse($stored_events);

        foreach($reverseEvents as $event){

            global $orgName;
            $adName;
            //get name of organizer and admin
            
            //ORGANIZER
            foreach($stored_users as $user){
                if ($event['orgId'] == $user['uid']){
                    $orgName = $user['name'];
                    break;
                } else {
                    $orgName = null;
                }
            }
            //ADMINISTRATOR
            foreach($stored_admin as $ad){
                if ($event['adminId'] == $ad['uid']){
                    $adName = $ad['name'];
                    break;
                }
            }
            
            $lastP = end($event['participants']);
            $noParts = isset($lastP['partId']) ? $lastP['partId'] : 0;

            echo '
                <div class="all-events">
                    <center>
                        <h2 style="margin: 0;">'. $event['eventName'] .'</h2>
                    </center>
                    <hr style="margin-top:10;margin-bottom:10;">
                    <h3 style="margin: 0;">◦ Category: ' .
                         $event['eventType'] . '<br><p style="font-size: 15px;margin-top: 0;">◦ Date: ' . $event['eventDate'] . '<br>◦ Time: ' . $event['eventTime'].'</p></h3>
                    <br>
                         <hr>

                    <p>◦ Admininistrator: '.$adName.'</p>
                    <p>◦ Organizer: '.$orgName.'</p>
                    <p>◦ Number of Participants: '. $noParts .'</p>
                </div>';
        }
    }
    function acceptRequest($requestorId, $eventId){
        $notifJSON = "data/notif.json";
        $stored_notif = json_decode(file_get_contents($notifJSON), true);

        $lastNotif = end($stored_notif);
        $notifId = isset($lastNotif['notifId']) ? $lastNotif['notifId'] + 1 : 1;

        global $eventJSON;
        global $stored_events;
        $eventName;

        // foreach($stored_events as $event){
        //     if($eventId == $event['eventId']){
        //         $event['orgId'] = $requestorId;
        //         $eventName = $event['eventName'];
        //         break;
        //     }
        // }

        $eventKey = array_search($eventId, array_column($stored_events, 'eventId'));
        $eventName = $stored_events[$eventKey]['eventName'];
        
        
        $new_notif = [
            "notifId" => $notifId,
            "uid" => intval($requestorId),
            "eventId" => intval($eventId),
            "toAdmin" => false,
            "type" => "got-accept",
            "title" => "Request Approved",
            "body" => "Your request to be an organizer of " . $eventName . " has been accepted. Get ready to break a leg!" 
        ];
        
        $orgExist = $stored_events[$eventKey]['orgId'];
        if ($orgExist == null){

            if (!isNotificationExist($new_notif, $stored_notif)) {            
                //send notif
                array_push($stored_notif, $new_notif);

                if (file_put_contents($notifJSON, json_encode($stored_notif, JSON_PRETTY_PRINT))) {
                //echo "<script>alert('Event creation successful')</script>";
                } else {
                    echo "<script>alert('Failed to send request. Please try again.')</script>";
                }
                //update orgId or organizer of the event
            
                $stored_events[$eventKey]['orgId'] = intval($requestorId);
            
                if (file_put_contents($eventJSON, json_encode($stored_events, JSON_PRETTY_PRINT))) {
                    //echo "<script>alert('Event creation successful')</script>";
                } else {
                    echo "<script>alert('Failed to send request. Please try again.')</script>";
                }
            } else {
                // echo '<script>alert("Already Answered!")</script>';
                echo '
                    <script>
                        showNotification("Already replied requestor");
                    </script>
                ';
            }
        } else {
            echo '
                <script>
                    showNotification("Already has an organizer");
                </script>
            ';
        }
    }

    function declineRequest($requestorId, $eventId){
        $notifJSON = "data/notif.json";
        $stored_notif = json_decode(file_get_contents($notifJSON), true);

        $lastNotif = end($stored_notif);
        $notifId = isset($lastNotif['notifId']) ? $lastNotif['notifId'] + 1 : 1;

        global $stored_events;
        $eventName;

        // foreach($stored_events as $event){
        //     if($eventId == $event['eventId']){
        //         $eventName = $event['eventName'];
        //         break;
        //     }
        // }

        $eventKey = array_search($eventId, array_column($stored_events, 'eventId'));
        $eventName = $stored_events[$eventKey]['eventName'];
    
        $new_notif = [
            "notifId" => $notifId,
            "uid" => intval($requestorId),
            "eventId" => intval($eventId),
            "toAdmin" => false,
            "type" => "got-decline",
            "title" => "Request Decline",
            "body" => "Your request to be an organizer of " . $eventName . " has been decline. So sad." 
        ];

        
        $orgExist = $stored_events[$eventKey]['orgId'];
        if ($orgExist == null){

            if (!isNotificationExist($new_notif, $stored_notif)) {

                array_push($stored_notif, $new_notif);

                if (file_put_contents($notifJSON, json_encode($stored_notif, JSON_PRETTY_PRINT))) {
                    //echo "<script>alert('Event creation successful')</script>";
                } else {
                    echo "<script>alert('Failed to send request. Please try again.')</script>";
                }
            //end here
            }
        } else {
            // echo '<script>alert("Already Answered!")</script>';
            echo '
                <script>
                    showNotification("Already replied to requestor");
                </script>
            ';
        }
    }

    // Checks if a notification for an event and user already exists
    //to avoid duplication of information to the json file
    function isNotificationExist($new_notif, $stored_notif) {
        $type = false;
        $title = false;

        foreach ($stored_notif as $notif) {

            if ($notif['eventId'] == $new_notif['eventId'] &&
                $notif['uid'] == $new_notif['uid']) {

                //check sa similarities sa type and title
                if ( 
                    ( 
                        $notif['type'] == "got-decline" || 
                        $notif['type'] == "got-accept" 
                    ) && 
                    ( 
                        $new_notif['type'] == "got-decline" || 
                        $new_notif['type'] == "got-accept"
                    )
                    ){
                    $type = true;
                }
                if ( 
                    ( 
                        $notif['title'] == "Request Decline" || 
                        $notif['title'] == "Request Approved"
                    ) && 
                    ( 
                        $new_notif['title'] == "Request Decline" || 
                        $new_notif['title'] == "Request Approved"
                    )
                    ){
                    $title = true;
                }

                if ($type && $title){
                    return true;
                }
            }
        }
        return false; 
    }

    Validates user login credentials
    function toLogin(){
        global $adminJSON; 
        global $stored_admin;
        foreach ($stored_admin as $admin) {
            if($admin['username'] == $_POST['username']){
               if(password_verify($_POST['password'], $admin['password'])){
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['name'] = $admin['name'];
                $_SESSION['uid'] = $admin['uid'];
                $_SESSION['isAdmin'] = true;
        
                echo "<script>alert('You are logged in. Hello {$_SESSION['username']}')</script>";
                header("Location: administratorDashboard.php");
                exit();
               }
            }
        }
        // echo"<script>alert('Log in failed')</script>";
    }

    Handles user registration and data storage
    function toRegister(){
        global $adminJSON;
        global $stored_admin;
    
        $password = $_POST['password'];
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        $lastUser = end($stored_admin);
        $new_admin = [
            "uid" => $lastUser['uid']+1,
            "name" => $_POST['name'],
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "password" => $encrypted_password
        ];
    
        $_SESSION['uid'] = $new_admin['uid'];
        $_SESSION['name'] = $new_admin['name'];
        $_SESSION['username'] = $new_admin['username'];
        $_SESSION['email'] = $new_admin['email'];
        $_SESSION['isAdmin'] = true;
        
        array_push($stored_admin, $new_admin);
        if(file_put_contents($adminJSON, json_encode($stored_admin, JSON_PRETTY_PRINT))){
            echo "<script>alert('Your registration was successful')</script>";
            header("Location: administratorDashboard.php");
            exit();
        } else {
            echo "<script>alert('Something went wrong, please try again')</script>";
        }
    }

?>

