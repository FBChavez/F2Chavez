<?php
    $connection = new mysqli('localhost', 'root', '', 'dbchavezf2');
    if (!$connection){
        die(mysqli_error($mysqli));
    }

/*
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
*/
?>