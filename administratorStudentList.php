<?php
    session_start();
    include 'includes/administratorHeader.php';

    $conn = new mysqli('localhost', 'root', '', 'dbchavezf2');
    $query = "SELECT * FROM tbluseraccount";
    $result = $conn->query($query);

    if (isset($_SESSION['adminid'])){
        $adminid = $_SESSION['adminid'];
    }
?>

<style>
    .userlist-container {
        text-align: center;
    }

    button {
        margin: 5px;
        padding: 5px;

        background-color: #800000;
        color: white;
    }

    button:hover {
        background-color: white;
        color: #800000;
    }

    table, th, td {
        border: 1px solid;
    }

    td, th {
        text-align: center;
        height: 50px;
        padding: 10px;
    }

    tr:hover {
        background-color: #A24857;
    }
</style>

<body>
    <div class="body-container" style="margin-top: 7%; overflow: auto;">
        <div class="userlist-container">
            <h1 style="padding: 10px;">List of All User Accounts</h1>
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

            <a href="administratorReports.php">
                <button class="hidden" id="reports">Open Reports</button>
            </a>
        </div>
    </div>
</body>

<script>
    function confirmDelete(acctid) {
        var result = confirm("Are you sure you want to delete this user?");
        return result;
    }
</script>

<?php
    if (isset($_POST['delete_user'])) {
        $acctid = $_POST['acctid'];

        $sql = "DELETE FROM tbluseraccount WHERE acctid = $acctid";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("User deleted successfully");</script>';
            echo '<script>window.location.href = "studentList.php";</script>';
        } else {
            echo "Error deleting user: ".$conn->error;
        }
    }
?>

<?php require_once 'includes/footer.php'; ?>
