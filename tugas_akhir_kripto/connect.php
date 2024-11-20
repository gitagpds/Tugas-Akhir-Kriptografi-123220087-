<?php
    $hostname="localhost";
    $username   = "root"; 
    $password   = ""; 
    $database   = "museum";

    $connect=new mysqli($hostname,$username,$password, $database);
    if ($connect->connect_error) 
    {
        die('Sorry Database Not Connected '. $connect->connect_error);
    } 
?>