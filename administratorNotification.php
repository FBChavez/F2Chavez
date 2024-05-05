<?php
    session_start();
    include 'connect.php';
    include "includes/administratorHeader.php";

    include 'eventAPI.php';
?>
<style>
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
        <?php
            echo displayJoinRequests();
        ?>
    </div>
</body>

<?php
    require_once 'includes/footer.php';
?>