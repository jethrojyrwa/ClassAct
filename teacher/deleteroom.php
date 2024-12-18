<?php
    session_start();
    require('con1.php');
    $room_no = $_GET['room_no'];

    $delroomSql = "DELETE FROM room WHERE room_no=$room_no";
    if($conn->query($delroomSql))
    {
        header("Location: viewroom.php");
    }
    else
    {
        echo "<script>windows.alert('Could not delete room')";
        header("Location: viewroom.php");
    }
?>