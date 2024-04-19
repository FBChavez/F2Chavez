<?php
// Include the administrator API
include 'includes/administratorHeader.php';
include 'administratorApi.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the updateUser function from administratorApi.php
    updateUser();
}

// Check if acctid is set
if (isset($_POST['acctid'])) {
    // Get acctid from POST data
    $acctid = $_POST['acctid'];

    // Get user data based on acctid
    $userData = getUserData($acctid);

    // Check if user data exists
    if ($userData) {
        // Assign user data to variables
        $email = $userData['emailadd'];
        $username = $userData['username'];
        // Note: Password is not retrieved for security reasons
        $usertype = $userData['usertype'];
    } else {
        echo "User not found";
        exit(); // Stop execution if user data is not found
    }
}
?>
<div class="create-container">
    <div class="create-updateUser-container">
        <form id="eventForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Hidden input for acctid -->
            <h2>Update User Account</h2>
            <input type="hidden" id="acctid" name="acctid" value="<?php echo htmlspecialchars($acctid); ?>">

            <div class="txt_field">
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <label for="email">Email:</label>
            </div>

            <br>

            <div class="txt_field">
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
                <label for="username">Username:</label>
            </div>

            <div class="txt_field">
                <input type="password" id="password" name="password" required><br>
                <label for="password">Password:</label>
            </div>

            <div class="txt_field">
                <input type="text" id="usertype" name="usertype" value="<?php echo htmlspecialchars($usertype); ?>" required><br>
                <label for="usertype">User Type:</label>
            </div>

            <div style="display:grid; place-items: center;">
                <input type="submit" value="Update" name="update" style ="width:60%;">
            </div>

            <div style="display:grid; place-items: center;">
                <a href="studentList.php">Cancel</a>
            </div>
        </form>
    </div>
</div>
