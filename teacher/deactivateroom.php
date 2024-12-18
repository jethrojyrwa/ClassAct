<?php
    session_start();
    require('con1.php');
    $room_no = $_GET['room_no'];

    $sql = "UPDATE room SET active=0 WHERE room_no =$room_no";
    if($conn->query($sql))
    {
        $_SESSION['room_active'] = 0;
        header("Location:viewroom.php");

    }