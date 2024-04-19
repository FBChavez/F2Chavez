<?php
    $connection = new mysqli('localhost', 'root', '', 'dbchavezf2');
    if (!$connection){
        die(mysqli_error($mysqli));
    }
?>