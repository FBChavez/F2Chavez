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

    table {
        width: 100%;

        background-color: white;
    }

    table, th, td {
        border: 1px solid;
    }

    th, td {
        width: 10%;
        text-align: center;
        min-height: 50px;
        padding: 10px;
    }

    tr:hover {
        background-color: #A24857;
    }

    #request-message {
        width: 40%;
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