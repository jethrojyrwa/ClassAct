<?php
    session_start();
    $t_id = $_GET['t_id'];
    $_SESSION['t_id'] = $t_id;
    $class_id = $_GET['class_id'];
    $_SESSION['class_id'] = $class_id;
    header("Location: viewstudclass.php");
?>
