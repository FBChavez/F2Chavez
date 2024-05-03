<?php
    session_start();
    include('connect.php');
    include("includes/administratorHeader.php");
    include("administratorApi.php");
?>

<style>
    .report-container {
        width: 70%;
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
    <div class="body-container">
        <div class="report-container">
            My Created Events
            <?php
                echo adminEvents();
            ?>
        </div>
        <a href="studentList.php">
            <button class="hidden" id="reports">Back</button>
        </a>
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
