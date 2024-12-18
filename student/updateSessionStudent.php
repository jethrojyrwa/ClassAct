<?php
    session_start();
    require('con1.php');
    $room_no = $_GET['room_no'];
    $_SESSION['room_no'] = $room_no;
    $roll_no = $_SESSION['roll_no'];
    $sql = "INSERT INTO active_students VALUES(NULL,'$roll_no',$room_no)";
    if($conn->query($sql))
    {
        header("Location: viewpartstudroom.php");
    }
    else{
        header("Location: studenthome.php");
    }
    
?>