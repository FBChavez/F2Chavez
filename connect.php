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
        eventdescription VARCHAR(200) NOT NULL,
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
        FOREIGN KEY (eventid) REFERENCES tblevent(eventid)
    )";
/*
    $sql4 = "CREATE TABLE IF NOT EXISTS tbluseraccount (
        accttid INT(10) AUTO_INCREMENT PRIMARY KEY,
        emailadd VARCHAR(50) NOT NULL,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(100) NOT NULL,
        usertype VARCHAR(20) NOT NULL,
        yearlevel INT(5) NOT NULL,
        program VARCHAR(50) NOT NULL
    )";
*/
    $sql4 = "CREATE TABLE IF NOT EXISTS tbluseraccount (
        acctid INT(10) AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        gender VARCHAR(50) NOT NULL,
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
        status VARCHAR(50) DEFAULT 'pending',
        FOREIGN KEY (acctid) REFERENCES tbluseraccount(acctid),
        FOREIGN KEY (eventid) REFERENCES tblevent(eventid)
    )";

    $sql6 = "CREATE TABLE IF NOT EXISTS tbladminuserevent (
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        acctid INT(10) NOT NULL,
        eventid INT(10) NOT NULL,
        adminid INT(10) NOT NULL,
        FOREIGN KEY (acctid) REFERENCES tbluseraccount(acctid),
        FOREIGN KEY (eventid) REFERENCES tblevent(eventid),
        FOREIGN KEY (adminid) REFERENCES tbladmin(adminid)
    )";

/*
    $sql7 = "CREATE TABLE IF NOT EXISTS tbluserprofile (
        userid INT(10) AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        gender VARCHAR(50) NOT NULL
    )";
*/

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
        echo "Error creating table 'tbluseraccount': " . $connection->error . "<br>";
    }

    if($connection->query($sql5) === FALSE) {
        echo "Error creating table 'tbluserevent': " . $connection->error . "<br>";
    }

    if($connection->query($sql6) === FALSE) {
        echo "Error creating table 'tbladminuserevent': " . $connection->error . "<br>";
    }

/*
    if($connection->query($sql7) === FALSE) {
        echo "Error creating table 'tbluserprofile': " . $connection->error . "<br>";
    }
*/

    // Insert two admins: Paul and Francis
    $name1 = 'Paul Thomas M. Abellana';
    $name2 = 'Francis Benedict Y. Chavez';

    $username1 = 'paul';
    $username2 = 'francis';

    $password1 = 'abellana';
    $password2 = 'chavez';

    $hashed_password1 = password_hash($password1, PASSWORD_DEFAULT);
    $hashed_password2 = password_hash($password2, PASSWORD_DEFAULT);

    $check_sql1 = "SELECT * FROM tbladmin WHERE username = ?";
    $stmt1 = mysqli_prepare($connection, $check_sql1);
    mysqli_stmt_bind_param($stmt1, "s", $username1);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $count1 = mysqli_num_rows($result1);

    if ($count1 == 0) {
        $paul_sql = "INSERT INTO tbladmin (name, username, password) VALUES (?, ?, ?)";
        $stmt_paul = mysqli_prepare($connection, $paul_sql);
        mysqli_stmt_bind_param($stmt_paul, "sss", $name1, $username1, $hashed_password1);
        mysqli_stmt_execute($stmt_paul);
        mysqli_stmt_close($stmt_paul);
    }

    $check_sql2 = "SELECT * FROM tbladmin WHERE username = ?";
    $stmt2 = mysqli_prepare($connection, $check_sql2);
    mysqli_stmt_bind_param($stmt2, "s", $username2);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $count2 = mysqli_num_rows($result2);

    if ($count2 == 0) {
        $francis_sql = "INSERT INTO tbladmin (name, username, password) VALUES (?, ?, ?)";
        $stmt_francis = mysqli_prepare($connection, $francis_sql);
        mysqli_stmt_bind_param($stmt_francis, "sss", $name2, $username2, $hashed_password2);
        mysqli_stmt_execute($stmt_francis);
        mysqli_stmt_close($stmt_francis);
    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);

//     // Check if existing na sila duha
//     $check_sql1 = "SELECT * FROM tbladmin WHERE username = $username1";
//     $result1 = mysqli_query($connection, $check_sql1);
//     $count1 = mysqli_num_rows($result1);
//
//     $check_sql2 = "SELECT * FROM tbladmin WHERE username = $username2";
//     $result2 = mysqli_query($connection, $check_sql2);
//     $count2 = mysqli_num_rows($result2);
//
//     if($count1 == 0) {
//         $paul_sql ="Insert into tbladmin(name, username, password)
//         values('".$name1."', '".$username1."', '".$hashed_password1."')";
//         mysqli_query($connection, $paul_sql);
//     }
//
//     if($count2 == 0) {
//         $francis_sql ="Insert into tbladmin(name, username, password)
//         values('".$name2."', '".$username2."', '".$hashed_password2."')";
//         mysqli_query($connection, $francis_sql);
//     }
?>