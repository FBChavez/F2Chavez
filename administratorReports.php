<?php
    session_start();
    include('connect.php');
    include("includes/administratorHeader.php");
    include("administratorApi.php");
?>

<style>
    .report-container {
        margin: 10px;
        border-radius: 25px;
        text-align: center;
        padding: 20px;
        width: 100%;

        background-color: #D3D3D3;
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

    table {
        width: 100%;

        background-color: white;
    }

    table, th, td {
        border: 1px solid;
    }

    td, th {
        width: 10%;
        min-height: 50px;
        padding: 10px;
    }

    #description {
        width: 30%;
    }

    #displayCountProg {
        width: 30%;
        margin: 0 auto;
    }

    tr:hover {
        background-color: #A24857;
    }
</style>

<body>
    <div class="body-container" style="margin-top: 7%; overflow: auto;">
        <h1> Reports: </h1>
        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px;">My Created Events</h2>
                <?php
                    echo adminEvents();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px;">Number of accounts for each Program</h2>
                <?php
                    echo displayUsersPerProgram();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px;">Number of participants for each Event</h2>
                <?php
                    echo displayParticipantsPerEvent();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <table id="tblUserAccounts" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <h2 style="padding: 10px;">
                    All User Events
                </h2>
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>User</th>
                            <th>Event Title</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo displayUserEvents();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px">
                    All Paid Events
                </h2>
                <?php
                    echo displayPaidEvents();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px">
                    All Teachers or Officers
                </h2>
                <?php
                    echo displayUserTypes();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px">
                    Number of Males and Females
                </h2>
                <?php
                    echo displayNumberGenderParticipants();
                ?>
            </div>
        </div>

        <div class="report-container">
            <div class="userlist-container">
                <h2 style="padding: 10px">
                    Events of Each Admin
                </h2>
                <?php
                    echo displayEventsByEachAdmin();
                ?>
            </div>
        </div>

        <a href="administratorStudentList.php">
            <button class="hidden" id="reports">Back</button>
        </a>
    </div>
</body>

<?php require_once 'includes/footer.php'; ?>
