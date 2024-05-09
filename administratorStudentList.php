<?php
    session_start();
    include 'includes/administratorHeader.php';
    include 'administratorApi.php';

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

    button:hover, #view:hover, #update:hover {
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

    #view {
        padding: 10px;
        background-color: orange;
        color: white;
        width: 100%;
        height: 45px;
        outline: none;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1em;
        font-weight: 500;
        border: 2px solid #222831;
    }

    #update{
        padding: 10px;
        background-color: green;
        color: white;
        width: 100%;
        height: 45px;
        outline: none;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1em;
        font-weight: 500;
        border: 2px solid #222831;
    }

    #deactivate {
        padding: 10px;
        background-color: #800000;
        color: white;
    }
</style>

<body>
    <div class="body-container" style="margin-top: 7%; overflow: auto;">
        <?php
            echo displayStudentList();
        ?>
    </div>
</body>

<!-- Change Delete to update status

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

-->

<?php require_once 'includes/footer.php'; ?>
