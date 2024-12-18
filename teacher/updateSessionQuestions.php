<?php
    session_start();
    $room_no = $_GET['room_no'];
    $_SESSION['room_no'] = $room_no;
    header("Location:viewQuestions.php");