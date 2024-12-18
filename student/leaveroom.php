<?php
    session_start();
    require('con1.php');
    $room_no = $_SESSION['room_no'];
    $roll_no = $_SESSION['roll_no'];

    $delSql = "DELETE FROM active_students WHERE roll_no = '$roll_no' AND room_no = $room_no";
    if($conn->query($delSql))
    {
        header("Location: viewstudclass.php");
    }
    else
    {
        header("Location: viewpartstudroom.php");
    }