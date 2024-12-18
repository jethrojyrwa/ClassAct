<?php
    session_start();
    require('con1.php');

    $qtn_no = $_GET['qtn_no'];
    $active = $_GET['active'];

    if($active==0)
    {
        $sql = "UPDATE question SET active = 1 WHERE qtn_no = $qtn_no";
        if($conn->query($sql))
        {
            header("Location:viewpartroom.php");
        }
        else
        {
            header("Location:viewpartroom.php");
        }
    }
    else
    {
        $sql = "UPDATE question SET active = 0 WHERE qtn_no = $qtn_no";
        if($conn->query($sql))
        {
            header("Location:viewpartroom.php");
        }
        else
        {
            header("Location:viewpartroom.php");
        }
    }
?>