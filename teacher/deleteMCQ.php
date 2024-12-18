<?php
    session_start();
    require('con1.php');
    $qtn_no = $_GET['qtn_no'];
    $sql = "DELETE FROM question WHERE qtn_no = $qtn_no";
    if($conn->query($sql))
    {
        header("Location: viewQuestions.php");
    }
    else
    {
        header("Location: viewQuestions.php");
    }
?>