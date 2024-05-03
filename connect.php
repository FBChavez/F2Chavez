<?php
    $connection = new mysqli('localhost', 'root', '', 'dbchavezf2');
    if (!$connection){
        die(mysqli_error($mysqli));
    }

    $sql1 = "CREATE TABLE IF NOT EXISTS tbladmin (
        adminid INT(10) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(100) NOT NULL
    )";

    $sql2 = "CREATE TABLE IF NOT EXISTS tblevent (
        eventid INT(10) AUTO_INCREMENT PRIMARY KEY,
        adminid INT(10) NOT NULL,
        eventtitle VARCHAR(50) NOT NULL,
        eventdescription VARCHAR(50) NOT NULL,
        eventvenue VARCHAR(50) NOT NULL,
        eventfee INT(10) NOT NULL,
        date DATE NOT NULL,
        time TIME NOT NULL,
        FOREIGN KEY (adminid) REFERENCES tbladmin(adminid)
    )";

    $sql3 = "CREATE TABLE IF NOT EXISTS tbladminevent (
        admineventid INT(10) AUTO_INCREMENT PRIMARY KEY,
        adminid INT(10) NOT NULL,
        eventid INT(10) NOT NULL,
        FOREIGN KEY (adminid) REFERENCES tbladmin(adminid),
        FOREIGN KEY (eventid) REFERENCES tbladmin(eventid)
    )";

    $sql4 = "CREATE TABLE IF NOT EXISTS tbluseraccount (
        accttid INT(10) AUTO_INCREMENT PRIMARY KEY,
        emailadd VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(100) NOT NULL,
        usertype VARCHAR(20) NOT NULL,
        yearlevel INT(5) NOT NULL,
        program VARCHAR(50) NOT NULL
    )";

    $sql5 = "CREATE TABLE IF NOT EXISTS tbluserevent (
        usereventid INT(10) AUTO_INCREMENT PRIMARY KEY,
        acctid INT(10) NOT NULL,
        eventid INT(10) NOT NULL,
        FOREIGN KEY (acctid) REFERENCES tbluseraccount(acctid),
        FOREIGN KEY (eventid) REFERENCES tblevent(eventid)
    )";

    $sql6 = "CREATE TABLE IF NOT EXISTS tbluserprofile (
        userid INT(10) AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        gender VARCHAR(50) NOT NULL
    )";

    if($connection->query($sql1) === FALSE) {
        /*echo "Table 'tbladmin' created successfully! <br>";
    } else {
        */echo "Error creating table 'tbladmin': " . $connection->error . "<br>";
    }

    if($connection->query($sql2) === FALSE) {
        echo "Error creating table 'tblevent': " . $connection->error . "<br>";
    }

    if($connection->query($sql3) === FALSE) {
        echo "Error creating table 'tbladminevent': " . $connection->error . "<br>";
    }

    if($connection->query($sql4) === FALSE) {
        echo "Error creating table 'tbluserevent': " . $connection->error . "<br>";
    }

    if($connection->query($sql5) === FALSE) {
        echo "Error creating table 'tbladmin': " . $connection->error . "<br>";
    }

    if($connection->query($sql6) === FALSE) {
        echo "Error creating table 'tbluserprofile': " . $connection->error . "<br>";
    }

?>