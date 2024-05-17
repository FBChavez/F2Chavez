<?php
session_start();
include 'includes/administratorHeader.php';
include 'administratorApi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    updateUser();
}

if (isset($_POST['acctid'])) {
    $acctid = $_POST['acctid'];

    $userData = getUserData($acctid);

    if ($userData) {
        $email = $userData['emailadd'];
        $username = $userData['username'];
        $usertype = $userData['usertype'];
    } else {
        echo "User not found";
        exit();
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
            <form id="eventForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                    <input type="submit" value="Update" name="update" style ="width:30%;">
                </div>
            </form>

            <div style="display:grid; place-items: center;">
                <form action="administratorStudentList.php" method="post">
                    <input type="submit" value="Back" name="back" style="width:100%; padding:10px;">
                </form>
            </div>

        </form>
    </div>
</div>
