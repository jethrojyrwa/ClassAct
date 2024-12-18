<?php
    session_start();
    require('con1.php');
    $room_no = $_GET['room_no'];
    $_SESSION['room_no'] = $room_no;
    $_SESSION['room_active'] = 1;
    $sql = "UPDATE room SET active = 1 WHERE room_no = $room_no";
    $conn->query($sql);
    header("Location: viewpartroom.php");
?>