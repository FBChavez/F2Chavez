<?php
include 'includes/administratorHeader.php';

$conn = new mysqli('localhost', 'root', '', 'dbchavezf2');
$query = "SELECT * FROM tbluseraccount";
$result = $conn->query($query);
?>

<style>
    .userlist-container {
    }

    table, th, td {
      border: 1px solid;
    }

    td {
      text-align: center;
      height: 50px;
    }

    tr:hover {
        background-color: #A24857;
    }
</style>

<div class="userlist-container">
    List of All User Accounts
    <table id="tblUserAccounts" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Account Id</th>
                <th>Email Address</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Year Level</th>
                <th>Program</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['acctid'] ?></td>
                <td><?php echo $row['emailadd'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td><?php echo $row['usertype'] ?></td>
                <td><?php echo $row['yearlevel'] ?></td>
                <td><?php echo $row['program'] ?></td>
                <td>
                    <form action="viewUser.php" method="post">
                        <input type="hidden" name="acctid" value="<?php echo $row['acctid'] ?>">
                        <button type="submit" name="view">VIEW</button>
                    </form>
                </td>
                <td>
                    <form action="updateUser.php" method="post">
                        <input type="hidden" name="acctid" value="<?php echo $row['acctid'] ?>">
                        <button type="submit" name="update">UPDATE</button>
                    </form>
                </td>
                <td>
                    <form id="deleteForm<?php echo $row['acctid'] ?>" method="post" onsubmit="return confirmDelete(<?php echo $row['acctid'] ?>)">
                        <input type="hidden" name="acctid" value="<?php echo $row['acctid'] ?>">
                        <button type="submit" name="delete_user">DELETE</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(acctid) {
        // Display a confirmation dialog
        var result = confirm("Are you sure you want to delete this user?");
        // If user confirms, return true to submit the form and delete the user
        return result;
    }
</script>

<?php
if (isset($_POST['delete_user'])) {
    // Retrieve the acctid from the form submission
    $acctid = $_POST['acctid'];

    // Delete the user from the database
    $sql = "DELETE FROM tbluseraccount WHERE acctid = $acctid";

    if ($conn->query($sql) === TRUE) {
        // Redirect to studentList.php after successful deletion
        echo '<script>alert("User deleted successfully");</script>';
        echo '<script>window.location.href = "studentList.php";</script>';
    } else {
        echo "Error deleting user: ".$conn->error;
    }
}
?>
